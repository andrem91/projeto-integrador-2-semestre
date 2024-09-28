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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        
        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-btn {
            display: inline-block;
            padding: 6px 12px;
            margin: 2px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
        }

        .action-btn {
            background-color: #007BFF;
        }

        .delete-btn {
            background-color: #FF4136;
        }

        .action-btn:hover, .delete-btn:hover {
            opacity: 0.9;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

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
                    <a href="editar_produto.php?id=<?php echo htmlspecialchars($produto['PRODUTO_ID']); ?>" class="action-btn">Editar</a>
                    <a href="excluir_produto.php?id=<?php echo htmlspecialchars($produto['PRODUTO_ID']); ?>" class="action-btn delete-btn">Excluir</a>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
    <a href="painel_admin.php">Voltar ao painel do Administrador</a>
</body>

</html>
