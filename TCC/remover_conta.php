<?php
session_start();

if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || $_SESSION['nivel'] != 'admin') {
    header("Location: index.php");
    exit();
}

require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

if (isset($_GET['id'])) {
    $id_para_remover = base64_decode($_GET['id']);

    if ($id_para_remover == 1) {
        header("Location: painel_contas.php?status=erro_admin");
        exit();
    }

    $sql = "DELETE FROM tbusuario WHERE id = ?";
    $stmt = mysqli_prepare($mysql->con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id_para_remover);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: painel_contas.php?status=removido");
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