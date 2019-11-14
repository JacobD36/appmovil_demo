<?php
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $info = new usuario_model();
    $perfiles = $info->get_perfiles();
    $tCodigo = $info->get_new_code();
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
            <a href="javascript:void(0)"><h5>Nuevo Usuario</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Nuevo Usuario</h3>
                    <p></p>
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="codigo"><h5>Código</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="codigo" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tCodigo;?>" readonly style="background-color:white !important;" />
                            </div>
                        </div>
                        <div class="form-group" id="sel_nombre1">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="nombre1"><h5>Primer Nombre</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="nombre1" class="col-xs-12 col-sm-6 input-lg" onkeyup="this.value = this.value.toUpperCase();"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_nombre2">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="nombre2"><h5>Segundo Nombre</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="nombre2" class="col-xs-12 col-sm-6 input-lg" onkeyup="this.value = this.value.toUpperCase();"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_apellido1">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="apellido1"><h5>Primer Apellido</h5></label>
                            <div class="col-sm-9 col-xs-12">
                            <input type="text" id="apellido1" class="col-xs-12 col-sm-6 input-lg" onkeyup="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <div class="form-group" id="sel_apellido2">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="apellido2"><h5>Segundo Apellido</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="apellido2" class="col-xs-12 col-sm-6 input-lg" onkeyup="this.value = this.value.toUpperCase();"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_correo">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="correo"><h5>Correo</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="correo" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_dni">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="dni"><h5>DNI</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="tel" id="dni" class="col-xs-12 col-sm-6 input-lg">
                            </div>
                        </div>
                        <div class="form-group" id="sel_cex">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="cex"><h5>CEX</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="cex" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_password1">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="password1"><h5>Contraseña</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="password" id="password1" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_password2">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="password2"><h5>Repetir Contraseña</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="password" id="password2" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
                        <div class="form-group" id="sel_equipo">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="equipo"><h5>Equipo</h5></label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <select class="col-sm-9 col-xs-12 form-control input-lg" id="equipo">
                                    <option value="">SELECCIONE UNA CATEGORIA</option>
                                    <option value="BAY"> BAY</option>
                                    <option value="3WS - HIP &amp; VEH (JN)">3WS - HIP &amp; VEH (JN)</option>
                                    <option value="BURO - HIP &amp; VEH (JN)">BURO - HIP &amp; VEH (JN)</option>
                                    <option value="BURO - PP LIMA (MU)">BURO - PP LIMA (MU)</option>
                                    <option value="BURO - PP PROV (JR)">BURO - PP PROV (JR)</option>
                                    <option value="GSS - PAYROLL (SL)">GSS - PAYROLL (SL)</option>
                                    <option value="INTERNOS - HIP &amp; VEH (JN)">INTERNOS - HIP &amp; VEH (JN)</option>
                                    <option value="INTERNOS - PAYROLL (SL)">INTERNOS - PAYROLL (SL)</option>
                                    <option value="INTERNOS - PP LIMA (MU)">INTERNOS - PP LIMA (MU)</option>
                                    <option value="MF - HIP &amp; VEH (JN)">MF - HIP &amp; VEH (JN)</option>
                                    <option value="MF - PAYROLL (SL)">MF - PAYROLL (SL)</option>
                                    <option value="MF - PP LIMA (MU)">MF - PP LIMA (MU)</option>
                                    <option value="MF - PP PROV (JR)">MF - PP PROV (JR)</option>
                                    <option value="ODISEC - PP PROV (JR)">ODISEC - PP PROV (JR)</option>
                                    <option value="SEF - PP LIMA (MU)">SEF - PP LIMA (MU)</option>
                                    <option value="SEF - PP PROV (JR)">SEF - PP PROV (JR)</option>
                                    <option value="TCONTAKTO - PAYROLL (SL)">TCONTAKTO - PAYROLL (SL)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="sel_nivel">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="nivel"><h5>Nivel</h5></label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <select class="col-sm-9 col-xs-12 form-control input-lg" id="nivel">
                                    <option value="">SELECCIONE UNA CATEGORIA</option>
                                    <?php foreach($perfiles as $lista){?>
                                        <option value="<?php echo $lista['id']?>"><?php echo utf8_encode($lista['descripcion']);?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="sel_turno" style="display:none;">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="minimal" id="chk_part_time" name="chk_part_time" value="1"> Part Time
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="minimal" id="chk_ver_reporte" name="chk_ver_reporte" value="1"> Ver Reporte
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="minimal" id="chk_est_logueo" name="chk_est_logueo" value="1"> Estado Logueo
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="minimal" id="chk_est" name="chk_est" value="1" checked> Estado
                                </label>
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

    $("#nivel").change(function(){
        var nivel = $("#nivel").val();
        if(nivel=='3'){
            $("#sel_turno").css("display","block");
        }else{
            $("#sel_turno").css("display","none");
        }
    });

    $("#guardar").on('click',function(){
        var codigo = $("#codigo").val();
        var nombre1 = $("#nombre1").val();
        var nombre2 = $("#nombre2").val();
        var apellido1 = $("#apellido1").val();
        var apellido2 = $("#apellido2").val();
        var correo = $("#correo").val();
        var dni = $("#dni").val();
        var cex = $("#cex").val();
        var password1 = $("#password1").val();
        var password2 = $("#password2").val();
        var equipo = $("#equipo").val();
        var nivel = $("#nivel").val();
        var estado_l = 0;
        var estado = 0;
        var nReporte = 0;
        var turno = 0;

        if(nivel=='3'){
            if(document.getElementById("chk_part_time").checked == true){
                turno = $("#chk_part_time").val();
            }else{
                turno = 0;
            }
        }else{
            turno = 0;
        }

        if(document.getElementById("chk_ver_reporte").checked == true){
            nReporte = $("#chk_ver_reporte").val();
        }
        if(document.getElementById("chk_est_logueo").checked == true){
            estado_l = $("#chk_est_logueo:checked").val();
        }
        if(document.getElementById("chk_est").checked == true){
            estado = $("#chk_est:checked").val();
        }

        if(nombre1!="" && apellido1!="" && apellido2!="" && dni!="" && cex!="" && password1!="" && password2!="" && equipo!="" && nivel!=""){
            if(dni.length==8){
                if(password1==password2){
                    $.ajax({
                        type: "post",
                        url: "controlador/genera_usuario.php",
                        data: {
                            codigo: codigo,
                            nombre1: nombre1,
                            nombre2: nombre2,
                            apellido1: apellido1,
                            apellido2: apellido2,
                            correo: correo,
                            dni: dni,
                            cex: cex,
                            password1: password1,
                            password2: password2,
                            equipo: equipo,
                            nivel: nivel,
                            estado_l: estado_l,
                            estado: estado,
                            nReporte: nReporte,
                            turno: turno
                        },
                        success: function(datos) {
                            if(datos!="existe"){
                                swal("¡Operación exitosa! Se generó el usuario: "+datos, {icon: "success",});
                                carga_contenido('./vista/usuarios.php');
                            }else {
                                swal("¡Error! El usuario ya existe .", { icon: "error", });
                            }
                        }
                    });
                } else {
                    swal("¡Error! Las contraseñas no coinciden.", { icon: "error", });
                }
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
                            swal("¡Error! Por favor, ingrese el dni de la persona.", { icon: "error", });
                        } else {
                            $("#sel_dni").removeClass("has-error has-feedback");
                            if(cex==""){
                                $("#sel_cex").addClass("has-error has-feedback");
                                swal("¡Error! Por favor, complete el campo CEX.", { icon: "error", });
                            } else {
                                $("#sel_cex").removeClass("has-error has-feedback");
                                if(password1==""){
                                    $("#sel_password1").addClass("has-error has-feedback");
                                    swal("¡Error! Por favor, ingrese una contraseña.", { icon: "error", });
                                } else {
                                    $("#sel_password1").removeClass("has-error has-feedback");
                                    if(password2==""){
                                        $("#sel_password2").addClass("has-error has-feedback");
                                        swal("¡Error! Por favor, repita la contraseña.", { icon: "error", });
                                    } else {
                                        $("#sel_password2").removeClass("has-error has-feedback");
                                        if(equipo==""){
                                            $("#sel_equipo").addClass("has-error has-feedback");
                                            swal("¡Error! Por favor, seleccione un equipo.", { icon: "error", });
                                        } else {
                                            $("#sel_equipo").removeClass("has-error has-feedback");
                                            if(nivel==""){
                                                $("#sel_nivel").addClass("has-error has-feedback");
                                                swal("¡Error! Por favor, seleccione un nivel.", { icon: "error", });
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
            }
        }
    });
</script>