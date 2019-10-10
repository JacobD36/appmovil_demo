<?php
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $info = new usuario_model();
    $q_info = $info->get_rate_info($_SESSION['usuario']);
    $q_tbl_datos_info = $info->get_tbl_datos_info($_SESSION['usuario']);
    $combo_elem_1 = $info->get_combo_elem_1();
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-search home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Consulta Cliente</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Prospección de Clientes</h3>
                    <p></p>
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="javascript:void(0)" class="btn btn-lg btn-primary radius-4" onclick="carga_contenido('./vista/lista2.php');" style="float:right;margin:5px;">
                                <i class="ace-icon fa fa-check"></i>
                                <span class="badge"><?php echo $q_info[0]['Q2'];?></span>
                            </a>
                            <a href="javascript:void(0)" class="btn btn-lg btn-danger radius-4" onclick="carga_contenido('./vista/lista1.php');" style="float:right;margin:5px;">
                                <i class="ace-icon fa fa-search"></i>
                                <span class="badge"><?php echo $q_info[0]['Q1'];?></span>
                            </a>
                            <div id="q3_data">
                                <a href="javascript:void(0)" class="btn btn-lg btn-danger radius-4" style="float:right;margin:5px;">
                                    <i class="ace-icon fa fa-user"></i>
                                    <span class="badge"><?php echo $q_tbl_datos_info[0]['Q3'];?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                        <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="zona"><h5>ZONA</h5></label>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <select class="col-md-4 col-sm-4 col-xs-12 form-control input-lg" id="zona">
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                    <?php foreach($combo_elem_1 as $lista) {?>
                                        <option value="<?php echo $lista['id_zona']?>"><?php echo $lista['descripcion']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="dni"><h5>DNI</h5> </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <input type="tel" id="dni" class="col-xs-12 col-sm-6 input-lg"/>
                            </div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-6" style="text-align:center;">
                                <a href="javascript:void(0)" id="buscar" class="btn btn-primary btn-lg">
                                    <i class="ace-icon fa fa-search bigger-120"></i>
                                    Buscar
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6" style="text-align:center;">
                                <a href="javascript:void(0)" id="abordar" class="btn btn-danger btn-lg">
                                    <i class="ace-icon fa fa-user bigger-120"></i>
                                    Abordar
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
        var dni = $("#dni").val();
        var zona = $("#zona").val();

        if(dni!="" && zona!=""){
            $.ajax({
                type: "post",
                url: "controlador/res_consulta.php",
                data: {
                    dni: dni,
                    zona: zona
                },
                success: function(datos) {
                    $("#contenido_principal").html(datos);
                }
            });
        } else {
            swal("¡Error! Por favor, ingrese lo solicitado.", { icon: "error", });
        }
    });

    $("#abordar").on('click',function(){
        var zona = $("#zona").val();

        if(zona!=""){
            $.ajax({
                type: "post",
                url: "controlador/procesar_datos.php",
                data: {
                    zona: zona
                },
                success: function(datos) {
                    $("#q3_data").html(datos);
                }
            });
        } else {
            swal("¡Error! Por favor, seleccione una zona.", { icon: "error", });
        }
    });
</script>