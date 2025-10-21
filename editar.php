<?php
require 'banco.php';

$usuario = null;

//Lógica para buscar os dados do usuário e preencher o formulário
if (isset($_GET['edit_id']) && is_numeric($_GET['edit_id'])) {
    $id = filter_input(INPUT_GET, 'edit_id', FILTER_SANITIZE_NUMBER_INT);

    $sql_select = "SELECT id, nome, email FROM usuarios WHERE id = ?";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->bindValue(1, $id, PDO::PARAM_INT);
    $stmt_select->execute();

    $usuario = $stmt_select->fetch(PDO::FETCH_ASSOC);

    //Se o usuário não for encontrado, redireciona para a página inicial
    if (!$usuario) {
        header('Location: index.php?msg=error_not_found');
        exit();
    }
} elseif($_SERVER["REQUEST_METHOD"] == "POST") {

    //Lógica para processar a alteração no banco de dados
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $sql_update = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";

    try{
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindValue(1, $nome);
        $stmt_update->bindValue(2, $email);
        $stmt_update->bindValue(3, $id, PDO::PARAM_INT);
        $stmt_update->execute();

        //Redireciona de volta para página principal após o sucesso
        header('Location: index.php?msg=sucess_update');
        exit();
    } catch(PDOException $e) {
        header('Location: index.php?msg=error_update&error=' . urlencode($e->getMessage()));
        exit();
    }
}else{
    //Se não for GET ou POST válido, redireciona para a página inicial
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>

    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        .edit-form{
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #add; border-radius: 8px;
        }
    </style>
</head>
<body>
<body>
    <?php if ($usuario): ?>
    <div class="edit-form">
        <h3>Editar Usuário: <?= htmlspecialchars($usuario['nome']); ?></h3>
        <form action="editar.php" method="POST">

            <input type="hidden" name="id" value="<?= $usuario['id']; ?>">
            <label for="nome">Nome:</label><br>

            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($usuario['nome']); ?>" required><br><br>
            <label for="email">E-mail:</label><br>

            <input type="email" id="email" name="email" value="<?= htmlspecialchars($usuario['email']); ?>" required><br><br>

            <button type="submit">Salvar Alterações</button>
            <button href="index.php">Cancelar</button>
        </form>
    </div>
    <?php endif; ?>
</body>
</html>