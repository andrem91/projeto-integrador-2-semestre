<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM ADMINISTRADOR WHERE ADM_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $adm = $stmt->fetch(PDO::FETCH_ASSOC); // Organiza como um array associativo

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header('Location: crud_admin.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0; // Verifica se o checkbox foi marcado
    try {
        $stmt = $pdo->prepare("UPDATE ADMINISTRADOR SET ADM_NOME = :nome, ADM_EMAIL = :email, ADM_SENHA = :senha, ADM_ATIVO = :ativo WHERE ADM_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);

        $stmt->execute();
        header('Location: crud_admin.php');
        exit();
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Administrador</title>
    <link rel="stylesheet" href="style/index.css">
</head>

<body>

    <div class="container">
        <h2>Editar Administrador</h2>
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $adm['ADM_ID']; ?>">

            <div class="form-control">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo $adm['ADM_NOME']; ?>" required>
            </div>

            <div class="form-control">
                <label for="senha">Senha</label>
                <input type="password" name="senha" id="senha" required>
            </div>

            <div class="form-control">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $adm['ADM_EMAIL']; ?>" required>
            </div>

            <div class="form-control">
                <label for="ativo">Ativo:</label>
                <input type="checkbox" name="ativo" id="ativo" value="1" <?php echo $adm['ADM_ATIVO'] ? 'checked' : ''; ?>>
            </div>

            <div class="btn-container center">
                <input class="btn" type="submit" value="Atualizar Administrador">
            </div>
        </form>
        <div class="btn-container">
            <a class="btn" href="crud_admin.php">Voltar à lista de ADM</a>
        </div>
    </div>

</body>

</html>
