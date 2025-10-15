<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Ajuda+</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    
     <div class="container">

    <div class="imagem">
        <div class="logo">
         <a href="index.php">
            <img src="imgs/lumora.png" alt="Logo Lumora" class="logo-img">
            <br> <br> <br> <br> <br> 
        </a>
</div>
        <img src="imgs/personagem.svg" alt="Login" width="400" />
</div>
    

    <div class="login-container">
        
         <p> <b> Olá, acesse a sua conta! </b> </p>
            
            <form action="entrada.php" method="post" id="login_form">
              <h5>  Código da sua Etec </h5>
                <input type="text" id="codigo_etec" name="codigo_etec" required>
                <h5>  Seu RM </h5>
                <input type="text" id="rm_input" name="rm" required>
                              <h5>  Sua Senha </h5>
                <input type="password" name="senha" required>
                <input type="submit" value="Entrar" id="submit_button">
                <a href="cadastrologin.php" class="botao-cadastro">Não tenho cadastro</a>
                 <a href="index.php" class="botao-voltar"> ⬅ Voltar para Home </a>
            </form>
        </div>
    <script src="js/login.js"></script>
</body>
</html>