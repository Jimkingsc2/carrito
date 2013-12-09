
/**
 * Mostrar el formulario de login
 */
function mostrar_form_login()
{
    $.ajax({
        type: "POST",
        url: "./acceso.php",
        success: function(data) {
           $('#webs').html(data);
        }
    });
}

/**
 * Validar Login
 */
function validar_login(){
    var user = $("#txtUser").val();
    var pass = $("#txtPass").val();
    
    if(user != "" && pass != ""){
        $('#mensajeLogin').html("<img src='./img/cargando.gif' alt='Cargando...' />");
        
        $.ajax({
            type: "POST",
            url: "./sgi/control.php",
            data:{action: "login", usuario:user, password:pass},
            success: function(data) {
               if(data == "true"){
                   location.href='./sgi/';
               }else{
                   $('#mensajeLogin').html(data);
                   $("#mensajeLogin").delay(3000).fadeOut("slow");
               }
            }
        });
    }else{
       if(user == ""){
           alert("Ingrese su nick de usuario");
           $("#txtUser").focus();
       }else if(pass == ""){
           alert("Ingrese su password");
           $("#txtPass").focus();
       }
       return false;
    }
}

/**
 * Cerrar Sesion
 * @returns {undefined}
 */
function cerrar_sesion()
{
    $.ajax({
        type: "POST",
        url: "./control.php",
        data:{action: "logout"},
        success: function() {
           location.href = '../';
        }
    });
}

/**
 * Cambiar de control al presionar la tecla enter
 */
function next_control(e,index) {
   if (e.keyCode == 13) {
       index = index+1;
       $(':input[tabindex='+index+']').focus();
       $(':input[tabindex='+index+']').select();
   }
}

/**
 * Funcion que ejecuta una funcion al dar enter
 */
function lanzar_funcion(e, funcion){
    if (e.keyCode == 13) {
        funcion();
    }
}

function mostrar_listado(form)
{
    switch (form){
        case "administradores":
            listar_administradores();
            break;
        case "categorias":
            listar_categorias();
            break;
        case "marcas":
            listar_marcas();
            break;
    }
}

/**
 * Mostrar el formulario especificado
 * 
 */
function mostrar_form(formulario)
{
    $.ajax({
        type: "POST",
        url: "./control.php",
        data:{action:formulario},
        success: function(data) {
           $('#webs').html(data);
           mostrar_listado(formulario);            
        }
    });
}

/**
 * Muestra una tabla con los administradores existentes
 * @returns {undefined}
 */
function listar_administradores()
{
    $.ajax({
        type: "POST",
        url: "./control.php",
        data:{action:"listarAdmin"},
        success: function(data) {
           $('#catalogo_admin').html(data);
        }
    });
}

/**
 * Muestra una tabla con los administradores existentes
 * @returns {undefined}
 */
function listar_categorias()
{
    $.ajax({
        type: "POST",
        url: "./control.php",
        data:{action:"listarCategorias"},
        success: function(data) {
           $('#catalogo_cate').html(data);
        }
    });
}

/**
 * Muestra una tabla con las marcas existentes
 * @returns {undefined}
 */
function listar_marcas()
{
    $.ajax({
        type: "POST",
        url: "./control.php",
        data:{action:"listarMarcas"},
        success: function(data) {
           $('#catalogo_marca').html(data);
        }
    });
}

/**
 * Rellena el formulario de administradores segun el registro seleccionado
 * @param {int} id
 * @param {string} nombre
 * @param {string} nick
 * @param {string} pass
 * @returns {void}
 */
function seleccionar_admin(id,nombre,nick,pass){
    $("#txtIdAdmin").val(id);
    $("#txtIdAdmin").attr("disabled","disabled");
    $("#txtNombreAdmin").val(nombre);
    $("#txtUserAdmin").val(nick);
    $("#txtPassAdmin").val(pass);
    $("#btnAdmin").attr("value","Guardar Cambios");
}


function seleccionar_cate(id,cate,desc,sub_de){
    sub_de = (sub_de == "") ? 0 : sub_de;
    $("#txtIdCate").val(id);
    $("#txtNombreCate").val(cate);
    $("#txtDescribeCate").val(desc);
    $("#cbbSubCate").val(sub_de);
    $("#btnCate").attr("value","Guardar Cambios");
}

function seleccionar_marca(id,marca){
    $("#txtIdMarca").val(id);
    $("#txtMarca").val(marca);
    $("#btnCate").attr("value","Guardar Cambios");
}

/**
 * Limpia el formulario de registro de administradores
 * @returns {undefined}
 */
function limpiar_admin(){
    $("#txtIdAdmin").val("");
    $("#txtIdAdmin").attr("disabled","disabled");
    $("#txtNombreAdmin").val("");
    $("#txtUserAdmin").val("");
    $("#txtPassAdmin").val("");
    $("#btnAdmin").attr("value","Guardar");
    $("#txtAccionAdmin").val("");
}

/**
 * Limpia el formulario de registro de categorias
 * @returns {undefined}
 */
function limpiar_cate(){
    $("#txtIdCate").val("");
    $("#txtNombreCate").val("");
    $("#txtDescribeCate").val("");
    $("#cbbSubCate").val(0);
    $("#btnCate").attr("value","Guardar");
    $("#txtAccionCate").val("");
}

/**
 * Limpia el formulario de registro de marcas
 * @returns {undefined}
 */
function limpiar_marca(){
    $("#txtIdMarca").val("");
    $("#txtMarca").val("");
}

/**
 * Guarda un nuevo administrador o edita uno ya existente
 * @returns {undefined}
 */
