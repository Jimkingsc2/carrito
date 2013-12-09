<?php
session_start();
if(!isset($_SESSION['id_usuario']) && !isset($_SESSION['nombre_usuario'])){
    session_unset();
    session_destroy();
    header("location:../");
}
require_once '../class/Conexion.php';
require_once '../class/Categorias.php';
$cat = new Categorias();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title>Sistema de Gestion Interna</title>
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../js/jquery.bxslider.js"></script>
        <script type="text/javascript" src="../js/jquery.bxslider.min.js"></script>
        <script type="text/javascript" src="../js/funciones.js"></script>
        <script type="text/javascript" src="../js/AjaxUpload.2.0.min.js"></script>
        <link rel="stylesheet" href="../css/estilo.css" />
        <link rel="stylesheet" href="../css/menu.css" type="text/css" media="screen">
        
    </head>
    <body onload="mostrar_form('categorias');">
        <section id="contenedor">
            <header>
                <h1 class="encabezado">Sistema de Gestion Interna</h1>
            </header>
                        
           
            <aside class="menu_lateral">
                <?php
                $cat->ListarMenuCategorias(true);
                ?>
            </aside>
            <section id="webs">
               
                <article>
                    <img src="img/compra.jpg" alt="Compras en linea" height="100" width="100" />
                    <p>Esta es una imagen de prueba para seguir el tutorial de responsive design</p>
                </article>
                <article>
                    <img src="img/compra.jpg" alt="Compras en linea" height="100" width="100" />
                    <p>Esta es una imagen de prueba para seguir el tutorial de responsive design</p>
                </article>
                <article>
                    <img src="img/compra.jpg" alt="Compras en linea" height="100" width="100" />
                    <p>Esta es una imagen de prueba para seguir el tutorial de responsive design</p>
                </article>
                <article>
                    <img src="img/compra.jpg" alt="Compras en linea" height="100" width="100" />
                    <p>Esta es una imagen de prueba para seguir el tutorial de responsive design</p>
                </article>
                <article>
                    <img src="img/compra.jpg" alt="Compras en linea" height="100" width="100" />
                    <p>Esta es una imagen de prueba para seguir el tutorial de responsive design</p>
                </article>
                <article>
                    <img src="img/compra.jpg" alt="Compras en linea" height="100" width="100" />
                    <p>Esta es una imagen de prueba para seguir el tutorial de responsive design</p>
                </article>
                <article>
                    <img src="img/compra.jpg" alt="Compras en linea" height="100" width="100" />
                    <p>Esta es una imagen de prueba para seguir el tutorial de responsive design</p>
                </article>
            </section>
            <footer>
                &copy; 2013 | Tienda 
            </footer>
        </section>
    </body>
</html>
