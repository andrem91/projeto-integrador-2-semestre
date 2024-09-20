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
    <style>
        /* Estilo para o corpo da página */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        /* Estilo para o contêiner do formulário */
        .container {
            max-width: 600px;
            width: 90%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        /* Estilo do cabeçalho do formulário */
        .header-section {
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
            font-size: 24px;
        }

        /* Estilo para o formulário */
        form {
            display: flex;
            flex-direction: column;
        }

        div {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:active {
            background-color: #004494;
        }

        .error-message {
            color: #fff;
            background-color: #e74c3c;
            border: 1px solid #c0392b;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-section">
            <h2>Cadastrar Administrador</h2>
        </div>
        <div>
            <?php
            echo $msg;
            ?>
            <form action="" method="post">
                <div>
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" required>
                </div>
                <div>
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" required>
                </div>
                <div>
                    <label for="ativo">Ativo:</label>
                    <input type="checkbox" name="ativo" id="ativo" value="1" checked>
                </div>
                <div>
                    <button type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>