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

// NOVO: Lógica de Checagem de Dia
$hoje = new DateTime('today');
$diaDaSemanaAtual = $hoje->format('N'); // 1 (Segunda) a 7 (Domingo)
$liberarTudo = ($diaDaSemanaAtual == 6 || $diaDaSemanaAtual == 7); // 6=Sábado, 7=Domingo
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AviseJá | Cardápio da Semana</title>
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
                <?php endif; ?>
            </ul>
        </nav> 
    </header>

    <div id='main'>
        <h1 class="cardapio-titulo">Cardápio da Semana</h1>

        <div class="cardapio-container">
            <?php if (!empty($cardapioSemanal)): ?>
                <?php foreach ($cardapioSemanal as $dia => $pratos): ?>
                    <?php
                    $diaEmIngles = $diasSemanaMapa[$dia] ?? '';
                    $dataDoPrato = date('Y-m-d', strtotime("$diaEmIngles this week"));
                    $jaConfirmado = in_array($dataDoPrato, $confirmacoesFeitas);

                    // NOVO: Checagem se o dia deve ser exibido
                    $dataPratoObj = new DateTime($dataDoPrato);
                    $podeExibir = $liberarTudo || ($dataPratoObj >= $hoje);

                    if (!$podeExibir) {
                        continue; // Pula para o próximo dia se não puder ser exibido
                    }
                    ?>
                    <div class="card-dia">
                        <div class="dia-semana"><?php echo $dia; ?></div>
                        <div class="data"><?php echo date('d/m/Y', strtotime($dataDoPrato)); ?></div>

                        <div class="itens">
                            <?php foreach ($pratos as $prato): ?>
                                <p><strong>Prato principal:</strong> <?php echo htmlspecialchars($prato['prato_principal']); ?></p>
                                <?php if (!empty($prato['acompanhamento'])): ?>
                                    <p><strong>Acompanhamento:</strong> <?php echo htmlspecialchars($prato['acompanhamento']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($prato['salada'])): ?>
                                    <p><strong>Salada:</strong> <?php echo htmlspecialchars($prato['salada']); ?></p>
                                <?php endif; ?>
                                <?php if (!empty($prato['sobremesa'])): ?>
                                    <p><strong>Sobremesa:</strong> <?php echo htmlspecialchars($prato['sobremesa']); ?></p>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>

                        <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo' && $_SESSION['nivel'] === 'aluno'): ?>
                            <div class="confirmar-container">
                                <?php if ($jaConfirmado): ?>
                                    <form action="processar_confirmacao.php" method="post" style="margin: 0;">
                                        <input type="hidden" name="data_a_confirmar" value="<?php echo $dataDoPrato; ?>">
                                        <input type="hidden" name="acao" value="cancelar">
                                        <button type="submit" class="btn-cardapio-cancelar btn-confirmar-tamanho" 
                                                onclick="return confirm('Tem certeza que deseja cancelar sua confirmação de refeição para esta data?');">
                                            Cancelar Confirmação
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <form action="processar_confirmacao.php" method="post" style="margin: 0;">
                                        <input type="hidden" name="data_a_confirmar" value="<?php echo $dataDoPrato; ?>">
                                        <input type="hidden" name="acao" value="confirmar">
                                        <button type="submit" class="btn-cardapio btn-confirmar-tamanho">Vou Comer!</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="cardapio-vazio">
                    <p>O cardápio da semana ainda não foi cadastrado.</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo' && ($_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'emp')): ?>
            <a href="gerenciar_cardapio.php" class="btn-cardapio btn-gerenciar-posicao">Gerenciar Cardápio</a>
        <?php endif; ?>

        <p class="obs">
            <strong>*Observações:</strong><br>
            Cardápio sujeito a alterações conforme disponibilidade dos gêneros e hortifrutis.<br>
            As frutas enviadas poderão ser ofertadas aos alunos conforme critério da gestão escolar.
        </p>
    </div>

        <footer>
        <h5>..................................................................................................................................................................................................................................................</h5>
        <p> Copyright © 2025 AviseJá. Desenvolvido por Lumora. </p>
        
    </footer>

</body>
</html>