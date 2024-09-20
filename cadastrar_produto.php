<?php
session_start();

require_once("conexao.php");

if (!isset($_SESSION['admin_logado'])) {
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de produto</title>
</head>

<body>
    <h2>Cadastrar Produto</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Insira seu nome do produto" required>
        </div>
        <div>
            <label for="descricao">Descrição: </label>
            <textarea name="descricao" id="descricao" placeholder="Insira a descrição do produto" required></textarea>
        </div>
        <div>
            <label for="preco">Preço: R$</label>
            <input type="number" name="preco" id="preco" step="0.01" required>
        </div>

        <div>
            <label for="desconto">Desconto: </label>
            <input type="number" name="desconto" id="desconto" step="0.01" required>
        </div>
        <div>
            <label for="estoque">Estoque: </label>
            <input type="number" name="estoque" id="estoque" required>
        </div>
        <div>
            <label for="categoria_id">Catedoria: </label>
            <select name="categoria_id" id="categoria_id" required>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria['CATEGORIA_ID']; ?>"><?php echo $categoria['CATEGORIA_NOME']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div>
            <label for="ativo">Ativo: </label>
            <input type="checkbox" name="ativo" id="ativo" value="1" checked>
        </div>
        <div id="containerImagens">
            <div class="image-input">
                <input type="text" name="imagem_url[]" placeholder="URL da imagem" required>
                <input type="number" name="imagem_ordem[]" id="" placeholder="ordem" min="1" required>
            </div>
        </div>
        <div>
            <button onclick="adicionarImagem()">Adicionar mais Imagens</button>
        </div>
        <div>
            <button type="submit">Cadastrar Produto</button>
        </div>
    </form>
    <a href="painel_admin.php">Voltar ao painel do administrador</a>
</body>

</html>