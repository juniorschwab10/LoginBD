<?php	
require_once('Conexao.class.php');
	
class Autentica extends Conexao {
	private $data = array();
	public $erro;

	public function __construct(){
		// IMPORTANTE: Chama o construtor da classe Conexao para iniciar o PDO ($this->pdo)
		parent::__construct(); 
		$this->erro = '';
	}
	
	public function __set($name, $value){
		$this->data[$name] = $value;
	}

	public function __get($name){
		if (array_key_exists($name, $this->data)) {
			return $this->data[$name];
		}

		$trace = debug_backtrace();
		trigger_error(
			'Undefined property via __get(): ' . $name .
			' in ' . $trace[0]['file'] .
			' on line ' . $trace[0]['line'],
			E_USER_NOTICE);
		return null;
	}
		
	public function Validar_Usuario(){
		// Consulta utilizando placeholders para evitar SQL Injection
		$sql = "SELECT * FROM users WHERE email = :email AND pass = :pass";
		
		// Passa os dados de forma segura atrav�s do array de par�metros
		$resultado = $this->select($sql, array(
			':email' => $this->email,
			':pass'  => $this->pass
		));
		
		// Verifica se encontrou o utilizador
		if(count($resultado) > 0){
			// Como o email � �nico, pegamos diretamente o primeiro resultado do array
			$res = $resultado[0];
			
			// Verifica se a sess�o j� n�o foi iniciada no script que chamou a classe (ex: index.php)
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			
			// Grava os dados na sess�o global
			$_SESSION['id_users'] = $res['id_users'];
			$_SESSION['nome'] = $res['nome'];
			$_SESSION['email'] = $res['email'];
			$_SESSION['pass'] = $res['pass'];
			$_SESSION['logado'] = 'S';
			
			return true;
		} else {
			return false;
		}
	}
}
?>