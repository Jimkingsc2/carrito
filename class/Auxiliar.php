<?php

class Auxiliar{
	private $val;
	private $con;
	private $qry;
	private $resource;
	private $esSQLI;
        private $badCode = array('select','from','delete','where','update','having',
        'order','by','union','all', 'and','or','=','>','<',/*'\'','\"',*/'information_schema','table_name','column_name');
        private $badWord;
	
	/**
	 * Valida una variable GET/POST numérica.
	 * 
	 * @param integer $var Variable que se desea validar.
	 * @return integer $val Variable validada.
	 */
	public function ValidarVariableGetNumerica($var){
		if(isset($var) and !is_null($var) && is_numeric($var)){
			$this->val =  $var;
		}else{
			$this->val = null;
		}
		return $this->val;
	}
	
	/**
	 * Valida una variable GET/POST string.
	 * @param string $var. Variable que se desea validar.
	 * @return string $val. Variable validada,
	 */
	public function ValidarVariableGetString($var){
		if(isset($var) and !is_null($var) && $var != ""){
			$this->val =  $var;
		}else{
			$this->val = null;
		}
		return $this->val;
	}
	
	public static function LimpiarSesiones(){
		session_unset();
		session_destroy();
		session_start();
	}
	
	/**
	 * Sube un archivo al servidor y lo coloca el la ruta recibida como parámetro.
	 * @param string $file Nombre del archivo que se pretende subir al servidor.
	 * @param string $ruta Ruta donde se alojará el archivo a subir.
	 * @return int Devuelve 1 en caso de éxito. 0 en caso contrario.
	 */
	public function SubirArchivo($file,$ruta){
		if(is_uploaded_file($file['tmp_name'])){
			$carpeta = $ruta; //"../../img/";
			$nombre_tmp = $file['tmp_name'];
			$nombre = $file['name'];
			 
			$destino =  $carpeta."".$nombre; //."".$_FILES['banner']['name'];
			 
			if(copy($nombre_tmp,$destino)) {
				$status = 1;
			} else {
				$status = 0;
			}
		}
		return $estatus;
	}
	
	/**
	 * Realiza el registro de un email en el boletin.
	 * @param string $email Correo electrónico a registrar.
	 * @return int 
	 */
	public function AgregarEmailBoletin($email){
		$registrado = 0;
		$this->con = new GestionBD();
		$this->qry = "call spRegistrarBoletin(\"$email\",@reg)";
		$res = $this->con->ejecutar_consulta($this->qry) or die("Error en la consulta: " .  $this->qry);
		if($res){
			$registrado = $this->con->RegresarParametro("@reg",$res);
		}
		$this->con->CerrarConexion();
		return $registrado;
	}
	
	public function ListarCorreosBoletin(){
		$this->con = new GestionBD();
		$this->qry = "call spListarCorreosBoletin()";
		$res = $this->con->ejecutar_consulta($this->qry) or die("Error en la consulta: " .  $this->qry);
		$this->con->CerrarConexion();
		return $res;
	}
	
	public function GenerarListaCorreos(){
		$mails = $this->ListarCorreosBoletin();
		$this->con = new GestionBD();
		$count = $this->con->NumeroRows($mails);
		$losemails="";
		$i = 1;
		while($rows = $this->con->devolver_array($mails)){
				
			$losemails.=($rows['EMAIL'].", ");
			$largo=strlen($losemails);
			
			if($i == $count){
				if ($largo>2)
				{
					//quitamos ultimos ", "
					$losemails=substr($losemails,0,$largo-2);
				}
			}
			$i++;
		}
		return $losemails;
	}
	
	public function GenerarPlantillaBoletin($titulo, $lista){
		$mensaje='<html>
			<head>
			   <title>Linkmart.com :: Newsletter</title>
			   <style type="text/css">
				td.item{
					color:red;
					width: 120px;
					height: 120px;
					font-weight: bold;
				}
			   </style>
			</head>
			<body>
			   <p style="text-align:center;">'.$titulo.'</p>';
			   $mensaje .= $lista;
//				for ($row=0;$row<count($lista);$row++) {
//					//echo $lista[$i] . "<br />";
//					$mensaje .= "<tr>";
//						for ($col = 0; $col < 3; $col++)
//						{
//							$mensaje .= "<td class='item'>".$lista[$row][$col]."</td>";
//						}
//					$mensaje .= "</tr>";
//				} 
			   
		$mensaje .= '</body></html>';
		
		return $mensaje;
	}
	
	public function SendMail($asunto, $envia, $emailRemite, $listado, $msj){
		$cabeceras  = "MIME-Version: 1.0" . "\r\n";
		$cabeceras .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
		$cabeceras .= "From: ".$envia." <".$emailRemite.">" . "\r\n";
					
		if(mail($listado, $asunto, $msj, $cabeceras)){
			echo 1;
		}else{
			echo 0;
		}
	}
        
        public function setVariableString($var)
        {
            $var = stripslashes(str_replace("'","",$var));
            return (is_null($var) || $var == '') ? '': trim($var);
        }
        
        public function  setVariableInteger($var)
        {
            return (is_null($var) || $var == 0) ? 0: trim($var);
        }
        
        public function BuscarPosibleSQLI($variables)
        {
            //$parts = preg_split('/[\s,]+/', $variable, -1, PREG_SPLIT_NO_EMPTY);
            for($h=0; $h<count($variables);$h++){
                $parts = preg_split('/[\s,]+/', $variables[$h], -1, PREG_SPLIT_NO_EMPTY);
                for($i=0; $i < count($parts); $i++){
    //                if(preg_match("/\'/", $parts[$i]) or preg_match("/\"/", $parts[$i])){
    //                    $this->esSQLI = true;
    //                    $this->badWord = "\'";
    //                    break;   
    //                }
                    for($j=0; $j < count($this->badCode); $j++){
                        if(strtolower($parts[$i]) == strtolower($this->badCode[$j])){
                            $this->esSQLI = true;
                            $this->badWord = $parts[$i];
                        }else{
                            $this->esSQLI = false;
                        }
    //                   $this->ChecarEstatusSQLI();
                         if($this->esSQLI == true){
                            break;
                         }
                    }
    //                $this->ChecarEstatusSQLI();
                        if($this->esSQLI == true){
                            break;
                         }
                }
    //            $this->ChecarEstatusSQLI();
                        if($this->esSQLI == true){
                            break;
                         }
            }
            return $this->esSQLI;
        }
        
    /**
     * Llena un control combobox con los datos almacenados en un catalogo
     * @param string $table Nombre de la tabla de la que se desea extraer la informacion
     * @param string $id Nombre del campo que representa la llave primaria del catalogo
     * @param string $value Nombre del campo que describe al catalogo
     * @param string $where Condicion para filtrar los resultados de la consulta
     */
    public static function llenarCombobox($table, $id, $value, $where=null)
    {
        $con = new Conexion();
        echo "<option value='0'>Seleccione</option>";
        if(is_null($where)){
            $res = $con->ejecutar_consulta("select {$id},{$value} from {$table} order by {$value} asc");
            if($res){
                while($rows = $con->devolver_array($res)){
                    echo "<option value='{$rows[$id]}'>{$rows[$value]}</option>";
                }
            }
        }else{
             $res = $con->ejecutar_consulta("select {$id},{$value} from {$table} where $where order by {$value} asc");
            if($res){
                while($rows = $con->devolver_array($res)){
                    echo "<option value='{$rows[$id]}'>{$rows[$value]}</option>";
                }
            }
        }
    }
}
