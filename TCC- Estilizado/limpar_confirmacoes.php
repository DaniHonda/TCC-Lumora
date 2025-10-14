<?php
session_start();

if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || ($_SESSION['nivel'] != 'admin' && $_SESSION['nivel'] != 'emp')) {
    header("Location: index.php");
    exit();
}

require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

$tabelasParaLimpar = [
    'tb_confirmacoes_manha',
    'tb_confirmacoes_tarde',
    'tb_confirmacoes_noite'
];

foreach ($tabelasParaLimpar as $tabela) {
    $sql = "TRUNCATE TABLE `$tabela`";
    mysqli_query($mysql->con, $sql);
}

$mysql->fechar();

header("Location: gerenciar_cardapio.php?status=limpo");
exit();
?>