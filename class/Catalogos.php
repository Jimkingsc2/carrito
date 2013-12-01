<?php
class Catalogos{
    
    public static function listar_administradores()
    {
        $con = new Conexion();
        $sql = "call paLISTAR_ADMIN(0,'');";
        $res = $con->ejecutar_consulta($sql);
        if($res){
            if($con->numero_registros($res)>0){
                echo "<table class='table_cat'>
                    <tr class='table_head'>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th></th>
                    </tr>";
                $i=0;
                while($row = $con->devolver_array($res)){
                    $clase = ($i % 2 == 0) ? "par":"impar";
                    echo "<tr class='$clase fuente_media'>
                        <td class='center'>{$row['id']}</td>
                        <td>{$row['nombre_completo']}</td>
                        <td>{$row['nick']}</td>
                        <td class='center'>
                            <div class='opcion'>
                            <a href='#' onclick='seleccionar_admin({$row['id']},\"{$row['nombre_completo']}\",\"{$row['nick']}\",\"{$row['password']}\")'>
                                <img class='ico' src='../img/editar.png' alt='Editar Admin' border='0' title='Editar' />
                            </a>
                            </div>
                            <div class='opcion'>
                            <a href='#' onclick='eliminar_admin({$row['id']})'>
                                <img class='ico' src='../img/eliminar_admin.png' alt='Eliminar Admin' border='0' title='Eliminar' />
                            </a>
                            </div>
                        </td>
                    </tr>";
                    $i++;
                }
                echo "</table>";
            }else{
                echo "No hay registros";
            }
        }
    }
    
    public static function listar_categorias()
    {
        $con = new Conexion();
        $sql = "call paLISTAR_CATEGORIAS(0,0);";
        $res = $con->ejecutar_consulta($sql);
        if($res){
            if($con->numero_registros($res)>0){
                echo "<table class='table_cat'>
                    <tr class='table_head'>
                        <th>Id</th>
                        <th>Categoria</th>
                        <th>Descripcion</th>
                        <th></th>
                    </tr>";
                $i=0;
                while($row = $con->devolver_array($res)){
                    $clase = ($i % 2 == 0) ? "par":"impar";
                    $sub = (is_null($row['subcategoria_de']) || $row['subcategoria_de'] == "") ? 0 : $row['subcategoria_de'];
                    echo "<tr class='$clase fuente_media'>
                        <td class='center'>{$row['id']}</td>
                        <td>{$row['categoria']}</td>
                        <td>{$row['descripcion']}</td>
                        <td class='center'>
                            <div class='opcion'>
                            <a href='#' onclick='seleccionar_cate({$row['id']},\"{$row['categoria']}\",\"{$row['descripcion']}\",{$sub})'>
                                <img class='ico' src='../img/editar.png' alt='Editar Admin' border='0' title='Editar' />
                            </a>
                            </div>
                            <div class='opcion'>
                            <a href='#' onclick='eliminar_cate({$row['id']})'>
                                <img class='ico' src='../img/eliminar.png' alt='Eliminar Admin' border='0' title='Eliminar' />
                            </a>
                            </div>
                        </td>
                    </tr>";
                    $i++;
                }
                echo "</table>";
            }else{
                echo "No hay registros";
            }
        }
    }
    
    public static function listar_marcas()
    {
        $con = new Conexion();
        $sql = "call paLISTAR_MARCAS(0,'');";
        $res = $con->ejecutar_consulta($sql);
        if($res){
            if($con->numero_registros($res)>0){
                echo "<table class='table_cat'>
                    <tr class='table_head'>
                        <th>Id</th>
                        <th>Marca</th>
                        <th></th>
                    </tr>";
                $i=0;
                $row = null;
                while($row = $con->devolver_array($res)){
                    $clase = ($i % 2 == 0) ? "par":"impar";
                    echo "<tr class='$clase fuente_media'>
                        <td class='center'>{$row['id']}</td>
                        <td>{$row['marca']}</td>
                        <td class='center'>
                            <div class='opcion'>
                            <a href='#' onclick='seleccionar_marca({$row['id']},\"{$row['marca']}\")'>
                                <img class='ico' src='../img/editar.png' alt='Editar Admin' border='0' title='Editar' />
                            </a>
                            </div>
                            <div class='opcion'>
                            <a href='#' onclick='eliminar_marca({$row['id']})'>
                                <img class='ico' src='../img/eliminar.png' alt='Eliminar Admin' border='0' title='Eliminar' />
                            </a>
                            </div>
                        </td>
                    </tr>";
                    $i++;
                }
                echo "</table>";
//                $page = (isset($_GET['npg'])) ? $_GET['npg'] : 1;
//                $paginator = new Paginator();
//                $selectFiles = $paginator->SelectPage($page, $row);
//                $category_param = "";
//                if($_GET['cat'] != "") $category_param = "?cat=".$_GET['cat'];
//                $paginator->ShowControls($_SERVER['PHP_SELF'].$category_param);
//                $paginator->ShowControls();
            }else{
                echo "No hay registros";
            }
        }
    }
}
