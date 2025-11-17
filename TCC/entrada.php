<?php
require_once('conexao/conexao.php');

$mysql = new BancodeDados();
$mysql->conecta();

$p_rm = $_POST['rm'];
$p_codigo_etec = $_POST['codigo_etec'];
$p_senha = $_POST['senha'];

$login_sucesso = false;
$dados_usuario = null;

$sql_admin_emp = "SELECT id, nome, senha, nivel FROM tbusuario WHERE rm = ? AND (nivel = 'admin' OR nivel = 'emp')";
$stmt = mysqli_prepare($mysql->con, $sql_admin_emp);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $p_rm);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 1) {
        $dados_usuario = mysqli_fetch_assoc($result);
    }
    mysqli_stmt_close($stmt);
}

if (!$dados_usuario && !empty($p_codigo_etec)) {
    $sql_aluno = "SELECT id, nome, senha, nivel, turno FROM tbusuario WHERE rm = ? AND codigo_etec = ? AND nivel = 'aluno'";
    $stmt = mysqli_prepare($mysql->con, $sql_aluno);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $p_rm, $p_codigo_etec);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result->num_rows == 1) {
            $dados_usuario = mysqli_fetch_assoc($result);
        }
        mysqli_stmt_close($stmt);
    }
}

if ($dados_usuario && password_verify($p_senha, $dados_usuario['senha'])) {
    $login_sucesso = true;
    session_start();
    $_SESSION['id'] = $dados_usuario['id'];
    $_SESSION['nome'] = $dados_usuario['nome'];
    $_SESSION['nivel'] = $dados_usuario['nivel'];
    if ($dados_usuario['nivel'] === 'aluno') {
        $_SESSION['turno'] = $dados_usuario['turno'];
    }
    $_SESSION['log'] = 'ativo';

    header("Location: index.php");
    exit();
}

if (!$login_sucesso) {
    echo "<script>
            alert('Dados de login inválidos! Verifique o Código da Etec, RM e Senha.');
            window.location.href='login.php';
          </script>";
}

$mysql->fechar();
?>