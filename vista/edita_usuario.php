<?php
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }    
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $id = $_GET['id'];
    $info = new usuario_model();
    $persona = $info->get_edit_persona($id);
    $perfiles = $info->get_perfiles();
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-user home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/usuarios.php');"><h5>Usuarios</h5></a>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Edita Usuario</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Editar Información de Usuario</h3>
                    <p></p>
                    <form class="form-horizontal" role="form">
                        <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="codigo"> Código </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="codigo" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['tCodigo']);?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_nombre1">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="nombre1"> Primer Nombre </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="nombre1" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['nombre1']);?>" onkeyup="this.value = this.value.toUpperCase();"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_nombre2">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="nombre2"> Segundo Nombre </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="nombre2" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['nombre2']);?>" onkeyup="this.value = this.value.toUpperCase();"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_apellido1">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="apellido1"> Primer Apellido </label>
                            <div class="col-sm-9 col-xs-12">
                            <input type="text" id="apellido1" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['apellido1']);?>" onkeyup="this.value = this.value.toUpperCase();"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_apellido2">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="apellido2"> Segundo Apellido </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="apellido2" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['apellido2']);?>" onkeyup="this.value = this.value.toUpperCase();"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="correo"> Correo </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="correo" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['tCorreo']);?>"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_dni">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="dni"> DNI </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="tel" id="dni" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['tDni'])?>">
                            </div>
                        </div>
                        <div class="form-group" id="sel_cex">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="cex"> CEX </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="cex" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['tCex']);?>"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="usuario"> Login </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="usuario" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['codusuario']);?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="usuario"> Contraseña </label>
                            <div class="col-sm-9 col-xs-12">
                                <a href="javascript:void(0)" onclick="carga_contenido('./vista/cambiar_password.php?id='+$('#id').val()+'&opc=2');" class="btn btn-white btn-info btn-bold btn-lg">
                                    <i class="ace-icon fa fa-edit bigger-120"></i>
                                    Cambiar
                                </a>
                            </div>
                        </div>
                        <div class="form-group" id="sel_equipo">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="equipo"> Equipo </label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <select class="form-control input-lg" id="equipo">
                                    <option value="">SELECCIONE UNA CATEGORIA</option>
                                    <option value="BAY" <?php if($persona[0]['cod_equipo']=="BAY"){echo "selected";}?>> BAY</option>
                                    <option value="3WS - HIP &amp; VEH (JN)" <?php if($persona[0]['cod_equipo']=="3WS - HIP &amp; VEH (JN)"){echo "selected";}?>>3WS - HIP &amp; VEH (JN)</option>
                                    <option value="BURO - HIP &amp; VEH (JN)" <?php if($persona[0]['cod_equipo']=="BURO - HIP &amp; VEH (JN)"){echo "selected";}?>>BURO - HIP &amp; VEH (JN)</option>
                                    <option value="BURO - PP LIMA (MU)" <?php if($persona[0]['cod_equipo']=="BURO - PP LIMA (MU)"){echo "selected";}?>>BURO - PP LIMA (MU)</option>
                                    <option value="BURO - PP PROV (JR)" <?php if($persona[0]['cod_equipo']=="BURO - PP PROV (JR)")?>>BURO - PP PROV (JR)</option>
                                    <option value="GSS - PAYROLL (SL)" <?php if($persona[0]['cod_equipo']=="GSS - PAYROLL (SL)"){echo "selected";}?>>GSS - PAYROLL (SL)</option>
                                    <option value="INTERNOS - HIP &amp; VEH (JN)" <?php if($persona[0]['cod_equipo']=="INTERNOS - HIP &amp; VEH (JN)"){echo "selected";}?>>INTERNOS - HIP &amp; VEH (JN)</option>
                                    <option value="INTERNOS - PAYROLL (SL)" <?php if($persona[0]['cod_equipo']=="INTERNOS - PAYROLL (SL)"){echo "selected";}?>>INTERNOS - PAYROLL (SL)</option>
                                    <option value="INTERNOS - PP LIMA (MU)" <?php if($persona[0]['cod_equipo']=="INTERNOS - PP LIMA (MU)"){echo "selected";}?>>INTERNOS - PP LIMA (MU)</option>
                                    <option value="MF - HIP &amp; VEH (JN)" <?php if($persona[0]['cod_equipo']=="MF - HIP &amp; VEH (JN)"){echo "selected";}?>>MF - HIP &amp; VEH (JN)</option>
                                    <option value="MF - PAYROLL (SL)" <?php if($persona[0]['cod_equipo']=="MF - PAYROLL (SL)"){echo "selected";}?>>MF - PAYROLL (SL)</option>
                                    <option value="MF - PP LIMA (MU)" <?php if($persona[0]['cod_equipo']=="MF - PP LIMA (MU)"){echo "selected";}?>>MF - PP LIMA (MU)</option>
                                    <option value="MF - PP PROV (JR)" <?php if($persona[0]['cod_equipo']=="MF - PP PROV (JR)"){echo "selected";}?>>MF - PP PROV (JR)</option>
                                    <option value="ODISEC - PP PROV (JR)" <?php if($persona[0]['cod_equipo']=="ODISEC - PP PROV (JR)"){echo "selected";}?>>ODISEC - PP PROV (JR)</option>
                                    <option value="SEF - PP LIMA (MU)" <?php if($persona[0]['cod_equipo']=="SEF - PP LIMA (MU)"){echo "selected";}?>>SEF - PP LIMA (MU)</option>
                                    <option value="SEF - PP PROV (JR)" <?php if($persona[0]['cod_equipo']=="SEF - PP PROV (JR)"){echo "selected";}?>>SEF - PP PROV (JR)</option>
                                    <option value="TCONTAKTO - PAYROLL (SL)" <?php if($persona[0]['cod_equipo']=="TCONTAKTO - PAYROLL (SL)"){echo "selected";}?>>TCONTAKTO - PAYROLL (SL)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="sel_nivel">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="nivel"> Nivel </label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <select class="form-control input-lg" id="nivel">
                                    <option value="">SELECCIONE UNA CATEGORIA</option>
                                    <?php foreach($perfiles as $lista){?>
                                        <option value="<?php echo $lista['id']?>" <?php if($persona[0]['idperfil']==$lista['id']){echo "selected";}?>><?php echo utf8_encode($lista['descripcion']);?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="sel_ver_reporte">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="minimal" id="chk_ver_reporte" name="chk_ver_reporte" value="1" <?php if($persona[0]['nReporte']==1){echo "checked";}?>> Ver Reporte
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="sel_estado_l">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="minimal" id="chk_est_logueo" name="chk_est_logueo" value="1" <?php if($persona[0]['estado']==1){echo "checked";}?>> Estado Logueo
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="sel_estado">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="minimal" id="chk_est" name="chk_est" value="1" <?php if($persona[0]['aEstado']==1){echo "checked";}?>> Estado
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="fecha"> Fecha </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="fecha" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $persona[0]['fFecha'];?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="usr_login"> Usuario </label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="usr_login" class="col-xs-12 col-sm-6 input-lg" value="<?php echo utf8_encode($persona[0]['codusuario']);?>" readonly style="background-color:white !important;"/>
                            </div>
                        </div>
                        <p>&nbsp;</p>
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
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });

    $("#guardar").on('click',function(){
        var id = $("#id").val();
        var nombre1 = $("#nombre1").val();
        var nombre2 = $("#nombre2").val();
        var apellido1 = $("#apellido1").val();
        var apellido2 = $("#apellido2").val();
        var correo = $("#correo").val();
        var dni = $("#dni").val();
        var cex = $("#cex").val();
        var equipo = $("#equipo").val();
        var nivel = $("#nivel").val();
        var estado_l = 0;
        var estado = 0;
        var nReporte = 0;

        if(document.getElementById("chk_ver_reporte").checked==true){
            nReporte = $("#chk_ver_reporte").val();
        }
        if(document.getElementById("chk_est_logueo").checked==true) {
            estado_l = $("#chk_est_logueo:checked").val();
        }
        if(document.getElementById("chk_est").checked==true){
            estado = $("#chk_est:checked").val();
        }

        if(nombre1!="" && apellido1!="" && apellido2!="" && dni!="" && cex!="" && equipo!="" && nivel!=""){
            if(dni.length==8){
                $.ajax({
                    type: "post",
                    url: "controlador/actualiza_persona.php",
                    data: {
                        id: id,
                        nombre1: nombre1,
                        nombre2: nombre2,
                        apellido1: apellido1,
                        apellido2: apellido2,
                        correo: correo,
                        dni: dni,
                        cex: cex,
                        equipo: equipo,
                        nivel: nivel,
                        estado_l: estado_l,
                        nReporte: nReporte,
                        estado: estado
                    },
                    success: function(datos) {
                        swal("¡Operación exitosa! Se actualizó la información personal de "+nombre1+" "+apellido1, {icon: "success",});
                        carga_contenido('./vista/usuarios.php');
                    }
                });
            } else {
                swal("¡Error! Por favor, ingrese un DNI válido.", { icon: "error", });
            }
        } else {
            if(nombre1==""){
                $("#sel_nombre1").addClass("has-error has-feedback");
                swal("¡Error! Por favor, ingrese el primer nombre de la persona.", { icon: "error", });
            } else {
                $("#sel_nombre1").removeClass("has-error has-feedback");
                if(apellido1==""){
                    $("#sel_apellido1").addClass("has-error has-feedback");
                    swal("¡Error! Por favor, ingrese el primer apellido de la persona.", { icon: "error", });
                } else {
                    $("#sel_apellido1").removeClass("has-error has-feedback");
                    if(apellido2==""){
                        $("#sel_apellido2").addClass("has-error has-feedback");
                        swal("¡Error! Por favor, ingrese el segundo apellido de la persona.", { icon: "error", });
                    } else {
                        $("#sel_apellido2").removeClass("has-error has-feedback");
                        if(dni==""){
                            $("#sel_dni").addClass("has-error has-feedback");
                            swal("¡Error! Por favor, ingrese el DNI de la persona.", { icon: "error", });
                        } else {
                            $("#sel_dni").removeClass("has-error has-feedback");
                            if(cex==""){
                                $("#sel_cex").addClass("has-error has-feedback");
                                swal("¡Error! Por favor, complete el campo CEX.", { icon: "error", });
                            } else {
                                $("#sel_cex").removeClass("has-error has-feedback");
                                if(equipo==""){
                                    $("#sel_equipo").addClass("has-error has-feedback");
                                    swal("¡Error! Por favor, seleccione un valor para equipo.", { icon: "error", });
                                } else {
                                    $("#sel_equipo").removeClass("has-error has-feedback");
                                    if(nivel==""){
                                        $("#sel_nivel").addClass("has-error has-feedback");
                                        swal("¡Error! Por favor, seleccione un valor para nivel.", { icon: "error", });
                                    } else {
                                        $("#sel_nivel").removeClass("has-error has-feedback");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    });
</script>