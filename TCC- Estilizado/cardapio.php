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
    <li><a href="cardapio.php">Cardápio</a></li
    <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo'): ?>
        <li><a href="#">Minha Conta</a></li>
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

    <nav id="sidemenu" class="sidemenu">
      <button id="close-btn" class="close-btn">&times;</button>
      <ul>
          <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo'): ?>
              <li><a href="#">Minha Conta</a></li>
              <li><a href="cardapio.php">Cardápio</a></li>
              <?php if ($_SESSION['nivel'] === 'admin' || $_SESSION['nivel'] === 'emp'): ?>
                  <li><a href="gerenciar_cardapio.php">Gerenciar Cardápio</a></li>
              <?php endif; ?>
              <?php if ($_SESSION['nivel'] === 'admin'): ?>
                  <li><a href="painel_contas.php">Painel de Contas</a></li>
              <?php endif; ?>
              <li><a href="logout.php">Logout</a></li>
          
      </ul>
    </nav>
    <div id="overlay" class="overlay"></div>

    <div id='main'>
        <!-- Added container for better organization and spacing -->
        <div class="cardapio-container">
            <h1 class="cardapio-titulo">Cardápio da Semana</h1>
            
            <?php foreach ($cardapioSemanal as $dia => $pratos): ?>
                <div class="dia-cardapio">
                    <h2 class="dia-titulo"><?php echo $dia; ?></h2>
                    <div class="pratos-container">
                        <?php foreach ($pratos as $prato): ?>
                            <div class='singleitem'>
                                <span class='menuitem'><?php echo htmlspecialchars($prato['prato_principal']); ?></span>
                                <p class='text'>
                                    <strong>Acompanhamento:</strong> <?php echo htmlspecialchars($prato['acompanhamento']); ?><br>
                                    <strong>Salada:</strong> <?php echo htmlspecialchars($prato['salada']); ?><br>
                                    <strong>Sobremesa:</strong> <?php echo htmlspecialchars($prato['sobremesa']); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($cardapioSemanal)): ?>
                <div class="cardapio-vazio">
                    <p>O cardápio da semana ainda não foi cadastrado.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>
</html>
