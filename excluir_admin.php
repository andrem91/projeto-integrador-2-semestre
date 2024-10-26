<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['admin_logado'])) {
    header("Location:login.php");
    exit();
}

$id = $_GET['id'] ?? null; //verifica se o valor à sua esquerda é null ou não definido. Se for, o operador retorna o valor à sua direita. Se não for, retorna o valor à esquerda

if (!$id) {
    header('Location: listar_admin.php');
    exit();
}

try {
    // Excluir o produto
    $stmt = $pdo->prepare("DELETE FROM ADMINISTRADOR WHERE ADM_ID = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: listar_admin.php');
    exit();
} catch (PDOException $e) {
    echo "<p style='color:red;'>Erro ao excluir adm: " . $e->getMessage() . "</p>";
}
?>


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exluir adm</title>
</head>
<body>
    <h2>Excluir produto</h2>
    <p><?php echo $mensagem  ?></p>
    <a href="listar_admin.php">Voltar à lista de adms</a>
</body>
</html>