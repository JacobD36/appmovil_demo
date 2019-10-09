<?php
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $id = $_GET['id'];
    $opc = $_GET['opc'];
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-key home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <?php if($opc==1){?>
            <li>
                <a href="javascript:void(0)" onclick="carga_contenido('./vista/perfil.php');"><h5>Perfil</h5></a>
            </li>
        <?php } ?>
        <?php if($opc==2){?>
            <li>
                <a href="javascript:void(0)" onclick="carga_contenido('./vista/usuarios.php');"><h5>Usuarios</h5></a>
            </li>
        <?php } ?>
        <li class="active">
            <a href="javascript:void(0)"><h5>Cambiar Contraseña</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Cambio de Contraseña</h3>
                    <p></p>
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="password1"> Contraseña </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="password" id="password1" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="password2"> Repetir Contraseña </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="password" id="password2" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                <a href="javascript:void(0)" id="guardar" class="btn btn-primary btn-lg">
                                    <i class="ace-icon fa fa-save bigger-120"></i>
                                    Guardar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#guardar").on('click',function(){
        var pass1 = $("#password1").val();
        var pass2 = $("#password2").val();
        var id = $("#id").val();

        if(pass1!="" && pass2!=""){
            if(pass1==pass2){
                $.ajax({
                    type: "post",
                    url: "controlador/actualiza_password.php",
                    data: {
                        pass1: pass1,
                        pass2: pass2,
                        id: id
                    },
                    success: function(datos) {
                        swal("¡Operación exitosa! Se actualizó su contraseña", {icon: "success",});
                        carga_contenido('./vista/principal.php');
                    }
                });
            } else {
                swal("¡Error! Las contraseñas no coinciden.", { icon: "error", });
            }
        } else {
            swal("¡Error! Por favor, ingrese la información solicitada.", { icon: "error", });
        }
    });
</script>