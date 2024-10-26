<?php
session_start();

require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("location:login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    try {
        $sql = "INSERT INTO ADMINISTRADOR (ADM_NOME, ADM_EMAIL, ADM_SENHA, ADM_ATIVO) VALUES (:nome, :email, :senha, :ativo);";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);

        $stmt->execute();

        $adm_id = $pdo->lastInsertId();

        $msg = "<p style='color: green;'>Administrador cadastrado com sucesso. ID: $adm_id</p>";
    } catch (PDOException $e) {
        $msg = "<p style='color: red;'>Erro ao cadastrar o administrador. " . $e->getMessage() . "</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Administrador</title>
    <link rel="stylesheet" href="style/index.css">
</head>

<body>
    <div class="container">
        <div class="header-section">
            <h2>Cadastrar Administrador</h2>
        </div>
        <div>
            <?php
            //echo $msg;
            ?>
            <div class="container">
                <form action="" method="post">
                    <div class="form-control">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" required>
                    </div>
                    <div class="form-control">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-control">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha" required>
                    </div>
                    <div class="form-control">
                        <label for="ativo">Ativo:</label>
                        <input type="checkbox" name="ativo" id="ativo" value="1" checked>
                    </div>
                    <div class="btn-container center">
                        <button class="btn" type="submit">Cadastrar</button>
                    </div>
                </form>
            </div>

            <div class="btn-container">
                <a class="btn" href="crud_admin.php">Voltar à lista de ADM</a>
            </div>

        </div>
    </div>
</body>

</html>