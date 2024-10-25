<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("location: login.php");
    exit();
}

try {
    $stmt = $pdo->prepare("SELECT PRODUTO.*, CATEGORIA.CATEGORIA_NOME,
    PRODUTO_IMAGEM.IMAGEM_URL, PRODUTO_ESTOQUE.PRODUTO_QTD
    FROM PRODUTO
    JOIN CATEGORIA ON PRODUTO.CATEGORIA_ID = CATEGORIA.CATEGORIA_ID
    LEFT JOIN PRODUTO_IMAGEM ON PRODUTO.PRODUTO_ID =
    PRODUTO_IMAGEM.PRODUTO_ID
    LEFT JOIN PRODUTO_ESTOQUE ON PRODUTO.PRODUTO_ID =
    PRODUTO_ESTOQUE.PRODUTO_ID");
    $stmt->execute();
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='error'>Erro ao listar produtos: " .  $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
</head>
<link rel="stylesheet" href="style/index.css">

<body>
    <h2>Produtos Cadastrados</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Categoria</th>
            <th>Ativo</th>
            <th>Desconto</th>
            <th>Estoque</th>
            <th>Imagem</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($produtos as $produto) : ?>
            <tr>
                <td><?php echo htmlspecialchars($produto['PRODUTO_ID']); ?></td>
                <td><?php echo htmlspecialchars($produto['PRODUTO_NOME']); ?></td>
                <td><?php echo htmlspecialchars($produto['PRODUTO_DESC']); ?></td>
                <td><?php echo htmlspecialchars($produto['PRODUTO_PRECO']); ?></td>
                <td><?php echo htmlspecialchars($produto['CATEGORIA_NOME']); ?></td>
                <td><?php echo ($produto['PRODUTO_ATIVO'] == 1 ? 'Sim' : 'Não'); ?></td>
                <td><?php echo htmlspecialchars($produto['PRODUTO_DESCONTO']); ?></td>
                <td><?php echo htmlspecialchars($produto['PRODUTO_QTD']); ?></td>
                <td><img src="<?php echo htmlspecialchars($produto['IMAGEM_URL']); ?>" alt="<?php echo htmlspecialchars($produto['PRODUTO_NOME']); ?>" width="50"></td>
                <td>
                    <div class="btn-container">
                        <a class="btn btn-green" href="editar_produto.php?id=<?php echo htmlspecialchars($produto['PRODUTO_ID']); ?>" class="action-btn">Editar</a>
                        <a class="btn btn-red" href="excluir_produto.php?id=<?php echo htmlspecialchars($produto['PRODUTO_ID']); ?>" class="action-btn delete-btn">Excluir</a>
                    </div>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <div class="btn-container">
        <a class="btn" href="painel_admin.php">Voltar ao painel do Administrador</a>
    </div>
</body>

</html>