function guardar_admin()
{
    //Definimos las variables
    var id = $("#txtIdAdmin").val();
    var name = $("#txtNombreAdmin").val();
    var nick = $("#txtUserAdmin").val();
    var pass = $("#txtPassAdmin").val();
    var accion = $("#txtAccionAdmin").val();
    //Guardar
    if(id == ""){
        accion = "guardarAdmin";
        if(name != "" && nick != "" && pass != ""){
            $.ajax({
                type: "POST",
                url: "./control.php",
                data:{action:accion, nombre:name, usuario:nick, password:pass},
                success: function(data) {
                   alert(data);
                   listar_administradores();
                   limpiar_admin();
                }
            });
        }else{
            alert("Verifique los datos introducidos");
        }
    }else{//Editar
        accion = "editarAdmin";
        if(name != "" && nick != "" && pass != ""){
            $.ajax({
                type: "POST",
                url: "./control.php",
                data:{action:accion, nombre:name, usuario:nick, password:pass, ida:id},
                success: function(data) {
                   alert(data);
                   listar_administradores();
                   limpiar_admin();
                }
            });
        }else{
             alert("Verifique los datos que desea actualizar");
        }
    }
}

function guardar_categoria()
{
    //Definimos las variables
    var id = $("#txtIdCate").val();
    var name = $("#txtNombreCate").val();
    var desc = $("#txtDescribeCate").val();
    var sub = $("#cbbSubCate").val();
    var accion = $("#txtAccionCate").val();
    //Guardar
   
    if(id == ""){
        accion = "guardarCate";
        if(name != "" && desc != "" ){
            $.ajax({
                type: "POST",
                url: "./control.php",
                data:{action:accion, categoria:name, descripcion:desc, subestudio:sub},
                success: function(data) {
                   alert(data);
                   listar_categorias();
                   limpiar_cate();
                }
            });
        }else{
            alert("Verifique los datos introducidos");
        }
    }else{//Editar
        accion = "editarCate";
        if(name != "" && desc != "" ){
            $.ajax({
                type: "POST",
                url: "./control.php",
                data:{action:accion, categoria:name, descripcion:desc, subestudio:sub, ida:id},
                success: function(data) {
                   alert(data);
                   listar_categorias();
                   limpiar_cate();
                }
            });
        }else{
             alert("Verifique los datos que desea actualizar");
        }
    }
}

function guardar_marca(){
    //Definimos las variables
    var id = $("#txtIdMarca").val();
    var name = $("#txtMarca").val();
    var accion = "guardarMarca";
    //Guardar
    if(id == ""){
        if(name != ""){
            $.ajax({
                type: "POST",
                url: "./control.php",
                data:{action:accion, marca:name},
                success: function(data) {
                   alert(data);
                   listar_marcas();
                   limpiar_marca();
                }
            });
        }else{
            alert("Verifique los datos introducidos");
        }
    }else{
        accion = "editarMarca";
        if(name != ""){
            $.ajax({
                type: "POST",
                url: "./control.php",
                data:{action:accion, idm:id, marca:name},
                success: function(data) {
                   alert(data);
                   listar_marcas();
                   limpiar_marca();
                }
            });
        }else{
            alert("Debe ingresar el nombre de la marca");
        }
    }
}

function guardar_articulo()
{
    $("#formArticulo").attr("action", "./control.php");
    $("#action").val('subirImagenArticulo')
    $("#formArticulo").submit();
}

/**
 * Elimina un administrador de la base de datos
 * @param {integer} id
 * @returns {Boolean}
 */
function eliminar_admin(id){
    if(confirm("Realmente desea eliminar este registro?")){
        $.ajax({
            type: "POST",
            url: "./control.php",
            data:{action:"eliminarAdmin", ida:id},
            success: function(data) {
                alert(data);
                listar_administradores();
            }
        });
    }else{
        return false;
    }
}

/**
 * Elimina una categoria de la base de datos
 * @param {integer} id
 * @returns {Boolean}
 */
function eliminar_cate(id){
    if(confirm("Realmente desea eliminar este registro?")){
        $.ajax({
            type: "POST",
            url: "./control.php",
            data:{action:"eliminarCate", ida:id},
            success: function(data) {
                alert(data);
                listar_categorias();
            }
        });
    }else{
        return false;
    }
}

/**
 * Elimina una categoria de la base de datos
 * @param {integer} id
 * @returns {Boolean}
 */
function eliminar_marca(id){
    if(confirm("Realmente desea eliminar este registro?")){
        $.ajax({
            type: "POST",
            url: "./control.php",
            data:{action:"eliminarMarca", idm:id},
            success: function(data) {
                alert(data);
                listar_marcas();
            }
        });
    }else{
        return false;
    }
}


function llenar_combo_subcategoria(id){
    $.ajax({
        type: "POST",
        url: "./control.php",
        data:{action:"getComboSubcategorias", idc:id},
        success: function(data) {
            $('#combo_subcategoria').html(data);
        }
    });
}
 

function subir(){

var button = $('#btnUpload'), interval;
    alert(button);
    return;
    new AjaxUpload('#btnUpload', {
        action: './control.php?action="subirImagenArticulo"',
        onSubmit : function(file , ext){
        if (! (ext && /^(jpg|png)$/.test(ext))){
            // extensiones permitidas
            alert('Error: Solo se permiten imagenes');
            // cancela upload
            return false;
        } else {
                       //Cambio el texto del boton y lo deshabilito
            //button.text('Uploading');
            this.disable();
        }
        },
        onComplete: function(file, response){
            //button.text('Upload');
            // habilito upload button 
            this.enable();          
            // Agrega archivo a la lista
            alert("Subido");
            //document.getElementById('img').value=file;
        }   
    });


}