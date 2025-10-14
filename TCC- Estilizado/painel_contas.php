<?php
session_start();
if (!isset($_SESSION['log']) || $_SESSION['log'] !== 'ativo' || $_SESSION['nivel'] != 'admin') { 
    echo "<script>alert('Acesso permitido somente para administradores!');window.location.href='index.php';</script>"; 
    exit(); 
}
require_once('conexao/conexao.php');
$mysql = new BancodeDados();
$mysql->conecta();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Contas</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/painel_contas.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Barlow|Carter+One&display=swap" rel="stylesheet">
</head>
<body class="body-painel">

    <header class="cabecalho-fixo">
        <div class="logo">
         <a href="index.php">
            <img src="imgs/lumora.png" alt="Logo Lumora" class="logo-img">
        </a>
        </div>
       <nav class="menu-principal">
          <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="cardapio.php">Cardápio</a></li>
            <li><a href="gerenciar_cardapio.php">Gerenciar Cardápio</a></li>
            <li><a href="logout.php" class="btn-logout">Logout</a></li>
          </ul>
        </nav> 
    </header>

    <main class="painel-container-principal">
        <div class="admin-panel-container">
            <h1>Painel de Contas</h1>

            <div class="cardapio-form">
                <h2>Adicionar Nova Conta</h2>
                <form action="processar_nova_conta.php" method="post" id="form-nova-conta">
                    <div class="form-row">
                        <input type="text" name="nome" placeholder="Nome Completo *" required>
                        <select name="nivel" id="nivel_select" required>
                            <option value="" disabled selected>Selecione o Nível *</option>
                            <option value="aluno">Aluno</option>
                            <option value="emp">Funcionário</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <input type="text" name="rm" placeholder="RM (ou login para admin/emp) *" required>
                        <input type="password" name="senha" placeholder="Senha *" required>
                    </div>
                    
                    <div class="form-row" id="campos_aluno" style="display: none;">
                        <input type="text" name="codigo_etec" id="codigo_etec_input" placeholder="Código Etec *">
                        <select name="turno" id="turno_select">
                            <option value="" disabled selected>Selecione o Turno *</option>
                            <option value="Manhã">Manhã</option>
                            <option value="Tarde">Tarde</option>
                            <option value="Noite">Noite</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <button type="submit" class="btn-adicionar-item">Criar Conta</button>
                    </div>
                </form>
            </div>

            <h2>Contas Existentes</h2>
            <div class="table-responsive-panel">
                <table class="product-data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>RM / Login</th>
                            <th>Nível</th>
                            <th>Turno</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT id, nome, rm, nivel, turno FROM tbusuario ORDER BY id";
                    $query = mysqli_query($mysql->con, $sql);
                    while($dados = mysqli_fetch_array($query)):
                    ?>
                        <tr>
                            <td><?php echo $dados['id']; ?></td>
                            <td><?php echo htmlspecialchars($dados['nome']); ?></td>
                            <td><?php echo htmlspecialchars($dados['rm']); ?></td>
                            <td><?php echo htmlspecialchars($dados['nivel']); ?></td>
                            <td><?php echo htmlspecialchars($dados['turno'] ?? 'N/A'); ?></td>
                            <td class="actions-cell">
                                <?php if ($dados['id'] != 1): ?>
                                <a href="remover_conta.php?id=<?php echo base64_encode($dados['id']); ?>" onclick="return confirm('Tem certeza?');" class="btn-panel-danger btn-sm">Remover</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('nivel_select').addEventListener('change', function () {
            var camposAluno = document.getElementById('campos_aluno');
            var codigoEtecInput = document.getElementById('codigo_etec_input');
            var turnoSelect = document.getElementById('turno_select');

            if (this.value === 'aluno') {
                camposAluno.style.display = 'flex';
                codigoEtecInput.required = true;
                turnoSelect.required = true;
            } else {
                camposAluno.style.display = 'none';
                codigoEtecInput.required = false;
                turnoSelect.required = false;
            }
        });
    </script>

    <?php $mysql->fechar(); ?>
</body>
</html>