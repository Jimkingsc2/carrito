<?php
require_once 'GestionBD.php';

Class Clientes{
	private $id;
	private $nombre;
	private $apellidos;
	private $direccion;
	private $cp;
	private $ciudad;
	private $municipio;
	private $estado;
	private $telefono;
	private $email;
	private $usuario;
	private $password;
	private $con;
	private $qry;
	private $resource;
	public $registrado;
	
	/**
	 * Inicializa las propiedades de la clase.
	 * @param string $nom Nombre del cliente.
	 * @param string $ape Apellidos del cliente.
	 * @param string $dir Dirección del cliente.
	 * @param string $cp Código Postal.
	 * @param string $cd Ciudad.
	 * @param string $mun Municipio.
	 * @param int $edo Estado.
	 * @param string $tel Telefono del cliente.
	 * @param string $mail Correo electrónico del cliente.
	 * @param string $usr Nick de usuario.
	 * @param string $pass Password.
	 * @param int $id Id del cliente.
	 */
	public function Inicializar($nom,$ape,$dir,$cp,$cd,$mun,$edo,$tel,$mail,$usr,$pass,$id=0){
		$this->nombre = $nom;
		$this->apellidos = $ape;
		$this->direccion = $dir;
		$this->cp = $cp;
		$this->ciudad = $cd;
		$this->municipio = $mun;
		$this->estado = $edo;
		$this->telefono = $tel;
		$this->email = $mail;
		$this->usuario = $usr;
		$this->password = $pass;
		$this->id = $id;
	}
	
	/**
	 * Realiza el registro de un nuevo cliente.
	 * @return int Id del nuevo cliente.	 
	 */
	public function  RegistrarCliente(){
		$this->registrado = 0;
		$this->con = new GestionBD();
		$this->qry = "call spRegistrarCliente($this->id,\"$this->nombre\",\"$this->apellidos\",\"$this->direccion\",\"$this->cp\",\"$this->ciudad\",\"$this->municipio\",$this->estado,\"$this->telefono\",\"$this->email\",\"$this->usuario\",\"$this->password\",@idCliente);";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($this->resource){
			$this->registrado = $this->con->RegresarParametro('@idCliente'); 
		}
		$this->con->CerrarConexion();
		return $this->registrado;
	}
	
	/**
	 * Muestra la información de uno o más clientes.
	 * @param int $idc Id del cliente.
	 * @param string $nom Nombre del cliente.
	 * @param string $ape Apellidos del cliente.
	 * @return mysqli Resource de la consulta. 
	 */
	public function MostrarCredenciales($idc=0,$nom="'0'",$ape="'0'"){
		$this->con = new GestionBD();
		$this->qry = "call spListarClientes($idc,$nom,$ape)";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		$this->con->CerrarConexion();
		return $res;
	}
	
	/**
	 * Muestra la información de las compras realizadas por un cliente.
	 * @param integer $idc Id del cliente.
	 * @return resource Resource de la consulta. 
	 */
	public function MostrarComprasRealizadas($idc){
		$this->con = new GestionBD();
		$this->qry = "call spListarComprasCliente($idc)";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		$this->con->CerrarConexion();
		return $res;
	}
	
	/**
	 * Cierra la conexión a la base de datos en caso de que se encuentre abierta.
	 */
	public function __destruct(){
		if(is_object($this->con)){
			$this->con->CerrarConexion();
		}
	}
	
	public function EliminarCliente($idc){
		$this->con = new GestionBD();
		$this->qry = "call spEliminarCliente($idc);";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		$this->con->CerrarConexion();
		if(!empty($res)){
			return 1;
		}else{
			return 0;
		}
	}
}