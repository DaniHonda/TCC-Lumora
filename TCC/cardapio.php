<?php
session_start();
require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

$cardapioSemanal = [];
$sql = "SELECT * FROM tb_cardapio ORDER BY FIELD(dia_semana, 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira')";
$query = mysqli_query($mysql->con, $sql);
while($row = mysqli_fetch_assoc($query)) {
    $cardapioSemanal[$row['dia_semana']][] = $row;
}

$confirmacoesFeitas = [];
if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo' && $_SESSION['nivel'] === 'aluno' && !empty($_SESSION['turno'])) {
    $mapaTabelas = [
        'Manhã' => 'tb_confirmacoes_manha',
        'Tarde' => 'tb_confirmacoes_tarde',
        'Noite' => 'tb_confirmacoes_noite'
    ];
    $tabela_confirmacao = $mapaTabelas[$_SESSION['turno']] ?? null;

    if ($tabela_confirmacao) {
        $id_usuario = $_SESSION['id'];
        $sql_confirmacoes = "SELECT data_confirmacao FROM `$tabela_confirmacao` WHERE id_usuario = ?";
        $stmt = mysqli_prepare($mysql->con, $sql_confirmacoes);
        mysqli_stmt_bind_param($stmt, "i", $id_usuario);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $confirmacoesFeitas[] = $row['data_confirmacao'];
        }
        mysqli_stmt_close($stmt);
    }
}

$diasSemanaMapa = [
    'Segunda-feira' => 'monday', 'Terça-feira' => 'tuesday',
    'Quarta-feira'  => 'wednesday', 'Quinta-feira' => 'thursday',
    'Sexta-feira'   => 'friday'
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda+ | Cardápio da Semana</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/CarCSS.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
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
            <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo'): ?>
                <?php if ($_SESSION['nivel'] === 'admin'): ?>
                    <li><a href="painel_contas.php">Painel de Controle</a></li>
                <?php endif; ?>
                <li><a href="logout.php" class="btn-logout">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php" class="btn-login">Login</a></li>
                <li><a href="cadastrologin.php" class="btn-cadastro">Cadastro</a></li>
            <?php endif; ?>
          </ul>
        </nav> 
    </header>

    <div id='main'>
        <div class="cardapio-container">
            <h1 class="cardapio-titulo">Cardápio da Semana</h1>
            <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo' && ($_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'emp')): ?>
                <a href="gerenciar_cardapio.php" class="btn-cardapio btn-gerenciar-posicao">Gerenciar Cardápio</a>
            <?php endif; ?>
            
            <?php if (!empty($cardapioSemanal)): ?>
                <?php foreach ($cardapioSemanal as $dia => $pratos): ?>
                    <?php
                    $diaEmIngles = $diasSemanaMapa[$dia] ?? '';
                    $dataDoPrato = date('Y-m-d', strtotime("$diaEmIngles this week"));
                    $jaConfirmado = in_array($dataDoPrato, $confirmacoesFeitas);
                    ?>
                    <div class="dia-cardapio">
                        <h2 class="dia-titulo"><?php echo $dia; ?></h2>
                        <div class="pratos-container">
                            <?php foreach ($pratos as $prato): ?>
                                <div class='singleitem'>
                                    <div class="item-info">
                                        <span class='menuitem'><?php echo htmlspecialchars($prato['prato_principal']); ?></span>
                                        <p class='text'>
                                            <?php if (!empty($prato['acompanhamento'])): ?>
                                                <strong>Acompanhamento:</strong> <?php echo htmlspecialchars($prato['acompanhamento']); ?><br>
                                            <?php endif; ?>
                                            <?php if (!empty($prato['salada'])): ?>
                                                <strong>Salada:</strong> <?php echo htmlspecialchars($prato['salada']); ?><br>
                                            <?php endif; ?>
                                            <?php if (!empty($prato['sobremesa'])): ?>
                                                <strong>Sobremesa:</strong> <?php echo htmlspecialchars($prato['sobremesa']); ?>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo' && $_SESSION['nivel'] === 'aluno'): ?>
                                        <div class="confirmar-container">
                                            <?php if ($jaConfirmado): ?>
                                                <button type="button" class="btn-cardapio btn-confirmar-tamanho btn-confirmado" disabled>Confirmado</button>
                                            <?php else: ?>
                                                <form action="processar_confirmacao.php" method="post" style="margin: 0;">
                                                    <input type="hidden" name="data_a_confirmar" value="<?php echo $dataDoPrato; ?>">
                                                    <button type="submit" class="btn-cardapio btn-confirmar-tamanho">Vou Comer!</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="cardapio-vazio">
                    <p>O cardápio da semana ainda não foi cadastrado.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>
</html>