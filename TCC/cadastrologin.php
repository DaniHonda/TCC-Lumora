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
    $turno = $_POST["turno"];
    $nivel = 'aluno';

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO tbusuario (nome, rm, codigo_etec, senha, nivel, turno) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysql->con, $sql);

    if ($stmt) {
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
  <link rel="stylesheet" href="css/cadastro.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <div class="container">
    <div class="login-container">
      <p style="align-self: flex-start; margin-left: calc((100% - 400px)/2); margin-top: 38px; margin-bottom: 10px;">
        Olá, crie sua conta
      </p>

      <form action="cadastrologin.php" method="POST">
        <h5>Nome completo</h5>
        <input type="text" name="nome" required>

        <h5>Código da Etec</h5>
        <input type="text" name="codigo_etec" required>

        <h5>RM</h5>
        <input type="text" name="rm" required>

        <h5>Turno</h5>
        <select name="turno" required>
          <option value="" disabled selected>Selecione seu turno</option>
          <option value="Manhã">Manhã</option>
          <option value="Tarde">Tarde</option>
          <option value="Noite">Noite</option>
        </select>

        <h5>Senha</h5>
        <input type="password" name="senha" required>

        <input type="submit" value="Cadastrar">

        <a href="login.php" class="botao-cadastro">Já tem uma conta? Faça login</a>
      </form>

      <?php if (isset($erro)) echo "<p style='color:red; text-align:center; margin-top:10px;'>$erro</p>"; ?>

      <a href="index.php" class="botao-voltar"><i class="fas fa-arrow-left"></i> Voltar para Home</a>
    </div>

    <div class="imagem">
      <a href="index.php">
        <img src="imgs/lumora.png" alt="Logo Lumora" class="logo">
      </a>
      <img src="imgs/personagem2.svg" alt="Ilustração de cadastro" class="svg-cadastro">
    </div>
  </div>
</body>
</html>
