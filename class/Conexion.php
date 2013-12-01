<?php

class Conexion {
	private $host = "localhost";
	private $user = "root";
	private $pass = "dhj23";
	private $db = "store";
	public $conn;
	private $res; 
	
	public function __construct(){
            $this->conectar();
	}
	/**
	 * Metodo que abre una conexión a la base de datos.
	 * @return mysqli $conn Una instancia de mysqli.
	 */
	public function conectar(){
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
        if($this->conn->connect_error){
            die("Error en la conexion : " . $this->conn->connect_errno. "-" . $this->conn->connect_error);
        }else{
        	return $this->conn;	
        }
    }
    
    /**
    * Cierra una conexion con la base de datos.
    */
    public function desconectar(){
        if(!is_null($this->conn)){
            $this->conn->close();
        }
    }
    
    /**
     * Metodo para hacer consultas a la base de datos
     * @param string $consulta Query en formato sql
     * @return mysqli $res El resultado que genera la consulta a la base de datos.
     */
    public function ejecutar_consulta($consulta){
        $this->limpiar_results();
    	$this->res= $this->conn->query($consulta) or die($this->conn->error . " (".$consulta.")");
    	return $this->res;
    }
    
    /**
     * Devuelve un array con el resource recibido como parametro.
     * @param string $res Resource devuelto por un query a la base de datos.
     * @return array 
     */
    public function devolver_array($res){
    	return $res->fetch_array(MYSQLI_ASSOC);
    }
    
    /**
     * Regresa un parametro del último resource devuelto por una consulta a la base de datos.
     * @param string $param Nombre del parametro.
     * @return string $val Valor del parámetro.
     */
    public function devolver_parametro($param){
//    	$val = null;
    	$this->res= $this->conn->query("SELECT $param") or die($this->conn->error);
		$row = $this->devolver_array($this->res);
		return $row[$param]; 
//		return $val; 
    }
    
    /**
     * Regresa el número de registros que tiene el resource recibido como parámetro.
     * @param mysqli $res Resource de una consulta a la base de datos.
     * @return int num_rows Número de registros que hay en el resource.
     */
    public function numero_registros($res){
    	return $res->num_rows;
    }
    
    /**
     * Regresa el valor del campo recibido como parametro
     * @param string $campo Nombre del campo que se desea consultar
     * @return string
     */
    public function regresar_valor_campo($campo)
    {
        $val = null;
        $row = $this->RegresarArray($this->res);
        $val = $row[$campo]; 
        return $val; 
    }
    
    /**
     * Libera un resource de una consulta
     */	
    private function free()
    {
        $this->res->free();
        $this->res= null;
    }
    
    /**
     * Verifica que haya mas registros en un resource
     * @return boolean
     */
    protected function ver_mas_resultados()
    {
        if($this->conn->more_results()){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Libera los registros de un resource
     */
    protected function limpiar_results()
    {
        if($this->ver_mas_resultados()){
            if($this->conn->next_result()){
                if($this->res= $this->conn->store_result()){
                    $this->free();
                }
                $this->limpiar_results(); // <----------- recursive call is your friend
            }
        }
    }
}
