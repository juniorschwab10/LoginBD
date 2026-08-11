<?php
session_start();
include_once("conexao.php");

// Coleta e limpa os dados brutos
$nome_raw = filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); // valida se é email mesmo
$pass_raw = filter_input(INPUT_POST, 'pass', FILTER_UNSAFE_RAW);

// Escapa os dados para evitar quebras no banco (SQL Injection)
$nome = mysqli_real_escape_string($conn, $nome_raw);
$pass = mysqli_real_escape_string($conn, $pass_raw);

if (!$email) {
    $_SESSION['msg'] = "<p style='color:red;'>E-mail inválido.</p>";
    header("Location: cad_usuario.php");
    exit();
}

// Query de inserção
$result_usuario = "INSERT INTO users (`nome`, `email`, `pass`) VALUES ('$nome', '$email', '$pass')";
$resultado_usuario = mysqli_query($conn, $result_usuario);

if(mysqli_affected_rows($conn) > 0){
	$_SESSION['msg'] = "<p style='color:green;'>Usuário cadastrado com sucesso! Faça seu login.</p>";
	header("Location: index.php"); 
	exit();
}else{
	$_SESSION['msg'] = "<p style='color:red;'>Usuário não foi cadastrado com sucesso.</p>";
	header("Location: cad_usuario.php");
	exit();
}
?>