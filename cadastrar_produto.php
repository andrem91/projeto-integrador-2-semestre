<?php
session_start();

require_once("conexao.php");

if (!isset($_SESSION['admin_logado'])) {
    header('location: login.php');
    exit();
}

try {
    $stmt_categoria = $pdo->prepare("SELECT * FROM CATEGORIA");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $msg_categoria = "<p style='color: red;'>Erro ao buscar categorias. " . $e->getMessage() . "</p>";
}

$msg_cadastro_produto = ''; // Inicialize a mensagem
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Certifique-se de que todos os campos estão preenchidos
    if (isset($_POST['nome'], $_POST['descricao'], $_POST['preco'], $_POST['desconto'], $_POST['estoque'], $_POST['categoria_id'])) {
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $desconto = $_POST['desconto'];
        $estoque = $_POST['estoque'];
        $categoria_id = $_POST['categoria_id'];
        $ativo = isset($_POST['ativo']) ? 1 : 0;
        $imagem_urls = $_POST['imagem_url'] ?? [];
        $imagem_ordens = $_POST['imagem_ordem'] ?? [];

        try {
            $sql_produto = "INSERT INTO PRODUTO(PRODUTO_NOME, PRODUTO_DESC, PRODUTO_PRECO, PRODUTO_DESCONTO, CATEGORIA_ID, PRODUTO_ATIVO) 
            VALUES (:nome, :descricao, :preco, :desconto, :categoria_id, :ativo)";
            $stmt_produto = $pdo->prepare($sql_produto);
            $stmt_produto->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt_produto->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt_produto->bindParam(':preco', $preco, PDO::PARAM_STR);
            $stmt_produto->bindParam(':desconto', $desconto, PDO::PARAM_STR);
            $stmt_produto->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
            $stmt_produto->bindParam(':ativo', $ativo, PDO::PARAM_INT);
            $stmt_produto->execute();

            $produto_id = $pdo->lastInsertId();

            $sql_estoque = "INSERT INTO PRODUTO_ESTOQUE(PRODUTO_ID, PRODUTO_QTD) 
            VALUES (:produto_id, :estoque)";
            $stmt_estoque = $pdo->prepare($sql_estoque);
            $stmt_estoque->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $stmt_estoque->bindParam(':estoque', $estoque, PDO::PARAM_INT);
            $stmt_estoque->execute();

            foreach ($imagem_urls as $index => $url) {
                $ordem = $imagem_ordens[$index];
                $sql_imagem = "INSERT INTO PRODUTO_IMAGEM(IMAGEM_URL, PRODUTO_ID, IMAGEM_ORDEM) 
                VALUES (:url_imagem, :produto_id, :imagem_ordem)";
                $stmt_imagem = $pdo->prepare($sql_imagem);
                $stmt_imagem->bindParam(':url_imagem', $url, PDO::PARAM_STR);
                $stmt_imagem->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
                $stmt_imagem->bindParam(':imagem_ordem', $ordem, PDO::PARAM_INT);
                $stmt_imagem->execute();
            }

            $msg_cadastro_produto = "<p style='color: green;'>Produto cadastrado com sucesso.</p>";
        } catch (PDOException $e) {
            $msg_cadastro_produto = "<p style='color: red;'>Erro ao cadastrar o Produto. " . $e->getMessage() . "</p>";
        }
    } else {
        $msg_cadastro_produto = "<p style='color: red;'>Preencha todos os campos obrigatórios.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="style/index.css">
    <script src="cadastrar_produto.js" defer></script>
</head>

<body>
    <div class="container">
        <div class="header-section">
            <h2>Cadastrar Produto</h2>
        </div>
        <?php
        if(isset($msg_cadastro_produto)){
            echo $msg_cadastro_produto;
        }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-control">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" placeholder="Insira o nome do produto" required>
            </div>
            <div class="form-control">
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" placeholder="Insira a descrição do produto" required></textarea>
            </div>
            <div class="form-control">
                <label for="preco">Preço: R$</label>
                <input type="number" name="preco" id="preco" step="0.01" required>
            </div>
            <div class="form-control">
                <label for="desconto">Desconto:</label>
                <input type="number" name="desconto" id="desconto" step="0.01" required>
            </div>
            <div class="form-control">
                <label for="estoque">Estoque:</label>
                <input type="number" name="estoque" id="estoque" required>
            </div>
            <div class="form-control">
                <?php
                if (isset($msg_categoria)) {
                    echo $msg_categoria;
                }
                ?>
                <label for="categoria_id">Categoria:</label>
                <select name="categoria_id" id="categoria_id" required>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOME']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-control">
                <label for="ativo">Ativo:</label>
                <input type="checkbox" name="ativo" id="ativo" value="1" checked>
            </div>
            <div id="containerImagens">
                <div class="imagem-input">
                    <input type="text" name="imagem_url[]" placeholder="URL da imagem" required>
                    <input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1" required>
                </div>
            </div>
            <div class="btn-container center">
                <button class="btn" type="button" onclick="adicionarImagem()">Adicionar mais Imagens</button>
            </div>
            <div class="btn-container center">
                <button class="btn" type="submit">Cadastrar Produto</button>
            </div>
        </form>
        <div class="btn-container">
            <a class="btn" href="painel_admin.php">Voltar ao painel do administrador</a>
        </div>
    </div>
</body>

</html>
