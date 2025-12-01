<?php
session_start();

if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || $_SESSION['nivel'] != 'aluno' || empty($_SESSION['turno'])) {
    header("Location: cardapio.php");
    exit();
}

require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

$mapaTabelas = [
    'Manhã' => 'tb_confirmacoes_manha',
    'Tarde' => 'tb_confirmacoes_tarde',
    'Noite' => 'tb_confirmacoes_noite'
];

$turno_usuario = $_SESSION['turno'];
$tabela_confirmacao = $mapaTabelas[$turno_usuario] ?? null;

if (!$tabela_confirmacao || $_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['data_a_confirmar'])) {
    header("Location: cardapio.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$data_confirmacao = $_POST['data_a_confirmar'];
$acao = $_POST['acao'] ?? 'confirmar';

$is_confirmed = false;
$sql_check = "SELECT id FROM `$tabela_confirmacao` WHERE id_usuario = ? AND data_confirmacao = ?";
$stmt_check = mysqli_prepare($mysql->con, $sql_check);
mysqli_stmt_bind_param($stmt_check, "is", $id_usuario, $data_confirmacao);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) > 0) {
    $is_confirmed = true;
}
mysqli_stmt_close($stmt_check);

if ($acao == 'cancelar') {
    if ($is_confirmed) {
        $sql_delete = "DELETE FROM `$tabela_confirmacao` WHERE id_usuario = ? AND data_confirmacao = ?";
        $stmt_delete = mysqli_prepare($mysql->con, $sql_delete);

        if ($stmt_delete) {
            mysqli_stmt_bind_param($stmt_delete, "is", $id_usuario, $data_confirmacao);
            if (mysqli_stmt_execute($stmt_delete)) {
                header("Location: cardapio.php?status=cancelado");
            } else {
                header("Location: cardapio.php?status=erro_cancelar");
            }
            mysqli_stmt_close($stmt_delete);
        } else {
            header("Location: cardapio.php?status=erroquery_cancelar");
        }
    } else {
        header("Location: cardapio.php?status=nao_confirmado");
    }
} elseif ($acao == 'confirmar') {
    if (!$is_confirmed) {
        $sql_insert = "INSERT INTO `$tabela_confirmacao` (id_usuario, data_confirmacao, vai_comer) VALUES (?, ?, 1)";
        $stmt_insert = mysqli_prepare($mysql->con, $sql_insert);
        
        if ($stmt_insert) {
            mysqli_stmt_bind_param($stmt_insert, "is", $id_usuario, $data_confirmacao);
            if (mysqli_stmt_execute($stmt_insert)) {
                header("Location: cardapio.php?status=confirmado");
            } else {
                header("Location: cardapio.php?status=erro");
            }
            mysqli_stmt_close($stmt_insert);
        } else {
            header("Location: cardapio.php?status=erroquery");
        }
    } else {
        header("Location: cardapio.php?status=ja_confirmado");
    }
} else {
    header("Location: cardapio.php");
}

$mysql->fechar();
?>