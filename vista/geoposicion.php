<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $info = new usuario_model();
    $usuarios = $info->get_all_personas();
    $fecha_actual = date('Y-m-d');
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-compass home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Historial</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Sucesos</h3>
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
                        <div class="form-group">
                            <label class="col-sm-3 col-md-3 col-xs-12 control-label no-padding-right" for="usuario"><h5>Usuario</h5></label>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <select class="col-sm-9 col-xs-12 form-control input-lg" id="usuario">
                                    <option value="">SELECCIONE UNA OPCIÓN</option>
                                    <?php foreach($usuarios as $lista){
                                            if($lista['estado']==1){
                                    ?>
                                        <option value="<?php echo $lista['id']?>" <?php if($lista['id']==$_SESSION['id']){echo "selected";}?>><?php echo $lista['nombre'].' '.$lista['apellido1'].' '.$lista['apellido2'];?></option>
                                    <?php }
                                    }
                                    ?>
                                </select>
                            </div>
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
        var f1 = $("#fech_ini").val();
        var f2 = $("#fech_fin").val();
        var user = $("#usuario").val();
        muestra_geo_registro(user,f1,f2);
    });

    $("#buscar").on('click',function(){
        var f1 = $("#fech_ini").val();
        var f2 = $("#fech_fin").val();
        var user = $("#usuario").val();
        muestra_geo_registro(user,f1,f2);
    });

    function muestra_geo_registro(user,f1,f2){
        var columns = [
            { "title":"ID","width": "10%" },
            { "title":"USUARIO","width": "30%" },
            { "title":"EVENTO","width": "20%" },
            { "title":"FECHA","width": "20%" },
            { "title":"HORA","width": "20%" }
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
            "ajax": "controlador/get_geo_data.php?usr="+user+"&f1="+f1+"&f2="+f2,
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
                { responsivePriority: 1, targets: 1 },
                { responsivePriority: 2, targets: 2 },
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
                        if(data==1){
                            return '<center><span class="label label-success">LogIn</span></center>';
                        } else {
                            if (data==2) {
                                return '<center><span class="label label-danger">LogOut</span></center>';
                            } else {
                                return '';
                            }
                        }
                    }
                },
                {
                    "targets": [3],
                    "render": function(data, type, full) {
                       return data;
                    }
                },
                {
                    "targets": [4],
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