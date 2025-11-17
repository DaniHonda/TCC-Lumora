<?php
ob_start();
session_start();
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || $_SESSION['nivel'] != 'admin') {
    header("Location: index.php");
    exit();
}

require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $rm = $_POST["rm"];
    $senha = $_POST["senha"];
    $nivel = $_POST["nivel"];
    $turno = $_POST["turno"];
    $codigo_etec = $_POST["codigo_etec"];

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
    $turno_db = ($nivel === 'aluno') ? $turno : NULL;
    $codigo_etec_db = ($nivel === 'aluno') ? $codigo_etec : NULL;

    $sql = "INSERT INTO tbusuario (nome, rm, codigo_etec, senha, nivel, turno) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysql->con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $nome, $rm, $codigo_etec_db, $senhaHash, $nivel, $turno_db);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: painel_contas.php?status=criado");
        } else {
            header("Location: painel_contas.php?status=erro");
        }
        mysqli_stmt_close($stmt);
    } else {
        header("Location: painel_contas.php?status=erroquery");
    }
} else {
    header("Location: painel_contas.php");
}

$mysql->fechar();
?>