<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<article class="formulario">
    <form name="frmLogin" id="frmLogin">
        <label for="txtUser">Usuario</label>
        <input type="text" name="txtUser" id="txtUser" tabindex="1" onkeypress="next_control(event,1)" />
        <label for="txtPass">Password</label>
        <input type="password" name="txtPass" id="txtPass" tabindex="2" onkeypress="lanzar_funcion(event,validar_login)" />
        <input type="button" class="boton" name="btnLogin" id="btnLogin" value="Ingresar" onclick="validar_login()" />
    </form>
    <div id="mensajeLogin">
        
    </div>
</article>

