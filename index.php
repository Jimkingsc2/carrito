<?php
session_start();
require_once './class/Conexion.php';
require_once './class/Categorias.php';
$cat = new Categorias();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <title>Carrito de compras</title>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>-->
        <script type="text/javascript" src="js/jquery.bxslider.js"></script>
        <script type="text/javascript" src="js/jquery.bxslider.min.js"></script>
        <script type="text/javascript" src="js/funciones.js"></script>
        <link rel="stylesheet" href="css/jquery.bxslider.css" />
        <link rel="stylesheet" href="css/estilo.css" />
         <!--<link rel="stylesheet" href="css/layout.css" type="text/css" media="screen">-->
        <link rel="stylesheet" href="css/menu.css" type="text/css" media="screen">
        <script>
            $(document).ready(function(){
              $('.bxslider').bxSlider({
                  auto: true
              });
            });
        </script>
    </head>
    <body>
        <section id="contenedor">
            <nav>
                <ul>
                    <li><a href="">MiTienda.com</a></li>
                    <li><a href="">Novedades</a></li>
                    <li><a href="">Promociones</a></li>
                    <li><a href="">Registrate</a></li>
                </ul>
            </nav>            
            <section id="slider">
                 <ul class="bxslider">
                    <li><img src="img/pic1.jpg" /></li>
                    <li><img src="img/pic2.jpg" /></li>
                </ul>
            </section>
            <aside class="menu_lateral">
                <?php
                $cat->ListarMenuCategorias();
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
<!--                <article>
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
                </article>-->
            </section>
            <footer>
                &copy; 2013 | Tienda | <a href="javascript:void(0)" onclick="mostrar_form_login()" style="text-decoration: none; color: white;">SGI</a> 
            </footer>
        </section>
    </body>
</html>
