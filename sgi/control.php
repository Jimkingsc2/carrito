<?php
session_start();
error_reporting(E_ALL);

require_once '../class/Conexion.php';
require_once '../class/Auxiliar.php';
require_once '../class/Catalogos.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$action = ($_POST) ? $_POST['action'] : $_GET['action'];

switch ($action){
    case "login":
        $aux = new Auxiliar();
        $user = $aux->setVariableString($_POST['usuario']);
        $pass = $aux->setVariableString($_POST['password']);
        $cont = 0;
        $valida = array($user,$pass);
        if(!$aux->BuscarPosibleSQLI($valida)){
            $bd = new Conexion();
            $sql = "call paLOGIN('{$user}','{$pass}');";
            $res = $bd->ejecutar_consulta($sql);
            if($res){
                $cont = $bd->numero_registros($res);
                $row = $bd->devolver_array($res);
                session_start();
                $_SESSION['id_usuario'] = $row['id'];
                $_SESSION['nombre_usuario'] = $row['nombre_completo'];
                $var = ($cont > 0) ? "true" : "<span class='ataque'>No se encontro ningun usuario con estas credenciales.</span>";
                echo $var;
            }else{
                echo "<span class='ataque'>No se puedo autenticar esta cuenta. Reintente</span>";
            }
        }else{
            echo "<span class='ataque'>Esta tratando de ingresar codigo malicioso</span>";
        }
        break;
        
    case "logout":
        session_unset();
        session_destroy();
        
        break;
    
    case "administradores":
        ?>
        <h2>Catalogo Administradores</h2>
        <article class="formulario" style="width: auto;">
            <form name="frmAdmin" id="frmAdmin">
                <table>
                    <tr>
                        <td>
                            <label for="txtIdAdmin">Id</label>
                        </td>
                        <td>
                            <input type="text" name="txtIdAdmin" id="txtIdAdmin" tabindex="1" onkeypress="next_control(event,1)" disabled="disabled" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtNombreAdmin">Nombre</label>
                        </td>
                        <td>
                            <input type="text" name="txtNombreAdmin" id="txtNombreAdmin" tabindex="2" onkeypress="next_control(event,2)" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtUserAdmin">Usuario</label>
                        </td>
                        <td>
                            <input type="text" name="txtUserAdmin" id="txtUserAdmin" tabindex="3" onkeypress="next_control(event,3)" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtPassAdmin">Password</label>
                        </td>
                        <td>
                            <input type="password" name="txtPassAdmin" id="txtPassAdmin" tabindex="4" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="right">
                            <input type="hidden" name="txtAccionAdmin" id="txtAccionAdmin" value="" />
                            <input type="reset" name="btnResetAdmin" id="btnResetAdmin" value="Limpiar" />
                            <input type="button" class="boton" name="btnAdmin" id="btnAdmin" value="Guardar" onclick="guardar_admin()" />
                        </td>
                    </tr>
                </table>
            </form>
        </article>
        <div id="catalogo_admin">
            
        </div>
        <?php
        break;
    
    case "categorias":
        ?>
        <h2>Catalogo Categorias</h2>
        <article class="formulario" style="width: auto;">
            <form name="frmCate" id="frmCate">
                <table>
                    <tr>
                        <td>
                            <label for="txtIdCate">Id</label>
                        </td>
                        <td>
                            <input type="text" name="txtIdCate" id="txtIdCate" tabindex="1" onkeypress="next_control(event,1)" disabled="disabled" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtNombreCate">Categoria</label>
                        </td>
                        <td>
                            <input type="text" name="txtNombreCate" id="txtNombreCate" tabindex="2" onkeypress="next_control(event,2)" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtDescribeCate">Descripcion</label>
                        </td>
                        <td>
                            <textarea id="txtDescribeCate" name="txtDescribeCate"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cbbSubCate">Depende de</label>
                        </td>
                        <td>
                            <select name="cbbSubCate" id="cbbSubCate">
                                <?php
                                        Auxiliar::llenarCombobox("categorias", 'id', 'categoria', 'subcategoria_de IS NULL');
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="right">
                            <input type="hidden" name="txtAccionCate" id="txtAccionCate" value="" />
                            <input type="reset" name="btnResetCate" id="btnResetCate" value="Limpiar" />
                            <input type="button" class="boton" name="btnCate" id="btnCate" value="Guardar" onclick="guardar_categoria()" />
                        </td>
                    </tr>
                </table>
            </form>
        </article>
        <div id="catalogo_cate">
            
        </div>
        <?php
        break;
    
    case "marcas":
        ?>
        <h2>Catalogo de Marcas</h2>
        <article class="formulario" style="width: auto;">
            <form name="frmMarca" id="frmMarca">
                <table>
                    <tr>
                        <td>
                            <label for="txtIdMarca">Id</label>
                        </td>
                        <td>
                            <input type="text" name="txtIdMarca" id="txtIdMarca" tabindex="1" onkeypress="next_control(event,1)" disabled="disabled" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtMarca">Marca</label>
                        </td>
                        <td>
                            <input type="text" name="txtMarca" id="txtMarca" tabindex="2" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="right">
                            <!--<input type="hidden" name="txtAccionAdmin" id="txtAccionAdmin" value="" />-->
                            <input type="reset" name="btnResetMarca" id="btnResetMarca" value="Limpiar" />
                            <input type="button" class="boton" name="btnMarca" id="btnMarca" value="Guardar" onclick="guardar_marca()" />
                        </td>
                    </tr>
                </table>
            </form>
        </article>
        <div id="catalogo_marca">
            
        </div>
        <?php
        break;
    
    case "articulos":
        ?>
        <h2>Catalogo Articulos</h2>
        <article class="formulario" style="width: auto;">
            <form name="frmArticulos" id="frmArticulos" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>
                            <label for="txtIdArticulo">Id</label>
                        </td>
                        <td>
                            <input type="text" name="txtIdArticulo" id="txtIdArticulo" tabindex="1" onkeypress="next_control(event,1)" disabled="disabled" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtNombreArticulo">Articulo</label>
                        </td>
                        <td>
                            <input type="text" name="txtNombreArticulo" id="txtNombreArticulo" tabindex="2" onkeypress="next_control(event,2)" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="txtDescribeArticulo">Descripcion</label>
                        </td>
                        <td>
                            <textarea id="txtDescribeArticulo" name="txtDescribeArticulo"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cbbSubCate">Precio de venta</label>
                        </td>
                        <td>
                            <input type="text" name="txtNombreArticulo" id="txtNombreArticulo" tabindex="4" onkeypress="next_control(event,4)" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cbbSubCate">Marca</label>
                        </td>
                        <td>
                            <select name="cbbSubCate" id="cbbSubCate">
                                <?php
                                        Auxiliar::llenarCombobox("marcas", 'id', 'marca');
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cbbSubCate">Categoria</label>
                        </td>
                        <td>
                            <select name="cbbSubCate" id="cbbSubCate">
                                <?php
                                        Auxiliar::llenarCombobox("categorias", 'id', 'categoria', 'subcategoria_de IS NULL');
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cbbSubCate">SubCategoria</label>
                        </td>
                        <td>
                            <select name="cbbSubCate" id="cbbSubCate">
                                <?php
                                        Auxiliar::llenarCombobox("categorias", 'id', 'categoria', 'subcategoria_de IS NOT NULL');
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cbbSubCate">Imagen</label>
                        </td>
                        <td>
                            <input type="file" name="imagen" id="imagen" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="right">
                            <input type="hidden" name="txtAccionCate" id="txtAccionCate" value="" />
                            <input type="reset" name="btnResetCate" id="btnResetCate" value="Limpiar" />
                            <input type="button" class="boton" name="btnCate" id="btnCate" value="Guardar" onclick="guardar_categoria()" />
                        </td>
                    </tr>
                </table>
            </form>
        </article>
        <div id="catalogo_cate">
            
        </div>
        <?php
        break;
    
    case "clientes":
        echo "Clientes...";
        break;
    //---------------A D M I N I S T R A D O R E S---------------------
    case "listarAdmin":
        Catalogos::listar_administradores();
        break;
    
    case "guardarAdmin":
        $aux = new Auxiliar();
        $nombre = $aux->setVariableString($_POST['nombre']);
        $user = $aux->setVariableString($_POST['usuario']);
        $pass = $aux->setVariableString($_POST['password']);
        $variables = array($nombre,$user,$pass);
        if(!$aux->BuscarPosibleSQLI($variables)){
            $bd = new Conexion();
            $sql = "call paREGISTRAR_ADMIN(0,'{$nombre}','{$user}','{$pass}',@id)";
            $res = $bd->ejecutar_consulta($sql);
            if($res){
                $id_registrado = $bd->devolver_parametro('@id');
                echo ($id_registrado > 0) ? "Registro exitoso." : "Error al registrar.Reintente";
            }else{
                echo "No ha sido posible registraar al admin. Reintente";
            }
        }else{
            echo "No se inserto el registro. Se detecto codigo malicioso.";
        }
        break;
        
    case "editarAdmin":
        $aux = new Auxiliar();
        $nombre = $aux->setVariableString($_POST['nombre']);
        $user = $aux->setVariableString($_POST['usuario']);
        $pass = $aux->setVariableString($_POST['password']);
        $id = $aux->setVariableInteger($_POST['ida']);
        $variables = array($nombre,$user,$pass,$id);
        if(!$aux->BuscarPosibleSQLI($variables)){
            $bd = new Conexion();
            $sql = "call paREGISTRAR_ADMIN({$id},'{$nombre}','{$user}','{$pass}',@id)";
            $res = $bd->ejecutar_consulta($sql);
            if($res){
                $id_registrado = $bd->devolver_parametro('@id');
                echo ($id_registrado > 0) ? "Actualizacion exitosa." : "Error al actualizar.Reintente";
            }else{
                echo "No ha sido posible actualizar al admin. Reintente";
            }
        }else{
            echo "No se actualizo el registro. Se detecto codigo malicioso.";
        }
        break;
        
    case "eliminarAdmin":
        $aux = new Auxiliar();
        $id = $aux->setVariableInteger($_POST['ida']);
        $bd = new Conexion();
        $sql = "call paELIMINAR_USUARIO({$id})";
        $res = $bd->ejecutar_consulta($sql);
        if($res){
            echo "Registro eliminado exitosamente";
        }else{
            echo "Error al eliminar el registro. Reintente";
        }
        break;
    //---------------A D M I N I S T R A D O R E S---------------------
    
    //-------------------C A T E G O R I A S------------------------
    case "listarCategorias":
        Catalogos::listar_categorias();
        break;
    
    case "guardarCate":
        $aux = new Auxiliar();
        $cate = $aux->setVariableString($_POST['categoria']);
        $desc = $aux->setVariableString($_POST['descripcion']);
        $subestudio = $aux->setVariableInteger($_POST['subestudio']);
        $variables = array($cate,$desc,$subestudio);
        if(!$aux->BuscarPosibleSQLI($variables)){
            $bd = new Conexion();
            $sql = "call paREGISTRAR_CATEGORIA(0,'{$cate}','{$desc}',{$subestudio},@id)";
            $res = $bd->ejecutar_consulta($sql);
            if($res){
                $id_registrado = $bd->devolver_parametro('@id');
                
                echo ($id_registrado > 0) ? "Registro exitoso." : "Error al registrar.Reintente";
            }else{
                echo "No ha sido posible registraar al admin. Reintente";
            }
        }else{
            echo "No se inserto el registro. Se detecto codigo malicioso.";
        }
        break;
        
   case "editarCate":
        $aux = new Auxiliar();
        $ida = $aux->setVariableInteger($_POST['ida']);
        $cate = $aux->setVariableString($_POST['categoria']);
        $desc = $aux->setVariableString($_POST['descripcion']);
        $subestudio = $aux->setVariableInteger($_POST['subestudio']);
        $variables = array($cate,$desc,$subestudio);
        if(!$aux->BuscarPosibleSQLI($variables)){
            $bd = new Conexion();
            $sql = "call paREGISTRAR_CATEGORIA({$ida},'{$cate}','{$desc}',{$subestudio},@id)";
            $res = $bd->ejecutar_consulta($sql);
            if($res){
                $id_registrado = $bd->devolver_parametro('@id');
                echo ($id_registrado > 0) ? "Actualizacion exitosa." : "Error al Actualizar.Reintente";
            }else{
                echo "No ha sido posible actualizar al admin. Reintente";
            }
        }else{
            echo "No se actualizo el registro. Se detecto codigo malicioso.";
        }
        break;
        
    case "eliminarCate":
        $aux = new Auxiliar();
        $id = $aux->setVariableInteger($_POST['ida']);
        $bd = new Conexion();
        $sql = "call paELIMINAR_CATEGORIA({$id})";
        $res = $bd->ejecutar_consulta($sql);
        if($res){
            echo "Registro eliminado exitosamente";
        }else{
            echo "Error al eliminar el registro. Reintente";
        }
        break;
    //-------------------C A T E G O R I A S------------------------
        
    //-------------------M A R C A S------------------------
    case "listarMarcas":
        Catalogos::listar_marcas();
        break;
    
    case "guardarMarca":
        $aux = new Auxiliar();
        $marca = $aux->setVariableString($_POST['marca']);
        if(!$aux->BuscarPosibleSQLI($marca)){
            $bd = new Conexion();
            $sql = "call paMARCAS(0,'{$marca}','registrar',@id)";
            $res = $bd->ejecutar_consulta($sql);
            if($res){
                $id_registrado = $bd->devolver_parametro('@id');
                
                echo ($id_registrado > 0) ? "Registro exitoso." : "Ya existe esta marca";
            }else{
                echo "No ha sido posible registrar la marca. Reintente";
            }
        }else{
            echo "No se inserto el registro. Se detecto codigo malicioso.";
        }
        break;
        
    case "editarMarca":
        $aux = new Auxiliar();
        $marca = $aux->setVariableString($_POST['marca']);
        $id = $aux->setVariableString($_POST['idm']);
        if(!$aux->BuscarPosibleSQLI($marca)){
            $bd = new Conexion();
            $sql = "call paMARCAS({$id},'{$marca}','editar',@id)";
            $res = $bd->ejecutar_consulta($sql);
            if($res){
                $id_registrado = $bd->devolver_parametro('@id');
                
                echo ($id_registrado > 0) ? "Actualizacion exitoso." : "Esta marca ya existe";
            }else{
                echo "No ha sido posible editar la marca. Reintente";
            }
        }else{
            echo "No se actualizo el registro. Se detecto codigo malicioso.";
        }
        break;
        
    case "eliminarMarca":
        $aux = new Auxiliar();
        $id = $aux->setVariableInteger($_POST['idm']);
        $bd = new Conexion();
        $sql = "call paMARCAS({$id},'{$marca}','eliminar',@id)";
        $res = $bd->ejecutar_consulta($sql);
        if($res){
            echo "Registro eliminado exitosamente";
        }else{
            echo "Error al eliminar el registro. Reintente";
        }
        break;
        break;
}
