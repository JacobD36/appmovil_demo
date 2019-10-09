<?php
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-mail-reply-all home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Feedback</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Detalle de Consultas</h3>
                    <p></p>
                    <form class="form-horizontal" role="form">
                        <div class="form-group" id="sel_tipo">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tipo"><h5>Tipo de Documento</h5></label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <select class="col-md-4 col-sm-4 col-xs-12 form-control input-lg" id="tipo">
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">RUC</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="sel_dni">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="dni"><h5>Número</h5> </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="tel" id="dni" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                <a href="javascript:void(0)" id="buscar" class="btn btn-primary btn-lg">
                                    <i class="ace-icon fa fa-search bigger-120"></i>
                                    Buscar
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
    $("#buscar").on('click',function(){
        var tipo = $("#tipo").val();
        var dni = $("#dni").val();
        var res = 0;

        console.log("Tamaño: "+dni.length);

        if(tipo!="" && dni!=""){
            if(tipo=="RUC"){
                if(dni.length!=11){res=1;}
            }
            if(tipo=="DNI"){
                if(dni.length!=8){res=1;}
            }
            
            if(res == 0){

            } else {
                swal("¡Error! Por favor, ingrese un número correcto.", { icon: "error", });
            }
        } else {
            if(tipo==""){
                $("#sel_tipo").addClass("has-error has-feedback");
                swal("¡Error! Por favor, seleccione un tipo de documento.", { icon: "error", });
            } else {
                $("#sel_tipo").removeClass("has-error has-feedback");
                if(dni==""){
                    $("#sel_dni").addClass("has-error has-feedback");
                    swal("¡Error! Por favor, ingrese el número de documento.", { icon: "error", });
                } else {
                    $("#sel_dni").removeClass("has-error has-feedback");
                }
            }
        }
    });
</script>