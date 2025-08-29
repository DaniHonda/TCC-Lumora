<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Ajuda+</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body class="body-login">
    <div class="login-container">
        <div class="login-box">
            <header class="cabecalho-fixo">
        <div class="logo">
            <a href="index.php"><span>LUMORA</span></a>
        </div>
        <div class="titulo-app">
            <h1>AviseJá</h1>
        </div>
    </header>
            <h1>Login</h1>
            <p style="text-align: center; margin-top: -10px; margin-bottom: 20px;">Acesse sua conta para continuar.</p>
            
            <form action="entrada.php" method="post">
                <input type="text" id="codigo_etec" name="codigo_etec" placeholder="Código da sua Etec" required>
                <input type="text" id="rm_input" name="rm" placeholder="Seu RM (ou 'adm')" required>
                <input type="password" name="senha" placeholder="Sua senha" required>
                <input type="submit" value="Entrar">
                <a href="cadastrologin.php" class="botao-cadastro">Não tenho cadastro</a>
                 <a href="index.php" class="botao-voltar">Voltar para Home</a>
            </form>
        </div>
    </div>
    <script src="js/login.js"></script>
</body>
</html>