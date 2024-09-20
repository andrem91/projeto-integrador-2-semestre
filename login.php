<?php
session_start();

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
    <title>Login</title>
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
        }
        
        /* Estilo básico para o formulário */
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
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
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <form method="post" action="processa_login.php">
        <div>
            <label for="nome">Nome: </label>
            <input type="text" name="nome" id="nome" required>
        </div>
        <div>
            <label for="senha">Senha: </label>
            <input type="password" name="senha" id="senha" required>
        </div>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>