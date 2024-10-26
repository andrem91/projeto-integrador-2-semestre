<?php
// Inicia a sessão e verifica se um administrador está logado
session_start();

if (!isset($_SESSION['admin_logado'])) {
    header('Location: login.php');
    exit();
}

// Faz a conexão com o banco de dados usando os detalhes de configuração
require_once('conexao.php');

// Inicializa a variável para as categorias
$categorias = [];

// Recupera a lista de categorias para preencher o dropdown
try {
    $stmt_categoria = $pdo->prepare("SELECT CATEGORIA_ID, CATEGORIA_NOME FROM CATEGORIA WHERE CATEGORIA_ATIVO = 1");
    $stmt_categoria->execute();
    $categorias = $stmt_categoria->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $stmt = $pdo->prepare("SELECT * FROM PRODUTO WHERE PRODUTO_ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt_estoque = $pdo->prepare("SELECT PRODUTO_QTD FROM PRODUTO_ESTOQUE WHERE PRODUTO_ID = :id");
            $stmt_estoque->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_estoque->execute();
            $estoque = $stmt_estoque->fetch(PDO::FETCH_ASSOC);

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
    $desconto = $_POST['desconto'];
    $categoria_id = $_POST['categoria_id']; // Corrigido aqui
    $ativo = isset($_POST['ativo']) ? 1 : 0; // Verifica se o checkbox foi marcado

    try {
        $stmt = $pdo->prepare("UPDATE PRODUTO SET PRODUTO_NOME = :nome, PRODUTO_DESC = :descricao, PRODUTO_PRECO = :preco, PRODUTO_DESCONTO = :desconto, CATEGORIA_ID = :categoria_id, PRODUTO_ATIVO = :ativo WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':preco', $preco, PDO::PARAM_STR);
        $stmt->bindParam(':desconto', $desconto, PDO::PARAM_STR);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->execute();

        // Atualiza o estoque
        $estoque = $_POST['estoque'];
        $stmt = $pdo->prepare("UPDATE PRODUTO_ESTOQUE SET PRODUTO_QTD = :estoque WHERE PRODUTO_ID = :id");
        $stmt->bindParam(':estoque', $estoque, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Processa as imagens (opcional)
        if (!empty($_POST['imagem_url'])) {
            foreach ($_POST['imagem_url'] as $key => $url) {
                $ordem = $_POST['imagem_ordem'][$key];
                if (!empty($url)) {
                    // Adicione lógica para inserir ou atualizar imagens aqui, se necessário
                }
            }
        }

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
                <input type="text" name="nome" value="<?php echo htmlspecialchars($produto['PRODUTO_NOME']); ?>" required>
            </div>

            <div class="form-control">
                <label for="descricao">Descrição</label>
                <textarea name="descricao" id="descricao" required><?php echo htmlspecialchars($produto['PRODUTO_DESC']); ?></textarea>
            </div>

            <div class="form-control">
                <label for="preco">Preço R$</label>
                <input type="text" name="preco" id="preco" value="<?php echo htmlspecialchars($produto['PRODUTO_PRECO']); ?>" required>
            </div>

            <div class="form-control">
                <label for="desconto">Desconto:</label>
                <input type="number" name="desconto" id="desconto" step="0.01" value="<?php echo htmlspecialchars($produto['PRODUTO_DESCONTO']); ?>">
            </div>

            <div class="form-control">
                <label for="estoque">Estoque:</label>
                <input type="number" name="estoque" id="estoque" value="<?php echo htmlspecialchars($estoque['PRODUTO_QTD']); ?>" required>
            </div>

            <div class="form-control">
                <label for="categoria_id">Categoria:</label>
                <select name="categoria_id" id="categoria_id" required>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria['CATEGORIA_ID']; ?>" <?php echo ($categoria['CATEGORIA_ID'] == $produto['CATEGORIA_ID']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categoria['CATEGORIA_NOME']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-control">
                <label for="ativo">Ativo:</label>
                <input type="checkbox" name="ativo" id="ativo" value="1" <?php echo $produto['PRODUTO_ATIVO'] ? 'checked' : ''; ?>>
            </div>

            <div id="containerImagens">
                <div class="imagem-input">
                    <input type="text" name="imagem_url[]" placeholder="URL da imagem">
                    <input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1">
                </div>
            </div>
            <div class="btn-container center">
                <button class="btn" type="button" onclick="adicionarImagem()">Adicionar mais Imagens</button>
            </div>
            <div class="btn-container center">
                <input class="btn" type="submit" value="Atualizar Produto">
            </div>
        </form>
        <div class="btn-container">
            <a class="btn" href="listar_produtos.php">Voltar a lista de Produtos</a>
        </div>
    </div>

    <script>
        function adicionarImagem() {
            const container = document.getElementById('containerImagens');
            const div = document.createElement('div');
            div.className = 'imagem-input';
            div.innerHTML = `<input type="text" name="imagem_url[]" placeholder="URL da imagem">
                            <input type="number" name="imagem_ordem[]" placeholder="Ordem" min="1">`;
            container.appendChild(div);
        }
    </script>
</body>
</html>
