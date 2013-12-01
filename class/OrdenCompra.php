<?php
class OrdenCompra{
	private $idOrden;
	private $fecha;
	private $idCliente;
	private $importe;
	private $estatus;
	private $con;
	private $qry;
	private $resource;
	
	/**
	 * Inicializa las propiedadesd de la clase.
	 * @param integer $ord
	 * @param date $fec
	 * @param integer $cli
	 * @param double $imp
	 * @param string $est 
	 */
	public function Inicializar($fec, $cli, $imp, $est, $ord=null){
		$this->idOrden = $ord;
		$this->fecha = $fec;
		$this->idCliente = $cli;
		$this->importe = $imp;
		$this->estatus = $est;
	}
	
	
	/**
	 * Muestra los productos que pertenecen a una orden de compra.
	 * @param integer $idoc Id de una orden de compra.
	 * @return mysqli $res Resource de una consulta a la base de datos.  
	 */
	public function MostrarDetallesOrden($idoc){
		$this->con = new GestionBD();
		$this->qry = "call spListarDetallesOrden($idoc)";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		$this->con->CerrarConexion();
		return $res;
	}
	
	public function MostrarOrdenesPendientes(){
		$this->con = new GestionBD();
		$this->qry = "call spListarOrdenesPendientes()";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		$this->con->CerrarConexion();
		return $res;
	}
	
	public function CambiarEstatusOrden($ido, $estatus){
		$this->registrado = 0;
		$this->con = new GestionBD();
		$this->qry = "call spCambiarEstatusOrden(\"$estatus\",$ido,@idCliente);";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($this->resource){
			$this->registrado = $this->con->RegresarParametro('@idCliente'); 
		}
		$this->con->CerrarConexion();
		return $this->registrado;
	}
	
	public function CancelarDetalleOrden($idp, $cant, $idd){
		$this->con = new GestionBD();
		$this->qry = "call spCancelarDetalleOrden($idp,$cant,$idd);";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		$this->con->CerrarConexion();
		return $res;
	}
}