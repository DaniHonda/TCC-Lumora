<?php
session_start();
?>
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
    <li><a href="#equipe">Nossa Equipe</a></li>
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

   <section class="bloco-galaxia">
  <div class="conteudo-galaxia">
    <h2>AviseJá, a solução para o desperdício!</h2>
    <a href="#quem-somos" class="btn-galaxia"> Confira Aqui <i class="fas fa-arrow-right"></i></a>
  </div>
  <div class="linha-branca"></div>
    <svg class="curva-transicao" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
  <path fill="#fff" fill-opacity="1" d="M0,192L80,170.7C160,149,320,107,480,101.3C640,96,800,128,960,144C1120,160,1280,160,1360,160L1440,160L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
</svg>

</section>


    <main class="conteudo-principal">

        <section id="quem-somos" class="sobre-nos">
  <div class="texto">
    <h4>SOBRE NÓS</h4>
    <h2>Quem Somos?</h2>
    <p>
      O AviseJá é mais que um projeto; é a materialização de um ideal. Somos a LUMORA, uma equipe de estudantes da Etec de Poá que enxergou na tecnologia uma poderosa aliada para solucionar um problema crônico e muitas vezes invisível: o desperdício de alimentos em nossa própria comunidade escolar. Observando a quantidade de comida descartada diariamente, decidimos agir.
    </p>
  </div>
  <div class="imagem">
    <img src=".jpg" alt="equipe">
  </div>
</section>

  <section class="nossa-visao">
    <div class="imagem">
    <img src="imgs/merenda.jpg" alt="Equipe Lumora">
  </div>
  <div class="texto">
    <h4>NOSSA VISÃO</h4>
    <h2>O Que Queremos?</h2>
    <p>
      Nossa visão é criar um futuro onde cada refeição é valorizada e cada recurso é aproveitado ao máximo. Com o Ajuda+, transformamos a incerteza em dados precisos, permitindo que a cozinha escolar prepare exatamente o necessário. É a união da inovação com a responsabilidade social, um passo de cada vez, para construir um ambiente mais sustentável e consciente para todos.
    </p>
  </div>
  
</section>

        <section class="desperdicio">

  <svg class="onda cima" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 240" preserveAspectRatio="none" aria-hidden="true">
  <path fill="#ffffff" d="M0,0 L1440,0 L1440,80 C1200,120 960,40 720,80 C480,120 240,40 0,80 Z"></path>
</svg>
  <div class="conteudo-desperdicio">
    <h2>O Desperdício de Alimentos: <span>Um Problema de Todos</span></h2>
    <p>
      O desperdício de alimentos é uma questão crítica no Brasil e no mundo. Ele não apenas representa uma perda de recursos valiosos, mas também agrava problemas sociais e ambientais.
    </p>

    <div class="cards">
      <div class="card">
        <i class="fas fa-globe"></i>
        <h3>Top 10 Mundial</h3>
        <p>O Brasil está entre os 10 países que mais desperdiçam alimentos no mundo.</p>
      </div>

      <div class="card">
        <i class="fas fa-apple-alt"></i>
        <h3>30% da produção</h3>
        <p>Cerca de 30% de toda a comida produzida no país é descartada.</p>
      </div>

      <div class="card">
        <i class="fas fa-cloud"></i>
        <h3>10% das emissões</h3>
        <p>O desperdício alimentar gera até 10% dos gases de efeito estufa no mundo.</p>
      </div>

      <div class="card">
        <i class="fas fa-school"></i>
        <h3>Nas Escolas</h3>
        <p>No setor de serviços (inclui escolas) o descarte pode chegar a 26% do total mundial.</p>
      </div>
    </div>

    <p class="final-text">
      Nossa plataforma combate esse cenário na fonte, garantindo <b>merenda na medida certa</b> e engajando toda a comunidade escolar nessa causa.
    </p>
  </div>

  <svg class="onda baixo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 240" preserveAspectRatio="none" aria-hidden="true">
  <path fill="#ffffff" d="M0,160 C360,140 720,200 1080,160 C1320,135 1440,120 1440,120 L1440,240 L0,240 Z"></path>
</svg>
</section>

<section id="equipe" class="nossa-equipe">
    <h2>Conheça a Equipe</h2>
    <div class="container-equipe">
        
        <div class="card-equipe">
            <img src="caminho/para/foto-arthur.jpg" alt="adolpho" class="foto-membro">
            <h3>Arthur Leon Adolpho Drigo</h3>
            <p>Auxiliar de Backend e Documentação</p>
        </div>

        <div class="card-equipe">
            <img src=".jpg" alt="danilo" class="foto-membro">
            <h3>Danilo Valiceli dos Santos</h3>
            <p>Programador Backend</p>
        </div>

        <div class="card-equipe">
            <img src="jpg" alt="joao" class="foto-membro">
            <h3>João Bernardo de Moraes Cinta Miguel</h3>
            <p>Programador Backend e Documentação</p>
        </div>

        <div class="card-equipe">
            <img src="jpg" alt="bordigoni" class="foto-membro">
            <h3>Lucas Bordigoni Gambassi</h3>
            <p>Programador Frontend</p>
        </div>

        <div class="card-equipe">
            <img src=".jpg" alt="lucas" class="foto-membro">
            <h3>Lucas de Souza Oliveira</h3>
            <p>Programador Frontend</p>
        </div>

    </div>
</section>

        
    </main>
    <footer>
        <h5>..................................................................................................................................................................................................................................................</h5>
        <p> Copyright © 2025 AviseJá. Desenvolvido por Lumora. </p>
        
    </footer>
           
    <script src="js/login.js"></script>
</body>
</html>