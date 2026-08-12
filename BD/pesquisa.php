<?php
// Passo 1: Conectar
$servername = "localhost"; // Nome do servidor
$username = "root";        // Nome de usuário
$password = "root";       // Senha
$dbname = "mondrone";          // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
// --- NOVO: Captura o termo de busca enviado pelo formulário ---
$nome_busca = "";
if (isset($_GET['busca'])) {
    $nome_busca = trim($_GET['busca']);
}
?>

<!-- --- NOVO: Formulário HTML de Consulta --- -->
<h2>Consultar por Nome</h2>
<form method="GET" action="">
<input type="text" name="busca" placeholder="Digite o nome..." 
value="<?php echo htmlspecialchars($nome_busca); ?>">
    <button type="submit">Buscar</button>
    <a href="?">Limpar Busca</a>
</form>
<br>

<?php
// Passo 2: Preparar a consulta SQL dinâmica com base na busca
if ($nome_busca !== "") {
    // Filtra pelo nome usando LIKE para buscas parciais
 $sql = "SELECT id, nome, sobrenome, endereco, telefone, 
 comentario 
            FROM cadastro 
            WHERE nome LIKE ? 
            ORDER BY nome ASC";
} else {
    // Se não houver busca, traz todos os registros
    $sql = "SELECT id, nome, sobrenome, endereco, telefone, comentario 
            FROM cadastro 
            ORDER BY nome DESC";
}

$stmt = $conn->prepare($sql);

if ($stmt) {
    // Se houver um termo de busca, vincula o parâmetro com os curingas '%'
    if ($nome_busca !== "") {
        $param_busca = "%" . $nome_busca . "%";
        $stmt->bind_param("s", $param_busca);
    }

    // Executa a consulta
    $stmt->execute();
    // Obtém o resultado da busca
    $resultado = $stmt->get_result();

    // Passo 3: Verificar se existem registros e exibi-los
    if ($resultado->num_rows > 0) {
        echo "<h2>Lista de Cadastros</h2>";
        echo "<table border='1' cellpadding='10' cellspacing='0'>";
        echo "<tr><th>Codigo</th>
              <th>Nome</th><th>Sobrenome</th><th>Endereço</th>
              <th>Telefone</th><th>Comentário</th></tr>";
              
        // Loop que percorre cada linha retornada pelo banco de dados
        while ($linha = $resultado->fetch_assoc()) {
            echo "<tr>";
            // htmlspecialchars protege contra ataques XSS ao exibir os dados
            echo "<td>" . htmlspecialchars($linha['id']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['sobrenome']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['endereco']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['telefone']) . "</td>";
            echo "<td>" . htmlspecialchars($linha['comentario']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br>Total de registros encontrados: " . $resultado->num_rows;
    } else {
        echo "Nenhum registro encontrado para: '<strong>" . htmlspecialchars($nome_busca) . "</strong>'";
    }

    // Fecha a declaração preparada
    $stmt->close();
} else {
    echo "Erro na preparação da consulta: " . $conn->error;
}

// Passo 4: Fechar conexão
$conn->close();
?>