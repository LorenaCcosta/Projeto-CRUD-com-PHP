<?php

// Título da página

$pageTitle = "Projeto PHP";


// --- Configurações do Banco de Dados ---

// Substitua estas informações pelas suas credenciais reais do banco de dados

$servername = "localhost"; // Onde o seu banco de dados está rodando

$username = "root"; // O nome de usuário do seu banco de dados

$password = ""; // A senha do seu banco de dados

$dbname = "db_aula"; // O nome do seu banco de dados


// --- Conexão com o Banco de Dados ---

// Cria a conexão usando a biblioteca mysqli

$conn = new mysqli($servername, $username, $password, $dbname);


// Verifica se a conexão falhou

if ($conn->connect_error) {

// Se falhar, exibe uma mensagem de erro e interrompe o script

die("Conexão falhou: " . $conn->connect_error);

}


// --- Consulta SQL ---

// Exemplo de uma consulta para selecionar todos os dados de uma tabela chamada 'usuarios'

$sql = "SELECT id, nome, email FROM usuarios";

$result = $conn->query($sql);


?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $pageTitle; ?></title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

</head>

<body>

    <div class="container">

        <h1><?php echo $pageTitle; ?></h1>
        <a href="add.php">
            <div class="btn btn-primary">Novo Usuário 
            <i class="fa-solid fa-plus"></i>
            </div>
        </a>
        

        <?php

// --- Exibição dos Dados ---

// Verifica se a consulta retornou algum resultado (mais de 0 linhas)

if ($result->num_rows > 0) {

// Inicia a tabela HTML

echo "<table>";

echo "<thead><tr> 
<th>ID</th>
<th>Nome</th>
<th>E-mail</th>
<th>Ação</th>
</tr></thead>";

echo "<tbody>";


// Loop através de cada linha de dados retornada

while($row = $result->fetch_assoc()) {

// Exibe os dados em uma linha da tabela

echo "<tr>";

echo "<td>" . $row["id"] . "</td>";

echo "<td>" . $row["nome"] . "</td>";

echo "<td>" . $row["email"] . "</td>";

 echo "<td>
            <a href='delete.php?delete_id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja deletar -> " . $row['nome'] . "?\");' class='btn btn-sm btn-danger'>
                <i class='fa-solid fa-trash'></i> Deletar
            </a>
            
            <a href='edit.php?edit_id=" . $row['id'] . "' class='btn btn-sm btn-warning'>
                <i class='fa-solid fa-pen-to-square'></i> Editar
            </a>
      </td>";

 
echo "</tr>";

}

// Fecha o corpo e a tabela HTML

echo "</tbody></table>";

} else {

// Se não houver resultados, exibe uma mensagem

echo "<p class='no-results'>Nenhum resultado encontrado.</p>";

}


// --- Fechar a Conexão ---

// É uma boa prática fechar a conexão com o banco de dados quando terminar

$conn->close();

?>
    </div>

</body>

</html