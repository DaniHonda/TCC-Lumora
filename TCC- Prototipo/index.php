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
    <div id="overlay" class="overlay"></div>

    <main class="conteudo-principal">
        <section class="sobre-nos">
            <h2>Nossa História e Visão</h2>
            <p>O <strong>Ajuda+</strong> é mais que um projeto; é a materialização de um ideal. Somos a <strong>LUMORA</strong>, uma equipe de estudantes da Etec de Poá que enxergou na tecnologia uma poderosa aliada para solucionar um problema crônico e muitas vezes invisível: o desperdício de alimentos em nossa própria comunidade escolar. Observando a quantidade de comida descartada diariamente, decidimos agir.</p>
            <p>Nossa visão é criar um futuro onde cada refeição é valorizada e cada recurso é aproveitado ao máximo. Com o Ajuda+, transformamos a incerteza em dados precisos, permitindo que a cozinha escolar prepare exatamente o necessário. É a união da inovação com a responsabilidade social, um passo de cada vez, para construir um ambiente mais sustentável e consciente para todos.</p>
            <p>Este projeto foi idealizado e desenvolvido por:</p>
            <ul>
                <li>Arthur Leon Adolpho Drigo</li>
                <li>Danilo Valiceli dos Santos</li>
                <li>João Bernardo de Moraes Cinta Miguel</li>
                <li>Lucas Bordigoni Gambassi</li>
                <li>Lucas de Souza Oliveira</li>
            </ul>
        </section>

        <section class="conscientizacao">
            <h2>O Desperdício de Alimentos: Um Problema de Todos</h2>
            <p>O desperdício de alimentos é uma questão crítica no Brasil e no mundo. Ele não apenas representa uma perda de recursos valiosos, mas também agrava problemas sociais e ambientais.</p>
            <div class="dados-container">
                <div class="dado-card">
                    <h3>Top 10 Mundial</h3>
                    <p>O Brasil está entre os 10 países que mais desperdiçam alimentos no mundo.</p>
                </div>
                <div class="dado-card">
                    <h3>30% da Produção</h3>
                    <p>Cerca de 30% de toda a comida produzida no país é descartada, um volume que poderia alimentar milhões de pessoas.</p>
                </div>
                <div class="dado-card">
                    <h3>Impacto Ambiental</h3>
                    <p>O desperdício alimentar é responsável por até 10% das emissões globais de gases de efeito estufa, contribuindo para as mudanças climáticas.</p>
                </div>
                 <div class="dado-card">
                    <h3>Nas Escolas</h3>
                    <p>No setor de serviços, que inclui as escolas, o descarte de alimentos também é significativo, podendo chegar a 26% de todo o desperdício mundial.</p>
                </div>
            </div>
            <p>Nossa plataforma busca combater esse cenário diretamente na fonte, fornecendo dados precisos para que a produção de merendas seja feita na quantidade certa, evitando sobras e conscientizando a comunidade escolar sobre seu papel nessa luta.</p>
        </section>
    </main>

    <footer>
        <p>© 2025 LUMORA | Todos os direitos reservados.</p>
    </footer>

    <script src="js/login.js"></script>
</body>
</html>