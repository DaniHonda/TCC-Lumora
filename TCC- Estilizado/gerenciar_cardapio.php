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
$turnos = ['Manhã', 'Tarde', 'Noite'];
$mapaTabelas = [
    'Manhã' => 'tb_confirmacoes_manha',
    'Tarde' => 'tb_confirmacoes_tarde',
    'Noite' => 'tb_confirmacoes_noite'
];

$contagemConfirmacoes = [];
foreach ($diasSemana as $dia) {
    foreach ($turnos as $turno) {
        $contagemConfirmacoes[$dia][$turno] = 0;
    }
}

foreach ($turnos as $turno) {
    $tabela = $mapaTabelas[$turno];
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
            `$tabela`
        WHERE
            YEARWEEK(data_confirmacao, 1) = YEARWEEK(CURDATE(), 1)
        GROUP BY
            dia_semana_nome
    ";

    $query_contagem = mysqli_query($mysql->con, $sql_contagem);
    if ($query_contagem) {
        while ($dados_contagem = mysqli_fetch_assoc($query_contagem)) {
            $dia = $dados_contagem['dia_semana_nome'];
            if (!empty($dia)) {
                $contagemConfirmacoes[$dia][$turno] = $dados_contagem['total'];
            }
        }
    }
}
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
                        <th rowspan="2">Dia da Semana</th>
                        <th rowspan="2">Prato Principal</th>
                        <th rowspan="2">Acompanhamento</th>
                        <th rowspan="2">Salada</th>
                        <th rowspan="2">Sobremesa</th>
                        <th colspan="3">Confirmados por Turno</th>
                        <th rowspan="2">Ações</th>
                    </tr>
                    <tr>
                        <th>Manhã</th>
                        <th>Tarde</th>
                        <th>Noite</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_cardapio = "SELECT * FROM tb_cardapio ORDER BY FIELD(dia_semana, 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira')";
                    $query_cardapio = mysqli_query($mysql->con, $sql_cardapio);
                    while ($dados = mysqli_fetch_array($query_cardapio)) :
                        $dia = $dados['dia_semana'];
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dados['dia_semana']); ?></td>
                            <td><?php echo htmlspecialchars($dados['prato_principal']); ?></td>
                            <td><?php echo htmlspecialchars($dados['acompanhamento']); ?></td>
                            <td><?php echo htmlspecialchars($dados['salada']); ?></td>
                            <td><?php echo htmlspecialchars($dados['sobremesa']); ?></td>
                            <td><strong><?php echo $contagemConfirmacoes[$dia]['Manhã']; ?></strong></td>
                            <td><strong><?php echo $contagemConfirmacoes[$dia]['Tarde']; ?></strong></td>
                            <td><strong><?php echo $contagemConfirmacoes[$dia]['Noite']; ?></strong></td>
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