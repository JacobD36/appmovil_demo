<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-users home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Usuarios</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Usuarios</h3>
                    <p></p>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/nuevo_usuario.php');" id="nuevo" class="btn btn-primary btn-lg">
                                        <i class="ace-icon fa fa-user bigger-120"></i>
                                        Nuevo Usuario
                                    </a>
                                </div>
                            </div>
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
       mostrar_usuarios();
    });

    function muestra_mensaje(){
        alert("Ha presionado el botón editar");
    }

    function mostrar_usuarios(){
        var columns = [
            { "title":"CODIGO","width": "10%" },
            { "title":"NOMBRES","width": "20%" },
            { "title":"APELLIDO 1","width": "15%" },
            { "title":"APELLIDO 2","width": "15%" },
            { "title":"USUARIO","width": "10%" },
            { "title":"LOGIN","width": "5%" },
            { "title":"NIVEL","width": "5%" },
            { "title":"EQUIPO","width": "10%" },
            { "title":"ESTADO","width": "5%" },
            { "title":"OPCIONES","width": "5%" },
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
            "ajax": "controlador/get_all_users.php",
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
                { responsivePriority: 1, targets: 4 },
                { responsivePriority: 2, targets: 8 },
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
                },
                {
                    "targets": [4],
                    "render": function(data, type, full) {
                       return data;
                    }
                },
                {
                    "targets": [5],
                    "render": function(data, type, full) {
                       if(data==1){
                            return '<center><span class="label label-success">ACTIVO</span></center>';
                       } else {
                            return '<center><span class="label label-warning">INACTIVO</span></center>';
                       }
                    }
                },
                {
                    "targets": [6],
                    "render": function(data, type, full) {
                        return data;
                    }
                },
                {
                    "targets": [7],
                    "render": function(data, type, full) {
                        return data;
                    }
                },
                {
                    "targets": [8],
                    "render": function(data, type, full) {
                        if(data==1){
                            return "<center><span class='label label-success'>ACTIVO</span></center>";
                        } else {
                            return "<center><span class='label label-danger'>INACTIVO</span></center>";
                        }
                    }
                },
                {
                    "targets": [9],
                    "render": function(data, type, full) {
                        return '<center>'+data+'</center>';
                    }
                },
            ],
        });
        $("th").css("background-color", "#4c88bb");
        $("th").css("color", "white");
    }
</script>