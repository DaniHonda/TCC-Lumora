<?php
session_start();
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || ($_SESSION['nivel'] != 'admin' && $_SESSION['nivel'] != 'emp')) {
    header("Location: index.php");
    exit();
}

require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

$acao = $_GET['acao'] ?? '';

if ($acao == 'adicionar' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $dia_semana = $_POST['dia_semana'];
    $prato_principal = $_POST['prato_principal'];
    $acompanhamento = $_POST['acompanhamento'];
    $salada = $_POST['salada'];
    $sobremesa = $_POST['sobremesa'];

    $sql = "INSERT INTO tb_cardapio (dia_semana, prato_principal, acompanhamento, salada, sobremesa) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysql->con, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $dia_semana, $prato_principal, $acompanhamento, $salada, $sobremesa);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: gerenciar_cardapio.php?status=adicionado");
    } else {
        header("Location: gerenciar_cardapio.php?status=erro");
    }
    mysqli_stmt_close($stmt);

} elseif ($acao == 'excluir' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tb_cardapio WHERE id = ?";
    $stmt = mysqli_prepare($mysql->con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: gerenciar_cardapio.php?status=excluido");
    } else {
        header("Location: gerenciar_cardapio.php?status=erro");
    }
    mysqli_stmt_close($stmt);
}

$mysql->fechar();
?>