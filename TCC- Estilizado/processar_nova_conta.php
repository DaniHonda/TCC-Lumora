<?php
session_start();
// Apenas administradores podem criar contas
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || $_SESSION['nivel'] != 'admin') {
    header("Location: index.php");
    exit();
}

require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta dos dados do formulário
    $nome = $_POST["nome"];
    $rm = $_POST["rm"];
    $senha = $_POST["senha"];
    $nivel = $_POST["nivel"];
    $turno = $_POST["turno"];
    $codigo_etec = $_POST["codigo_etec"];

    // Prepara os dados para o banco de dados
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
    // Se o nível for 'aluno', usamos os valores do formulário.
    // Se não, definimos turno e código da etec como NULL.
    $turno_db = ($nivel === 'aluno') ? $turno : NULL;
    $codigo_etec_db = ($nivel === 'aluno') ? $codigo_etec : NULL;

    // Prepara e executa a inserção no banco
    $sql = "INSERT INTO tbusuario (nome, rm, codigo_etec, senha, nivel, turno) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($mysql->con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssss", $nome, $rm, $codigo_etec_db, $senhaHash, $nivel, $turno_db);
        if (mysqli_stmt_execute($stmt)) {
            // Sucesso
            header("Location: painel_contas.php?status=criado");
        } else {
            // Erro (ex: RM duplicado)
            header("Location: painel_contas.php?status=erro");
        }
        mysqli_stmt_close($stmt);
    } else {
        // Erro na preparação da query
        header("Location: painel_contas.php?status=erroquery");
    }
} else {
    header("Location: painel_contas.php");
}

$mysql->fechar();
?>