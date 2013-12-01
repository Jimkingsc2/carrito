<?php 
require_once 'GestionBD.php';

Class Productos{
	private $id;
	private $categoria;
	private $nombre;
	private $marca;
	private $descripcion;
	private $precioVenta;
	private $stock;
	private $img;
	private $con;
	private $qry;
	private $resource;
	
	/**
	 * Inicializa las propiedades de la clase.
	 * @param int $cat Id de la categoría del producto.
	 * @param string $nom Nombre del producto.
	 * @param string $mar Marca del producto.
	 * @param string $des Descripción.
	 * @param double $preVen Precio de venta.
	 * @param int $stk Existencias del producto.
	 * @param string $img Nombre de la imagen del producto.
	 * @param int $id Id del producto.
	 */
	public function Inicializar($cat, $nom, $mar, $des, $preVen, $stk, $img, $id=0){
		$this->categoria = $cat;
		$this->nombre = $nom;
		$this->marca = $mar;
		$this->descripcion = $des;
		$this->precioVenta = $preVen;
		$this->stock = $stk;
		$this->img = $img;
		$this->id = $id;
	}
	
	/**
	 * Realiza el registro de un nuevo producto en la base de datos.
	 * @return int 
	 */
	public function RegistrarProducto(){
		$registrado = 0;
		$this->con = new GestionBD();
		$this->qry = "call spRegistrarProducto($this->id,$this->categoria,\"$this->nombre\",\"$this->marca\",\"$this->descripcion\",$this->precioVenta,$this->stock,\"$this->img\",@idp)";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($this->resource){
			$registrado = $this->con->RegresarParametro('@idp',$this->resource); 
		}
		$this->con->CerrarConexion();
		return $registrado;
	}
	
	/**
	 * Muestra uno o más productos según los parámetros recibidos.
	 * @param integer $idp Id del producto.
	 * @param integer $idc  Id de la categoría a la que pertenece el producto.
	 * @param string $mar Marca.
	 * @return mysqli Resource de la consulta.
	 */
	public function MostrarProductos($idp,$idc,$mar="0"){
		$this->con = new GestionBD();
		$this->qry = "call spListarProductos($idp,$idc,$mar)";
		//echo $this->qry;
		//exit;
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		$this->con->CerrarConexion();
		return $res;
	}
	
	public function EliminarProducto($idp){
		$this->con = new GestionBD();
		$this->qry = "call spEliminarProducto($idp);";
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

