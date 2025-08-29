<?php
session_start();
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || $_SESSION['nivel'] != 'admin') { echo "<script>alert('Acesso permitido somente para administradores!');window.location.href='index.php';</script>"; exit(); }
require_once('conexao/conexao.php');
$mysql = new BancodeDados(); $mysql->conecta();
?>
<!DOCTYPE html><html lang="pt-br">
    <head>
    <title>Painel de Contas</title>
    <link rel="stylesheet" href="css/painelstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="body-admin-panel">
    <header class="cabecalho-fixo">
        <div class="logo">
            <a href="index.php"><span>LUMORA</span></a>
        </div>
        <div class="titulo-app">
            <h1>AviseJá</h1>
        </div>
        <div class="menu-container">
            <button id="menu-btn" class="menu-btn"><i class="fas fa-bars"></i></button>
        </div>
    </header>
      <nav id="sidemenu" class="sidemenu">
        <button id="close-btn" class="close-btn">&times;</button>
        <ul>
            <?php if (isset($_SESSION['log']) && $_SESSION['log'] === 'ativo'): ?>
                <li><a href="#">Minha Conta</a></li>
                <li><a href="principal.php">Cardápio</a></li>
                <?php if ($_SESSION['nivel'] === 'admin'): ?>
                    <li><a href="painel_contas.php">Painel de Controle</a></li>
                <?php endif; ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="cadastrologin.php">Cadastro</a></li>
                <li><a href="principal.php">Cardápio</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div id="overlay" class="overlay"></div>
<center></br></br></br>
<div class="admin-panel-container">
    <h1>Gerenciamento de Contas</h1>
    <div class="panel-actions"><a href="criar_conta_painel.php" class="btn-panel-primary">Criar Nova Conta</a><a href='index.php' class="btn-panel-secondary">Voltar à Loja</a></div>
    <div class="table-responsive-panel">
        <table class="product-data-table">
            <thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Nível</th><th>Ações</th></tr></thead>
            <tbody>
            <?php
            $sql = "SELECT id, nome, nivel FROM tbusuario ORDER BY id";
            $query = mysqli_query($mysql->con, $sql);
            while($dados = mysqli_fetch_array($query)): $id_encoded = base64_encode($dados['id']); ?>
                <tr>
                    <td><?php echo $dados['id']; ?></td>
                    <td><?php echo htmlspecialchars($dados['nome']); ?></td>
                    <td><?php echo htmlspecialchars($dados['nivel']); ?></td>
                    <td class="actions-cell">
                        <a href="alterar_nivel.php?id=<?php echo $id_encoded; ?>" class="btn-panel-secondary btn-sm">Alterar Nível</a>
                        <?php if ($dados['id'] != 1): ?>
                        <a href="remover_conta.php?id=<?php echo $id_encoded; ?>" onclick="return confirm('Tem certeza?');" class="btn-panel-danger btn-sm">Remover</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
                        </center>
<script src="js/login.js"></script>
<?php $mysql->fechar(); ?>
</body></html>