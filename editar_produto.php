<?php

//uma sessa é iniciada e verica se um adm está logado se nao tiver ele é mandado para o login

session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}
//o script faz uma conexao com bamco de dados usando os detalhes de configuracao
require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {

            $stmt = $pdo->prepare("SELECT * FROM PRODUTO WHERE PRODUTO_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $produto = $stmt->fetch(PDO::FETCH_ASSOC); //organiza como um array associativo

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    } else {
        header('Location:listar_produtos.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    try {
        $stmt = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->execute();
        header('Location: listar_produtos.php');
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
    <title>Editar Produto</title>
    <link rel="stylesheet" href="style/index.css">
</head>

<body>

    <div class="container">
        <h2> Editar Produto </h2>
        <form action="editar_produto.php" method="post">
            <input type="hidden" name="id" value="<?php echo $produto['PRODUTO_ID']; ?>">

            <div class="form-control">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo $produto['PRODUTO_NOME'] ?>">
            </div>

            <div class="form-control">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao"> <?php echo $produto['PRODUTO_DESC']; ?> </textarea>
            </div>

            <div class="form-control">
                <label for="preco">Preço</label>
                <input type="text" name="preco" id="preco" value="<?php echo $produto['PRODUTO_PRECO']; ?>">
            </div>

            <div class="form-control">
                <label for="imagem_url">URL da Imagem</label>
                <input type="text" name="imagem_url" id="imagem_url" value="">

            </div>

            <div class="btn-container center">
                <input class="btn" type="submit" value="Atualizar Produto">
            </div>
        </form>
        <div class="btn-container">
            <a class="btn" href="listar_produtos.php">Voltar a lista de Produtos</a>
        </div>
    </div>


</body>

</html>