<?php
session_start();
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || ($_SESSION['nivel'] != 'admin' && $_SESSION['nivel'] != 'emp')) {
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Cardápio</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gerenciar.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Barlow|Carter+One&display=swap" rel="stylesheet">
</head>
<body class="body-gerenciar">

    <header class="cabecalho-fixo">
        <div class="logo">
         <a href="index.php">
            <img src="imgs/lumora.png" alt="Logo Lumora" class="logo-img">
        </a>
        </div>
       <nav class="menu-principal">
          <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="cardapio.php">Cardápio</a></li>
            <?php if ($_SESSION['nivel'] === 'admin'): ?>
                <li><a href="painel_contas.php">Painel de Contas</a></li>
            <?php endif; ?>
            <li><a href="logout.php" class="btn-logout">Logout</a></li>
          </ul>
        </nav> 
    </header>

    <main class="gerenciar-container-principal">
        <div class="admin-panel-container">
            <h1>Gerenciamento do Cardápio</h1>

            <div class="painel-acoes">
                <a href="limpar_confirmacoes.php" class="btn-limpar" onclick="return confirm('ATENÇÃO: Isso limpará TODAS as confirmações de TODOS os turnos. Deseja continuar?');">
                    Limpar Confirmações
                </a>
            </div>

            <div class="cardapio-form">
                <h2>Adicionar Novo Prato</h2>
                <form action="processar_cardapio.php?acao=adicionar" method="post">
                    <div class="form-row">
                        <select name="dia_semana" required>
                            <option value="" disabled selected>Selecione o dia *</option>
                            <?php foreach ($diasSemana as $dia) echo "<option value='$dia'>$dia</option>"; ?>
                        </select>
                        <input type="text" name="prato_principal" placeholder="Prato Principal *" required>
                    </div>
                    <div class="form-row">
                        <input type="text" name="acompanhamento" placeholder="Acompanhamento *" required>
                        <input type="text" name="salada" placeholder="Salada">
                        <input type="text" name="sobremesa" placeholder="Sobremesa">
                    </div>
                    <div class="form-row">
                        <button type="submit" class="btn-adicionar-item">Adicionar Item</button>
                    </div>
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
    </main>
    
    <?php $mysql->fechar(); ?>
</body>
</html>