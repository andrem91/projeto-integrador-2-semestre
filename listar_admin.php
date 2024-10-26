<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("location: login.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT *
    FROM ADMINISTRADOR");
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error'>Erro ao listar produtos: " .  $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Administradores</title>
</head>
<link rel="stylesheet" href="style/index.css">

<body>
    <div class="conteiner">
        <h2>Administradores Cadastrados</h2>
        <div class="center">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Senha</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>

                <?php foreach ($admins as $admin) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($admin['ADM_ID']); ?></td>
                        <td><?php echo htmlspecialchars($admin['ADM_NOME']); ?></td>
                        <td><?php echo htmlspecialchars($admin['ADM_EMAIL']); ?></td>
                        <td><?php echo htmlspecialchars($admin['ADM_SENHA']); ?></td>
                        <td><?php echo ($admin['ADM_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
                        <td>
                            <div class="btn-container">
                                <a class="btn btn-green" href="editar_admin.php?id=<?php echo htmlspecialchars($admin['ADM_ID']); ?>" class="action-btn">Editar</a>
                                <a class="btn btn-red" href="excluir_admin.php?id=<?php echo htmlspecialchars($admin['ADM_ID']); ?>" class="action-btn delete-btn">Excluir</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
        <div class="btn-container">
            <a class="btn" href="painel_admin.php">Voltar ao painel do Administrador</a>
        </div>
    </div>
</body>

</html>