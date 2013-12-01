<?php
require_once 'GestionBD.php';
//http://aplicabook.com/peruxd/teta/#
class Login{	
	private $user;
	private $pass;
	private $esValido = 0;
	private $con;
	private $qry;
	private $resource;
	
	/**
	 * Inicializa las propiedades de la clase.
	 * @param string $usuario Nick de usuario.
	 * @param string $password Password de acceso.
	 */
	public  function __construct($usuario,$password){
		$this->user = $usuario;
		$this->pass = $password;
	}
	
	/**
	 * Inicia una sesión segura para un Administrador del sistema.
	 * @return int  
	 */
	public function  IniciarSesion(){
		$this->resource = null;
		$this->con = new GestionBD();
		$this->qry = "call spLogin(\"$this->user\",\"$this->pass\",@valido)";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($this->resource){
			$this->esValido = $this->con->RegresarParametro("@valido",$this->resource);
		}
		return $this->esValido;	
	}
	
	/**
	 * Inicia una sesión segura para un cliente.
	 * @return int 
	 */
	public function  IniciarSesionCliente(){
		$this->resource = null;
		$this->con = new GestionBD();
		$this->qry = "call spLoginCliente(\"$this->user\",\"$this->pass\",@validoC)";
						
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($this->resource){
			$this->esValido = $this->con->RegresarParametro("@validoC",$this->resource);
		}
		return $this->esValido;	
	}
	
	/**
	 * Cierra la conexión a la base de datos en caso de que se encuentre abierta.
	 */
	public function __destruct(){
		if(is_object($this->con)){
			$this->con->CerrarConexion();
		}
	}
}

//$usuario = "jocho";IniciarSesionCliente
//$password = "1906";

//$obj = new Login($usuario, $password);
//$valido = $obj->IniciarSesion(); 
//echo $valido;
//echo "El usuario es " . ($valido == 1) ? " Valido" : " Desconocido";