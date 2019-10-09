<?php
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    date_default_timezone_set("America/Lima");
    $fecha = date("Y-m-d");
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-check home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/consulta_cliente.php');"><h5>Consulta</h5></a>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Registro</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <input type="hidden" id="codusuario" name="codusuario" value="<?php echo $_SESSION['usuario'];?>">
                    <h3 class="header smaller lighter green">Registro de Campañas <?php echo $fecha;?></h3>
                    <p></p>
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
       muestra_lista2();
    });

    function muestra_lista2(){
        var columns = [
            { "title":"#","width": "10%" },
            { "title":"DNI","width": "40%" },
            { "title":"FECHA","width": "50%" }
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
            "ajax": "controlador/get_lista2.php?cod="+$("#codusuario").val(),
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
                        return data;
                    }
                }
            ],
        });
        $("th").css("background-color", "#4c88bb");
        $("th").css("color", "white");
    }
</script>