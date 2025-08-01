<?php
require_once('conexao/conexao.php');

$mysql = new BancodeDados();
$mysql->conecta();

$p_rm = $_POST['rm'];
$p_codigo_etec = $_POST['codigo_etec'];
$p_senha = $_POST['senha'];

$sqlstring = "";
$stmt = null;

if ($p_rm === 'adm') {
    $sqlstring = "SELECT id, nome, senha, nivel FROM tbusuario WHERE rm = ? AND nivel = 'admin'";
    $stmt = mysqli_prepare($mysql->con, $sqlstring);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $p_rm);
    }
} else {
    $sqlstring = "SELECT id, nome, senha, nivel FROM tbusuario WHERE rm = ? AND codigo_etec = ? AND nivel = 'aluno'";
    $stmt = mysqli_prepare($mysql->con, $sqlstring);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $p_rm, $p_codigo_etec);
    }
}

$login_sucesso = false;

if ($stmt) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows == 1) {
        $dados = mysqli_fetch_assoc($result);
        
        if (password_verify($p_senha, $dados['senha'])) {
            $login_sucesso = true;
            session_start();
            $_SESSION['id'] = $dados['id'];
            $_SESSION['nome'] = $dados['nome'];
            $_SESSION['nivel'] = $dados['nivel'];
            $_SESSION['log'] = 'ativo';

            header("Location: index.php");
            exit();
        }
    }
}

if (!$login_sucesso) {
    echo "<script>
            alert('Dados de login inválidos! Verifique o Código da Etec, RM e Senha.');
            window.location.href='index.php';
          </script>";
}

if ($stmt) {
    mysqli_stmt_close($stmt);
}
$mysql->fechar();
?>