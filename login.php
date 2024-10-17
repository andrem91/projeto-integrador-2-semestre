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
    <link rel="stylesheet" href="style/index.css">
</head>
<body>
    <div class="container-logo center">
        <img id="img-logo" src="image/logo/logo-alpha-dark.svg" alt="">
    </div>
    <form method="post" action="processa_login.php">
        <div class="form-control">
            <label for="nome">Usuario:</label>
            <input type="text" name="nome" id="nome" required>
        </div>
        <div class="form-control">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" required>
        </div>
        <div class = "btn-container center">
        <input class="btn" type="submit" value="Entrar">
        </div>
    </form>
</body>

</html>