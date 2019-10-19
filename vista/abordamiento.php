<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    date_default_timezone_set("America/Lima");
    $fecha_actual = date("Y-m-d");
    $data = new usuario_model();
    $res_values = $data->get_abord_values();
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-book home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Abordamiento</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Reporte de Abordamiento</h3>
                    <p></p>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label no-padding-right" for="fech_ini"><h5>Desde</h5></label>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <input type="date" id="fech_ini" class="form-control input-lg" value="<?php echo $fecha_actual;?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label no-padding-right" for="fech_fin"><h5>Hasta</h5></label>
                            <div class="col-sm-3 col-md-3 col-xs-12">
                                <input type="date" id="fech_fin" class="form-control input-lg" value="<?php echo $fecha_actual;?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group" id="sel_res">
                            <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="vendedor"><h5>Vendedor</h5></label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <select class="col-md-3 col-sm-3 col-xs-12 form-control input-lg" id="vendedor">
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                    <?php foreach($res_values as $lista){?>
                                        <option value="<?php echo strtoupper($lista['codusuario']);?>"><?php echo strtoupper($lista['codusuario']);?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                            <a href="javascript:void(0)" id="mostrar" class="btn btn-primary btn-lg">
                                <i class="ace-icon fa fa-save bigger-120"></i>
                                Mostrar
                            </a>
                        </div>
                    </div>
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <table class="table table-bordered table-striped table-hover display responsive nowrap" width="100%" cellspacing="0" id="my-table" >
                                    <thead>
                                        <tr role="row" class="col_heading"></tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        var tipo2 = '2';
        var f1 = $("#fech_ini").val();
        var f2 = $("#fech_fin").val();
        var vendedor = $("#vendedor").val();
        mostrar_registros(tipo2,f1,f2,vendedor);
    });

    $("#mostrar").on('click',function(){
        var tipo2 = '2';
        var f1 = $("#fech_ini").val();
        var f2 = $("#fech_fin").val();
        var vendedor = $("#vendedor").val();
        mostrar_registros(tipo2,f1,f2,vendedor);
    });

    function mostrar_registros(tipo2,f1,f2,vendedor){
        var columns = [
            { "title":"FECHA","width": "11%" },
            { "title":"ESTADO","width": "11%" },
            { "title":"USUARIO","width": "11%" },
            { "title":"DNI","width": "11%" }
        ];

        var table = $('#my-table').DataTable( {
            "processing": true,
            "lengthChange": true,
            "responsive" : true,
            "searching": true,
            "ordering": true,
            "order": [[ 0, "asc" ]],
            "info": true,
            "autoWidth": false,
            "destroy": true,
            "columns": columns,
            "ajax": "controlador/process_7.php?tipo="+tipo2+"&fecha1="+f1+"&fecha2="+f2+"&usuario="+vendedor,
            "deferRender": true,
            "paging": true,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "Sin registros",
                "sEmptyTable": "Tabla vacía",
                "sInfo": "_START_ a _END_ de _TOTAL_ reg",
                "sInfoEmpty": "0 a 0 de 0 REG",
                "sInfoFiltered": "(_MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "bInfo": true,
            "columnDefs": [
                {
                    "targets": [0],
                    "render": function(data, type, full) {
                        return data;
                    }
                },
                {
                    "targets": [1],
                    "render": function(data, type, full) {
                        return data;
                    }
                },
                {
                    "targets": [2],
                    "render": function(data, type, full) {
                        return data;
                    }
                },
                {
                    "targets": [3],
                    "render": function(data, type, full) {
                        return data;
                    }
                }
            ],
        });
        $("th").css("background-color", "#4c88bb");
        $("th").css("color", "white");
    }
</script>