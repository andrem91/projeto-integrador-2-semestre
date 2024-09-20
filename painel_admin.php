<?php
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('location: login.php');
    exit();
}

if (isset($_SESSION['mensagem_erro'])) {
    echo "<p class='error-message'>" . $_SESSION['mensagem_erro'] . "</p>";
    unset($_SESSION['mensagem_erro']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Administrador</title>
    <style>
        /* Estilo para a mensagem de erro */
        .error-message {
            color: #fff;
            background-color: #e74c3c;
            border: 1px solid #c0392b;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 16px;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        /* Estilo básico para o painel */
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header-section {
            margin-bottom: 20px;
            text-align: center;
        }

        h2 {
            color: #333;
            font-size: 24px;
        }

        .btn-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn:active {
            background-color: #004494;
        }

        @media (max-width: 600px) {
            .btn {
                width: 100%;
                padding: 15px;
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-section">
            <h2>Bem-vindo, Administrador</h2>
        </div>
        <div class="btn-section">
            <a class="btn" href="cadastrar_administrador.php">Cadastrar Administrador</a>
            <a class="btn" href="cadastrar_produto.php">Cadastrar Produto</a>
            <a class="btn" href="listar_produtos.php">Listar Produtos</a>
        </div>
    </div>
</body>

</html>
