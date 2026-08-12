<?php
session_start();

$action = isset($_POST['acao']) ? trim($_POST['acao']) : '';
if(isset($action) && $action != ""){ 
    switch($action){
        case 'logar':
            // Requer a classe de autentica��o
            require_once('class/Autentica.class.php');
            $Autentica = new Autentica();
            
            $Autentica->email = $_POST['email'];
            $Autentica->pass  = $_POST['pass'];
                                    
            if($Autentica->Validar_Usuario()){
                echo "<script type='text/javascript'>location.href='consultaa-z.php'</script>";
                exit();
            } else {
                echo "<script type='text/javascript'>
                        alert('ATEN��O, Login ou Senha inv�lidos...');
                        location.href='index.php';
                      </script>";
                exit();
            }
            break;
    }	
}
?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <title>Sistema Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<article>
    <form name="form_pesquisa" id="form_pesquisa" method="post" action="">
        <div id="login-box">
            <h2>Login</h2>
            Entre com seus dados corretamente para acessar o sistema.<br/><br/>
            
            <?php
            // Se houver uma mensagem de erro na sessão, ela aparece aqui
            if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            
            <div id="login-box-name">Email:</div>
            <div id="login-box-field">
                <input name="email" type="email" class="form-login" title="Username" size="30" placeholder="Digite seu email" required />
            </div>
            
            <div id="login-box-name">Senha:</div>
            <div id="login-box-field">
                <input name="pass" type="password" class="form-login" title="Password" size="30" placeholder="Digite sua senha" required />
            </div>
            <br/> 
           
            <span class="login-box-options">
                <input type="checkbox" name="remember" value="1"> Permanecer Logado 
                <a href="cad_usuario.php" style="margin-left:30px;">Não Cadastrado!</a>
            </span>
            
            <input type="submit" value="Entrar" class="bt-enviar"/>
            <input type="hidden" name="acao" value="logar"/>
        </div>
    </form>
</article>
</body>
</html>