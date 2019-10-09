<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: index.php');
    }
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-home home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Prospección Clientes</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">Prospección Clientes</h3>
                    <p></p>
                    <?php if($_SESSION['perfil']==1){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/usuarios.php');" class="btn btn-app btn-primary radius-4">
                        <i class="ace-icon fa fa-users bigger-230"></i>
                        Usuarios
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/perfil.php');" class="btn btn-grey btn-app radius-4">
                        <i class="ace-icon fa fa-user bigger-230"></i>
                        Perfil
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2 || ($_SESSION['perfil']==3 && $_SESSION["equipo"]!="3_PRESTAMO" && $_SESSION["equipo"]!="4_VEHICULAR")){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/consulta_cliente.php');" class="btn btn-app btn-success radius-4">
                        <i class="ace-icon fa fa-search bigger-230"></i>
                        Consulta
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2 || ($_SESSION['perfil']==3 && $_SESSION["equipo"]!="3_PRESTAMO" && $_SESSION["equipo"]!="4_VEHICULAR")){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/reporte.php');" class="btn btn-app btn-purple radius-4">
                        <i class="ace-icon fa fa-book bigger-230"></i>
                        Reporte
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/abordamiento.php');" class="btn btn-app btn-primary radius-4">
                        <i class="ace-icon fa fa-book bigger-230"></i>
                        Abordamiento
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2 || ($_SESSION['perfil']==3 && $_SESSION["equipo"]=="3_PRESTAMO") || ($_SESSION["perfil"]==3 && $_SESSION["equipo"]=="4_VEHICULAR")){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/payroll.php');" class="btn btn-app btn-grey radius-4">
                        <i class="ace-icon fa fa-money bigger-230"></i>
                        PayRoll
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || $_SESSION['equipo']=="3_PRESTAMO" || $_SESSION["equipo"]=="4_VEHICULAR"){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/feedback.php');" class="btn btn-app btn-warning radius-4">
                        <i class="ace-icon fa fa-mail-reply-all bigger-230"></i>
                        Feedback
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || ($_SESSION['perfil']==2 && $_SESSION['equipo']!="3_PRESTAMO") || ($_SESSION['perfil']==3 && $_SESSION['equipo']!="3_PRESTAMO" && $_SESSION['equipo']!="4_VEHICULAR")){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/registro.php')" class="btn btn-danger btn-app radius-4">
                        <i class="ace-icon fa fa-pencil-square-o bigger-230"></i>
                        Registro
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || ($_SESSION['perfil']==2 && $_SESSION['equipo']!="3_PRESTAMO" && $_SESSION['equipo']!="4_VEHICULAR")){?>
                    <a href="javascript:void(0)"  onclick="carga_contenido('./vista/vendedores.php')" class="btn btn-app btn-warning radius-4">
                        <i class="ace-icon fa fa-briefcase bigger-230"></i>
                        Vendedores
                    </a>
                    <?php }?>
                    <?php if($_SESSION['perfil']==1 || $_SESSION['perfil']==2){?>
                    <a href="javascript:void(0)" onclick="carga_contenido('./vista/geoposicion.php')" class="btn btn-app btn-success radius-4">
                        <i class="ace-icon fa fa-compass bigger-230"></i>
                        Localización
                    </a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>