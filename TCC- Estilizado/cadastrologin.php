<?php
include("conexao/conexao.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mysql = new BancodeDados();
    $mysql->conecta();

    $nome = $_POST["nome"];
    $rm = $_POST["rm"];
    $codigo_etec = $_POST["codigo_etec"];
    $senha = $_POST["senha"];
    $turno = $_POST["turno"]; // Captura o novo campo
    $nivel = 'aluno'; 

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // SQL atualizado para incluir a coluna 'turno'
    $sql = "INSERT INTO tbusuario (nome, rm, codigo_etec, senha, nivel, turno) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysql->con, $sql);

    if ($stmt) {
        // Parâmetro do bind atualizado para incluir o turno (string -> "ssssss")
        mysqli_stmt_bind_param($stmt, "ssssss", $nome, $rm, $codigo_etec, $senhaHash, $nivel, $turno);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: login.php?status=cadastrado");
            exit();
        } else {
            if (mysqli_errno($mysql->con) == 1062) {
                 $erro = "Erro: Este RM já está cadastrado para esta Etec.";
            } else {
                 $erro = "Erro ao cadastrar: " . mysqli_error($mysql->con);
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        $erro = "Erro ao preparar a query: " . mysqli_error($mysql->con);
    }
    
    $mysql->fechar();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Ajuda+</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="body-login">

    <header class="cabecalho-fixo">
        <div class="logo">
            <a href="index.php"><span>LUMORA</span></a>
        </div>
        <div class="titulo-app"><h1>AviseJá</h1></div>
    </header>

    <div class="login-container">
        <div class="login-box">
            <h1>Cadastro de Aluno</h1>
            <form action="cadastrologin.php" method="post">
                <input type="text" name="nome" placeholder="Seu nome completo" required>
                <input type="text" name="codigo_etec" placeholder="Código da sua Etec (Ex: 118)" required>
                <input type="text" name="rm" placeholder="Seu RM (Registro de Matrícula)" required>
                
                <select name="turno" required>
                    <option value="" disabled selected>Selecione seu turno</option>
                    <option value="Manhã">Manhã</option>
                    <option value="Tarde">Tarde</option>
                    <option value="Noite">Noite</option>
                </select>

                <input type="password" name="senha" placeholder="Crie uma senha" required>
                <input type="submit" value="Cadastrar">
                <a href="index.php" class="botao-voltar">Voltar para Home</a>
            </form>
            <?php if (isset($erro)) echo "<p style='color:red; text-align:center; margin-top:10px;'>$erro</p>"; ?>
        </div>
    </div>

    <script src="js/login.js"></script>
</body>
</html>