<?php
// Passo 1: Conectar
$servername = "localhost"; // Nome do servidor
$username = "root";        // Nome de usuário
$password = "root";       // Senha
$dbname = "mondrone";          // Nome do banco de dados
echo '<link rel="stylesheet" type="text/css" href="consulta.css">';

$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
// Passo 2: Preparar a consulta SQL para selecionar todos os registros
// Nota: Ajustado para 'cadastro' (com 'r'), corrija para 'cadasto' se o seu banco estiver com o erro de digitação.
$sql = "SELECT id, nome, endereco, telefone, comentario 
FROM cadastro";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Executa a consulta
    $stmt->execute();
       // Obtém o resultado da busca
    $resultado = $stmt->get_result();

    // Passo 3: Verificar se existem registros e exibi-los
    if ($resultado->num_rows > 0) {
  echo "<h2>Lista de Cadastros</h2>";
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<tr><th>Codigo</th>
		<th>Nome</th><th>Endereço</th>
	   <th>Telefone</th><th>Comentário</th></tr>";
        // Loop que percorre cada linha retornada pelo banco de dados
        while ($linha = $resultado->fetch_assoc()) {
            echo "<tr>";
            // htmlspecialchars protege contra ataques XSS ao exibir os dados
			echo "<td>" .htmlspecialchars($linha['id']) ."</td>";
            echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['endereco']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['telefone']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['comentario']) . "</td>";
            echo "</tr>";
//AULA 27/05/26        
}
        echo "</table>";
        echo "<br>Total de registros: " . $resultado->num_rows;
    } else {
        echo "Nenhum registro encontrado no banco de dados.";
    }

    // Fecha a declaração preparada
    $stmt->close();
} else {
    echo "Erro na preparação da consulta: " . $conn->error;
}

// Passo 4: Fechar conexão
$conn->close();
?>