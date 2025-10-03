<?php
    require 'banco.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        $sql = "INSERT INTO usuarios (nome, email) VALUES (?, ?)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $email);

            $stmt->execute();
            echo "<p style='color:green;'> Usuário cadastrado com sucesso!</p>";

        } catch (PDOException $e) {
            echo "<p style='color:red;'> Erro ao cadastrar: " . $e->getMessage() . "</p>"; 
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <style>
    </style>
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Cadastrar Novo Usuário</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="add.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome:</label>
                        <input type="text" id="nome" name="nome" required class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" name="email" id="email" required class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form> 

                <br>

                <a href="index.php">
                    <button class="btn btn-secondary w-100">Voltar ao Início</button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>