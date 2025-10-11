<?php
session_start();

// Verifica se o usuário está logado e é um aluno com turno definido
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || $_SESSION['nivel'] != 'aluno' || empty($_SESSION['turno'])) {
    header("Location: cardapio.php");
    exit();
}

require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

// Mapeia o nome do turno para o nome da tabela no banco de dados
$mapaTabelas = [
    'Manhã' => 'tb_confirmacoes_manha',
    'Tarde' => 'tb_confirmacoes_tarde',
    'Noite' => 'tb_confirmacoes_noite'
];

$turno_usuario = $_SESSION['turno'];
$tabela_confirmacao = $mapaTabelas[$turno_usuario] ?? null;

// Se o turno for inválido ou o acesso não for via POST, interrompe
if (!$tabela_confirmacao || $_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_POST['data_a_confirmar'])) {
    header("Location: cardapio.php");
    exit();
}

$id_usuario = $_SESSION['id'];
$data_confirmacao = $_POST['data_a_confirmar'];

// Verifica se já não existe uma confirmação para este dia na tabela correta
$sql_check = "SELECT id FROM `$tabela_confirmacao` WHERE id_usuario = ? AND data_confirmacao = ?";
$stmt_check = mysqli_prepare($mysql->con, $sql_check);
mysqli_stmt_bind_param($stmt_check, "is", $id_usuario, $data_confirmacao);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);

if (mysqli_num_rows($result_check) == 0) {
    // Se não houver confirmação, insere no banco
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
    // Se o usuário tentar confirmar de novo, apenas redireciona
    header("Location: cardapio.php?status=ja_confirmado");
}
mysqli_stmt_close($stmt_check);

$mysql->fechar();
?>