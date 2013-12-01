<?php
require_once 'Conexion.php';

Class Categorias{
	private $id;
	private $categoria;
	private $descripcion;
        private $categoria_padre;
	private $con;
	private $qry;
	private $resource;
	
	/**
	 * Inicializa las propiedades de la clase.
	 * @param string $cat Nombre de la categoría.
	 * @param string $desc Descripción de la categoría.
	 * @param int $id Id de la categoría.
	 */
	public function Inicializar($cat,$desc,$idcp,$id=0){
		$this->id = $id;
		$this->categoria = $cat;
		$this->descripcion = $desc;
                $this->categoria_padre = $idcp;
	}
	
	/**
	 * Realiza el registro de una nueva categoría en la base de datos.
	 * @return int El id de la nueva categoría. 
	 */
	public function  RegistrarCategoria(){
		$this->con = new Conexion();
		$this->qry = "call spREGISTRAR_CATEGORIA($this->id,\"$this->categoria\",\"$this->descripcion\",\"$this->categoria_padre\",@idc)";
		$this->resource = $this->con->ejecutar_consulta($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($this->resource){
			$registrado = $this->con->devolver_parametro('@idc');
		}
		return $registrado;
	}
	
	/**
	 * Muestra un listado con los links de las categorías existentes.
	 */
	public function ListarMenuCategorias($sgi=false){
            if(!$sgi){
		$this->con = new Conexion();
		$this->qry = "call paLISTAR_CATEGORIAS(0,0)";
		$this->resource = $this->con->ejecutar_consulta($this->qry) or die("Error en la consulta: " .  $this->qry);
                echo "<ul id='nav'>";
		while($row = $this->con->devolver_array($this->resource)){
                    $sub = "call paLISTAR_CATEGORIAS(0,{$row['id']})";
                    $res_sub = $this->con->ejecutar_consulta($sub);
                    if($this->con->numero_registros($res_sub) > 0){
                        if($row['subcategoria_de'] != null){
                            continue;
                        }
                        echo "<li><a href='#' class='sub' tabindex='1'><img src='img/t4.png' />{$row['categoria']}</a><img src='img/up.gif' alt='' /><ul>";
                        while($row_sub = $this->con->devolver_array($res_sub)){
                            echo "<li><a href='#'><img src='img/empty.gif' />{$row_sub['categoria']}</a></li>";
                        }
                        echo "</ul></li>";
                    }else{
                         if($row['subcategoria_de'] != null){
                            continue;
                        }
                        echo "<li><a href='#'><img src='img/t4.png' />{$row['categoria']}</a></li>";
                    }
                    
                        
			//echo "<a href='categorias.php?idcat=".$row['IDCATEGORIA']."'>".$row['CATEGORIA']."</a><br />";
		}
		echo "</ul>";
            }else{
                echo "<ul id='nav'>
                        <li>
                            <a href='#' class='sub' tabindex='1'><img src='../img/t4.png' />Catalogos</a>
                                <img src='../img/up.gif' alt='' />
                                <ul>
                                    <li><a href='#' onclick='mostrar_form(\"administradores\")'><!--<img src='../img/empty.gif' />-->Administradores</a></li>
                                    <li><a href='#' onclick='mostrar_form(\"categorias\")'><!--<img src='../img/empty.gif' />-->Categorias</a></li>
                                    <li><a href='#' onclick='mostrar_form(\"marcas\")'><!--<img src='../img/empty.gif' />-->Marcas</a></li>
                                    <li><a href='#' onclick='mostrar_form(\"articulos\")'><!--<img src='../img/empty.gif' />-->Articulos</a></li>
                                    <li><a href='#' onclick='mostrar_form(\"clientes\")'><!--<img src='../img/empty.gif' />-->Clientes</a></li>
                                </ul>
                        </li>
                         <li>
                            <a href='#' class='sub' tabindex='1'><img src='../img/t4.png' />Ordenes</a>
                                <img src='../img/up.gif' alt='' />
                                <ul>
                                    <li><a href='#'><!--<img src='../img/empty.gif' />-->Ordenes Pendientes</a></li>
                                    <li><a href='#'><!--<img src='../img/empty.gif' />-->Ingresos del Mes</a></li>
                                </ul>
                        </li>
                         <li>
                            <a href='#' class='sub' tabindex='1'><img src='../img/t4.png' />Sesion</a>
                                <img src='../img/up.gif' alt='' />
                                <ul>
                                    <li><a href='#' onclick='cerrar_sesion()'>Cerrar Sesion</a></li>
                                    
                                </ul>
                        </li>
                    </ul>";
            }
	}
	
	/**
	 * Consulta una o más categorias.
	 * @param int $idc Id de la categoría que se quiere consultar.
	 * @return mysqli
	 */
	public function ListarCategorias($idc){
		$this->con = new Conexion();
		$this->qry = "call spListarCategorias($idc)";
		$this->resource = $this->con->ejecutar_consulta($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		
		return $res;
	}
	
	public function EliminarCategoria($idcat){
		$this->con = new Conexion();
		$this->qry = "call spEliminarCategoria($idcat);";
		$this->resource = $this->con->ejecutar_consulta($this->qry) or die("Error en la consulta: " .  $this->qry);
		$res = $this->resource;
		
		if(!empty($res)){
			return 1;
		}else{
			return 0;
		}
	}
}


