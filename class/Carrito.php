<?php
session_start();
require_once 'Conexion.php';
/**
 * 
 * Clase para administrar un carrito de compras.
 * @author David Hernández Jiménez
 * @since 27/11/2012 16:02
 */
class Carrito{
	
	private $con;
	private $qry;
	private $resource;
	private $totalCompra;
	private $registrado; 
	
	/**
	 * Agrega un nuevo producto al carrito o actualiza la cantidad existente de un producto agregado.
	 *
	 * @param integer $stock Existencias actuales del producto.
	 * @param integer $cant Número de productos que se agregarán al carrito 
	 * @param integer $ref Clave o Id del producto.
	 */
	public function AgregarProducto($stock, $cant, $ref){
		if($stock != 0 and $stock > $cant){ 				//Checamos si hay productos en stock y si el stock es mayor a la cantidad requerida
			$exis = $stock; 												//declaramos cuantos productos hay en existencia.
			if(empty($_SESSION['carrito'][$ref])){//Verificamos que en el carrito no haya otro producto del mismo tipo (id)
							
				if($cant != 0){  											//Checamos que la cantidad solicitada sea distinta a cero
					if($exis > $cant){									//Si hay existencia para cubrir lo que se necesita definimos cuantas unidades se requieren
						$unidades = $cant;
					}else{ 													//De lo contrario, se avisa que la cantidad que se reuiere es mayor a la existencia
						?>
						<script type="text/javascript">
							alert('La cantidad actual es mayor que las existencias.');
						</script>
						<?php
					}
				}else{ 														//Si la cantidad es cero, asignamos 1 a las unidades que se requeriran
					$unidades = 1;
				}
			}else{ 															//Ambito de codigo que actua en caso de que ya existan productos del mismo tipo(id) en el carrito
																				//Checamos que la existencia sea mayor al numero de unidades en el carrito mas la cantidad extra que se requiere
				if($exis > $_SESSION['carrito'][$ref]+$cant){	//Actualizamos la cifra de unidades con la nueva cantidad 
					$unidades = $cant; 
					//$_SESSION['carrito'][$ref] + $cant;
				}else{ 													//De lo contrario, se avisa que la cantidad que se reuiere es mayor a la existencia
					?>
					<script type="text/javascript">
						alert("La cantidad actual es mayor que las existencias.");
						//self.close();
					</script>
					<?php
				}
			}
			$_SESSION['carrito'][$ref] = $unidades;
		}
	}
	
	
	/**
	 * Vacía la sesion que almacena los productos del carrito de compras.
	 */
	public function VaciarCarrito(){
		unset($_SESSION['carrito']);		
	}
	
	/**
	 * Muestra el total de productos que hay en el carrito de compras.
	 * @return integer Numero de productos;
	 */
	public function CountCarrito(){
		if(!empty($_SESSION['carrito'])){
			return count($_SESSION['carrito']);
		}else{
			return 0;
		}
	}
	
	/**
	 * Genera la informacion de los productos que hay en el carrito.
	 * @return array $carrito Una colección con los productos que hay en el carrito.	
	 */
	public function GenerarCarrito(){
		$carrito = array();
		if(!empty($_SESSION['carrito'])){
			foreach ($_SESSION['carrito'] as $ref => $unidades) {
				$carrito[$ref]=$unidades;
			}
		}
		return $carrito;
	}
	
