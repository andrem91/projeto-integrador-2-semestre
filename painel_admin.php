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

    <link rel="stylesheet" href="style/index.css">

</head>

<body>
<div class="container-logo center">
        <img id="img-logo" src="image/logo/logo-alpha-dark.svg" alt="">
    </div>
    <div class="container">
        <div class="header-section">
            <h2>Bem-vindo, Administrador</h2>
        </div>
        <div class="btn-section">
            
                <div class = "btn-container center">
                    <a class="btn" href="crud_admin.php">Administrador</a>
                </div>
                <div class = "btn-container center">
                    <a class="btn" href="cadastrar_produto.php">Cadastrar Produto</a>
                </div>
                <div class = "btn-container center">
                    <a class="btn" href="listar_produtos.php">Listar Produtos</a>
                </div>
           
        </div>
    </div>
</body>

</html>

