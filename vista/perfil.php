<?php
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $user = new usuario_model();
    $persona = $user->get_personal_info($_SESSION['id']);
    $user_info = $user->get_user_info($_SESSION['id']);
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-users home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Perfil</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Perfil de Usuario</h3>
                    <p></p>
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="id" name="id" value="<?php echo $_SESSION['id'];?>">
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="nombre1"><h5>Primer Nombre</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="nombre1" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['nombre1']);?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="nombre2"><h5>Segundo Nombre</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="nombre2" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['nombre2']);?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="apellido1"><h5>Primer Apellido</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="apellido1" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['apellido1']);?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="apellido2"><h5>Segundo Apellido</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="apellido2" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['apellido2']);?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="dni"><h5>DNI</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="number" id="dni" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['dni']);?>" readonly style="background-color:white !important;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="usuario"><h5>Usuario</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="usuario" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $_SESSION['usuario'];?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="usuario"><h5>Contraseña</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <a href="javascript:void(0)" onclick="carga_contenido('./vista/cambiar_password.php?id='+$('#id').val()+'&opc=1');" class="btn btn-white btn-info btn-bold btn-lg">
                                    <i class="ace-icon fa fa-key bigger-120"></i>
                                    Cambiar
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="cex"><h5>CEX</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="cex" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $user_info[0]['tCex'];?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>