	/**
	 * Muestra una tabla con los productos que hay actualmente en el carrito.
	 * @param array $carrito
	 * @return bool 
	 */
	function MostrarCarrito($carrito){
		?>
		<!--<h2>Su carrito</h2>-->
		<table width="100%" style="margin:0 auto;">
			<tr align="left">
				<th class="encTablaCar left">Cve</th>
				<th class="encTablaCar">Descripcion</th>
				<th class="encTablaCar">Precio Unitario</th>
				<th class="encTablaCar">Cantidad</th>
				<th class="encTablaCar right">Importe</th>
			</tr>
		
		<?
		$totalUnidades=0;
		if(empty($carrito)){
			?>
			<tr>
				<td align="center" colspan="5" style="color:red; padding: 20px; border:1px solid #CCC; border-radius: 5px;">El carrito esta vacio</td>
			</tr>
			<?
		}else{
			$i=0;
			foreach ($carrito as $ref => $unidades) {
				$this->con = new Conexion();
				$car = $this->con->ejecutar_query("call spListarProductos($ref,0,\"0\")");
				//$car = mysql_query("SELECT * FROM accesorio WHERE idaccesorio = $ref");
				$res = $this->con->NumeroRows($car);
				//$res = mysql_num_rows($car);
				//desconectar();
				if(!empty($res) and $res > 0){
					//while($row = mysql_fetch_array($car)){
					while($row = $car->fetch_array()){
						$importe = $unidades * $row['PRECIO_VENTA'];
						//if($i % 2 == 0){
						//	<tr align="left" style="background-color: #B7F46E;">
					//	}else{
						//	<tr align="left">
						//}
						?>
						<tr align="left">
						<td class="carrito"><? echo $row['IDPRODUCTOS']; ?></td>
						<td class="carrito"><? echo $row['PRODUCTO']; ?></td>
						<td class="carrito">$<? echo number_format($row['PRECIO_VENTA'],2); ?></td>
						<td class="carrito">
							<strong>(<? echo $unidades; ?>)</strong>&nbsp;&nbsp;
							<a href="editar.php?articulo=<?=$row['IDPRODUCTOS']?>&cant=<?=$unidades?>" target="Detalles del producto" onclick="window.open(this.href,this.target,'width=500,height=450,top=50,left=450'); return false;">
								Editar
							</a> |
							<a href="procesos.php?action=11&idp=<?=$row['IDPRODUCTOS']?>" target="Detalles del producto" onclick="if(confirm('¿Realmente desea eliminar este articulo de su carrito?')){ return true; }">
								Quitar
							</a>
						</td>
						<td class="carrito">$<? echo number_format($importe,2); ?></td>
						</tr>
						<?
					}
				}
				$totalUnidades += $unidades;
				$subtotalCompra += $importe;
				$i++;
			}
			//$iva = $subtotalCompra * 0.16;
			//$this->totalCompra = $subtotalCompra + $iva;
			$this->totalCompra = $subtotalCompra;
			?>
			<!--<tr style="background-color: silver; ">
				<td></td>
				<td></td>
				<td></td>
				<td class="carrito">IVA: </td>
				<td class="carrito">$<? //echo number_format($iva,2); ?></td>
			</tr>-->
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td class="carrito" style="font-weight: bold; font-size: 14px;">Total: </td>
				<td class="carrito" style="font-weight: bold; font-size: 14px;">$<? echo number_format($this->totalCompra,2); ?></td>
			</tr>
			<tr>
				<td class="encTablaCar bottomLeft bottomRight" colspan="5">Total de unidades: <? echo $totalUnidades; ?></td>
			</tr>
			<?
		}
		?>
		</table>
		<?
		return TRUE;
	}
		 
	/**
	 * Registra una orden de compra en la base de datos.
	 * @param datetime $fecha Fecha de la compra.
	 * @param integer $cte Id del cliente.
	 * @param double $tot Importe total de la compra.
	 * @param string $est Estatus de la orden.
	 * @return integer $registrado Numero de la nueva orden de compra. 
	 */
	public function RegistrarOrdenCompra($fecha, $cte, $tot, $est){
		$this->registrado = 0;
		$this->con = new Conexion();
		$this->qry = "call spRegistrarOrdenCompra($cte,\"$fecha\",$tot,\"$est\", @orden);";
		$this->resource = $this->con->EjecutarQuery($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($this->resource){
			$this->registrado = $this->con->RegresarParametro('@orden'); 
		}
		$this->con->CerrarConexion();
		return $this->registrado;
	}
	
	/**
	 * Registra los productos de una orden de compra.
	 * @param integer $ord Id de la orden de compra.
	 * @param integer $prod Id del producto.
	 * @param integer $cant Cantidad de productos.
	 * @param double $tot Importe del numero de productos.
	 * @return bool $realizado Indica si elregistro se ejecuto correctamente.
	 */
	public function RegistrarDetalleOrden($ord,$carrito){
		$realizado = null;
		if(empty($carrito)){
			$realizado = false;
		}else{
			
			foreach ($carrito as $cve => $unidades) {
				$this->con = new Conexion();
				$this->qry = "call spListarProductos(".$cve.",0,\"0\");";
				
				$car = $this->con->EjecutarQuery($this->qry);
				$res = $this->con->NumeroRows($car);
				if(!empty($res) and $res > 0){
					while($row = $car->fetch_array()){
						$prod = $row['IDPRODUCTOS'];
						$cant = $unidades; 
						$tot = $cant * $row['PRECIO_VENTA'];
						$this->registrado = 0;
						$this->con->CerrarConexion();
						$con2 = new Conexion();
						$qry2 = "call spRegistrarDetalleOrden($ord,$prod,$cant,$tot,@orden);";
						$res = $con2->EjecutarQuery($qry2) or die("Error en la consulta: " .  $qry2);
						if($res){
							$this->registrado = $con2->RegresarParametro('@orden'); 
							if($this->registrado >= 1){
								$realizado = true;
							}
						}
						$con2->CerrarConexion();
					}
				}else{
					$this->con->CerrarConexion();
				}
				if($realizado == false){
					break;
				}
				
			}
		}
		return $realizado;
	}
	
	/**
	 * Devuelve el importe total de un carrito de compras.
	 * @param array $carrito Array con los productos del carrito.
	 * @return double  $totalCompra Importe total de los productos en el carrito.
	 */
	public function VerTotalCompra($carrito){
		$this->totalCompra = 0;
		if(empty($carrito)){
			$this->totalCompra = 0;
		}else{
			foreach ($carrito as $ref => $unidades) {
				$this->con = new Conexion();
				$car = $this->con->EjecutarQuery("call spListarProductos($ref,0,\"0\")");
				$res = $this->con->NumeroRows($car);
				
				if(!empty($res) and $res > 0){
					while($row = $car->fetch_array()){
						$this->totalCompra += $row['PRECIO_VENTA']*$unidades;
					}
				}
			}
		}
		return $this->totalCompra;
	}
}