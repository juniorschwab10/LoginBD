<?php
	//starta a sess�o
    session_start();
	ob_start();
	//resgata os valores das session em variaveis
	$id_users = isset($_SESSION['id']) ? $_SESSION['id']: "";	
	$nome_user = isset($_SESSION['nome']) ? $_SESSION['nome']: "";	
	$email_users = isset($_SESSION['email']) ? $_SESSION['email']: "";	
	$pass_users = isset($_SESSION['pass']) ? $_SESSION['pass']: "";	
	$logado = isset($_SESSION['logado']) ? $_SESSION['logado']: "N";	
	//varificamos e a var logado cont�m o valos (S) OU (N), se conter N quer dizer que a pessoa n�o fez o login corretamente
	//que no caso satisfar� nossa condi��o no if e a pessoa sera redirecionada para a tela de login novamente
	if ($logado == "N" && $id_users == ""){	    
		echo  "<script type='text/javascript'>
					location.href='index.php'
				</script>";	
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema Login</title>
</head>
<body>
	<center>
		<article>
			<h1><?php echo $nome_user;?> voc&ecirc; est&aacute; Autenticado(a)...</h1>
			
			<h1> site.......</h1>
			<a href="logout.php"><input type="button" value="Sair"/></a>
		</article>
	</center>
</body>
</html>