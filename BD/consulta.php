<?php
// Passo 1: Conectar
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mondrone";
echo '<link rel="stylesheet" type="text/css" href="consulta.css">';

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Passo 2: Criar o comando SQL para selecionar todos os registros
// Substitua "usuarios" pelo nome correto da sua tabela
$sql = "SELECT id, nome, sobrenome, endereco, telefone, comentario FROM cadastro";
$result = $conn->query($sql);

// Passo 3: Verificar se existem registros e exibi-los
if ($result && $result->num_rows > 0) {
   
    // Início da tabela em HTML para organizar os dados
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr>
            <th>Codigo</th>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Endereço</th>
            <th>Telefone</th>
            <th>Comentário</th>
          </tr>";

    // O laço 'while' percorre cada linha de resultado do banco de dados
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["sobrenome"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["endereco"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["telefone"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["comentario"]) . "</td>";
        echo "</tr>";
    }
   
    echo "</table>";
   
} else {
    echo "Nenhum registro encontrado.";
}

// Passo 4: Fechar a conexão com o banco de dados
$conn->close();
?>

