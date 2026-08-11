<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>CRUD - Cadastrar</title>		
	</head>
	<body>
		<h1>PÁGINA DE CADASTRO</h1>
		<h2><a href="index.php">Voltar para o Login</a><br></h2>
		<h1>Cadastrar Usuário</h1>
		<?php
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
		<form method="POST" action="proc_cad_usuario.php">
			<label>Nome: </label>
			<input type="text" name="nome" placeholder="Digite o seu Nome" required><br><br>		
			
			<label>E-mail: </label>
			<input type="email" name="email" placeholder="Digite o seu melhor e-mail" required><br><br>
					
			<label>Senha: </label>
			<input type="password" name="pass" placeholder="Digite a sua Senha" required><br><br>
			
			<input type="submit" value="Cadastrar">
		</form>
	</body>
</html>