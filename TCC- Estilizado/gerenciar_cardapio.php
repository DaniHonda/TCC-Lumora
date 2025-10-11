<?php
session_start();
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || ($_SESSION['nivel'] != 'admin' && $_SESSION['nivel'] != 'emp')) {
    echo "<script>alert('Acesso permitido somente para administradores ou funcionários!');window.location.href='index.php';</script>";
    exit();
}
require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

$diasSemana = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira'];

// --- NOVA LÓGICA DE CONTAGEM ---
// 1. Inicializa um array com a contagem de todos os dias como 0.
$contagemConfirmacoes = array_fill_keys($diasSemana, 0);

// 2. Cria a query para contar as confirmações da semana atual, agrupando por dia.
// YEARWEEK(data, 1) considera que a semana começa na Segunda-feira.
$sql_contagem = "
    SELECT
        CASE DAYOFWEEK(data_confirmacao)
            WHEN 2 THEN 'Segunda-feira'
            WHEN 3 THEN 'Terça-feira'
            WHEN 4 THEN 'Quarta-feira'
            WHEN 5 THEN 'Quinta-feira'
            WHEN 6 THEN 'Sexta-feira'
        END as dia_semana_nome,
        COUNT(id) as total
    FROM
        tb_confirmacoes
    WHERE
        YEARWEEK(data_confirmacao, 1) = YEARWEEK(CURDATE(), 1)
    GROUP BY
        dia_semana_nome
";

// 3. Executa a query e preenche o array com os totais encontrados.
$query_contagem = mysqli_query($mysql->con, $sql_contagem);
if ($query_contagem) {
    while ($dados_contagem = mysqli_fetch_assoc($query_contagem)) {
        if (!empty($dados_contagem['dia_semana_nome'])) {
            $contagemConfirmacoes[$dados_contagem['dia_semana_nome']] = $dados_contagem['total'];
        }
    }
}
// --- FIM DA LÓGICA DE CONTAGEM ---

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Gerenciar Cardápio</title>
    <link rel="stylesheet" href="css/painelstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="body-admin-panel">
    <header class="cabecalho-fixo">
        <div class="logo">
            <a href="index.php"><span>LUMORA</span></a>
        </div>
        <div class="titulo-app">
            <h1>Gerenciar Cardápio</h1>
        </div>
        <div class="menu-container">
             <?php if ($_SESSION['nivel'] === 'admin'): ?>
                <a href="painel_contas.php" class="btn-panel-secondary">Painel de Contas</a>
             <?php endif; ?>
             <a href="index.php" class="btn-panel-secondary">Voltar à Home</a>
        </div>
    </header>

    <div class="admin-panel-container">
        <h1>Cardápio da Semana</h1>

        <div class="cardapio-form">
            <h2>Adicionar Item ao Cardápio</h2>
            <form action="processar_cardapio.php?acao=adicionar" method="post">
                <select name="dia_semana" required>
                    <option value="">Selecione o dia da semana</option>
                    <?php foreach ($diasSemana as $dia) echo "<option value='$dia'>$dia</option>"; ?>
                </select>
                <input type="text" name="prato_principal" placeholder="Prato Principal" required>
                <input type="text" name="acompanhamento" placeholder="Acompanhamento">
                <input type="text" name="salada" placeholder="Salada">
                <input type="text" name="sobremesa" placeholder="Sobremesa">
                <input type="submit" value="Adicionar Item" class="btn-panel-primary">
            </form>
        </div>

        <div class="table-responsive-panel">
            <table class="product-data-table">
                <thead>
                    <tr>
                        <th>Dia da Semana</th>
                        <th>Prato Principal</th>
                        <th>Acompanhamento</th>
                        <th>Salada</th>
                        <th>Sobremesa</th>
                        <th>Confirmados</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM tb_cardapio ORDER BY FIELD(dia_semana, 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira')";
                    $query = mysqli_query($mysql->con, $sql);
                    while ($dados = mysqli_fetch_array($query)) :
                        // Pega a contagem para o dia da semana atual da linha
                        $dia = $dados['dia_semana'];
                        $confirmadosDoDia = $contagemConfirmacoes[$dia] ?? 0;
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dados['dia_semana']); ?></td>
                            <td><?php echo htmlspecialchars($dados['prato_principal']); ?></td>
                            <td><?php echo htmlspecialchars($dados['acompanhamento']); ?></td>
                            <td><?php echo htmlspecialchars($dados['salada']); ?></td>
                            <td><?php echo htmlspecialchars($dados['sobremesa']); ?></td>
                            <td><strong><?php echo $confirmadosDoDia; ?></strong></td>
                            <td class="actions-cell">
                                <a href="processar_cardapio.php?acao=excluir&id=<?php echo $dados['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este item?');" class="btn-panel-danger btn-sm">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php $mysql->fechar(); ?>
</body>
</html>