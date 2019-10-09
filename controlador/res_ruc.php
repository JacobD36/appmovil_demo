<?php
    session_start();
    require_once("../configuracion/database.php");
    if (!isset($_SESSION['usuario'])) {
    ?>
    <script>
        location.assign("../index.php");
    </script>
    <?php
    }

    //Código heredado
    $hipotecario="";

    $prestamo="";
    $prestamo2="";
    $barrac="";

    $documento=$_POST["ruc"];
    $conn = database::conexion_1();
    $usuario=$_SESSION["usuario"];

    $Estrategia_LD="";
    $Estrategia_PA="";
    $Estrategia_PAPC="";
    $Estrategia_DXP="";
    $producto="";
    $linea="";
    $bandera1="0";
    $bandera2="0";
    $bandera3="0";
    $CLAS5_3="NO";

    $strsql3 = $conn->prepare("SELECT ruc_empleador,grupo_empresa FROM bdmovil.tb_empresas where ruc_empleador = '".$documento."' LIMIT 1;");
    $strsql3->execute();
    $rows3 = $strsql3->fetchAll();

    foreach ($rows3 as $row_1){
        $ruc=$row_1["ruc_empleador"];
        $grupo=$row_1["grupo_empresa"];
        $bandera1="1";
    }
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-industry home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/consulta_ruc.php');"><h5>Consulta</h5></a>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Consulta RUC</h5>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">RUC - <?php echo $documento;?></h3>
                    <p></p>
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="convenio"><h5>Grupo</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="convenio" class="col-xs-12 col-sm-6 input-lg" value="<?php if($bandera1=="1"){echo $grupo;}else{echo "SIN GRUPO";}?>" readonly style="background-color:white !important;" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>