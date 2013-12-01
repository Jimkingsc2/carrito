<?php
require_once 'GestionBD.php';

class Usuarios{
	private $id;
	private $nombre;
	private $apellidos;
	private $tipo_usuario;
	private $usuario;
	private $password;
	private $con;
	private $qry;
	private $resource;
	
	/**
	 * Inicializa las propiedades de la clase.
	 * @param string $nom Nombre del usuario.
	 * @param string $ape Apellidos del usuario.
	 * @param string $tipo Tipo de usuario ante el sistema.
	 * @param string $nick Nick de usuario.
	 * @param string $pass Password de acceso.
	 * @param int $id 
	 */
	public function __construct($nom,$ape,$tipo,$nick,$pass,$id=0){
		$this->nombre = $nom;
		$this->apellidos = $ape;
		$this->tipo_usuario = $tipo;
		$this->usuario = $nick;
		$this->password = $pass;
		$this->id = $id;
	}
	
	/**
	 * Cosulta los datos de uno o más usuarios.
	 * @param int $id Id del usuario.
	 * @param string $nom Nombre del usuario.
	 * @param string $ape Apellidos del usuario.
	 * @param string $tipo Tipo de usuario ante el sistema.
	 * @return mysqli Resource de la consulta 
	 */
	public function ListarUsuarios($id,$nom,$ape,$tipo){
		$this->con = new GestionBD();
		$this->qry = "call spListarUsuarios($id,\"$nom\",\"$ape\",$tipo)";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		$this->con->CerrarConexion();
		return $res;
	}
	
	/**
	 * Registra un nuevo usuario en la base de datos.
	 * @return int $registrado 
	 */
	public function RegistrarUsuario(){
		$registrado = 0;
		$this->con = new GestionBD();
		$this->qry = "call spRegistrarUsuario(\"$this->nombre\",\"$this->apellidos\",\"$this->tipo_usuario\",\"$this->usuario\", \"$this->password\",@idc)";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($this->resource){
			$registrado = $this->con->RegresarParametro('@idc',$this->resource); //echo " ¡Enhorabuena! Su registro se ha realizado de manera exitosa.";
		}
		$this->con->CerrarConexion();
		return $registrado;
	}
	
	public function EliminarUsuario($idu){
		$this->con = new GestionBD();
		$this->qry = "call spEliminarUsuario($idu);";
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