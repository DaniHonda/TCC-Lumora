<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda+ | Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
 <link rel="stylesheet" href="css/CarCSS.css">
 <link rel="stylesheet" href="css/style.css">
 <header class="cabecalho-fixo">
  <div class="logo">
      <a href="index.php"><span>LUMORA</span></a>
  </div>
  <div class="titulo-app">
      <h1>AviseJá</h1>
  </div>
  <div class="menu-container">
      <button id="menu-btn" class="menu-btn"><i class="fas fa-bars"></i></button>
  </div>
</header>

<nav id="sidemenu" class="sidemenu">
  <button id="close-btn" class="close-btn">&times;</button>
  <ul>
      <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo'): ?>
          <li><a href="#">Minha Conta</a></li>
          <li><a href="principal.php">Cardápio</a></li>
          <?php if ($_SESSION['nivel'] === 'admin'): ?>
              <li><a href="painel_contas.php">Painel de Controle</a></li>
          <?php endif; ?>
          <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="cadastrologin.php">Cadastro</a></li>
          <li><a href="cardapio.html">Cardápio</a></li>
      <?php endif; ?>
  </ul>
</nav>
<div id='main'>
  <div id='navigation'><a class="menu atual" href='#cardapio' onclick='change(event)' id='menupizza'>Pizzas </a><span class='bullet'>.</span>
    <a class="menu" href='#cardapio' onclick='change(event)' id='menunordestina'>Comida nordestina</a> <span class='bullet'>.</span>
    <a class="menu" href='#cardapio' onclick='change(event)' id='menupetiscos'>Petiscos</a><span class='bullet'>.   </span>
    <a class="menu" href='#cardapio' onclick='change(event)' id='menugostosa'>Gostosa</a>
  </div>
  <div id='dynamic'>
    <div class="content" id='pizza'>
      <div class='singleitem'>
        <span class='menuitem'>MUSSARELA</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
      <div class='singleitem'>
        <span class='menuitem'>PORTUGUESA</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
      <div class='singleitem'>
        <span class='menuitem'>CALABRESA</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
    </div>

    <div class="content" id='nordestina'>
      <div class='singleitem'>
        <span class='menuitem'>BUXADA</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
      <div class='singleitem'>
        <span class='menuitem'>FEIJÃO FRADINHO</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
      <div class='singleitem'>
        <span class='menuitem'>DOBRADINHA</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
    </div>

    <div class="content" id='petisco'>
      <div class='singleitem'>
        <span class='menuitem'>BATATA</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
      <div class='singleitem'>
        <span class='menuitem'>LINGUIÇA</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
      <div class='singleitem'>
        <span class='menuitem'>FRANGO A PASSARINHO</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
       </div>
        </div>
        
        <div class="content" id='gostosa'>
      <div class='singleitem'>
        <span class='menuitem'>BATATA iteosotgieop sopiwope</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
      <div class='singleitem'>
        <span class='menuitem'>LINGUIÇA</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
      </div>
      <div class='singleitem'>
        <span class='menuitem'>FRANGO A PASSARINHO</span><span class='p'>P</span><span class='m'>M</span><span class='g'>G</span>
        <p class='text'>Lorem ipsum eros platea curabitur netus leo sociosqu ligula, nibh vel fames ut pharetra posuere fames. aenean laoreet magna sociosqu neque non</p>
        </div>
      </div>
  </div>
</div>
<script src="js/CarJS.js"></script>
<script src="js/login.js"></script>

</body>
</html>