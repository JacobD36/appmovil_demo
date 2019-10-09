<?php
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $info = new usuario_model();
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-industry home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Consulta Empresas</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Prospección Empresas</h3>
                    <p></p>
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="ruc"><h5>RUC</h5></label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="tel" id="ruc" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
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
        var ruc = $("#ruc").val();

        if(ruc!=""){
            if(ruc.length==11){
                $.ajax({
                    type: "post",
                    url: "controlador/res_ruc.php",
                    data: {
                        ruc: ruc
                    },
                    success: function(datos) {
                        $("#contenido_principal").html(datos);
                    }
                });
            } else {
                swal("¡Error! Por favor, ingrese un número de RUC válido.", { icon: "error", });
            }
        } else {
            swal("¡Error! Por favor, ingrese un número de RUC válido.", { icon: "error", });
        }
    });
</script>