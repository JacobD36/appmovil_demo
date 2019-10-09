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

    $hipotecario="";
    $prestamo="";
    $prestamo2="";
    $barrac="";

    $documento=$_POST["dni"];
    $conn = database::conexion_1();
    $usuario=strtoupper($_SESSION["usuario"]);

    $Estrategia_LD="";
    $Estrategia_PA="";
    $Estrategia_PAPC="";
    $Estrategia_DXP="";
    $producto="";
    $linea="";
    $bandera1="0";
    $bandera2="0";
    $bandera3="0";

    $strsql3 = $conn->prepare("select
    NumeroDocumento,
    CONCAT(
    IF(IFNULL(TC_NOMBREBIN_VISA,'')='','','Visa'),IF(IF(IFNULL(TC_NOMBREBIN_MC,'')='','','Visa')<>'',', ',''),
    IF(IFNULL(TC_NOMBREBIN_MC,'')='','','MC'),IF(IF(IFNULL(TC_NOMBREBIN_AA,'')='','','Visa')<>'',', ',''),
    IF(IFNULL(TC_NOMBREBIN_AA,'')='','','Visa Advantage'),IF(IF(IFNULL(TC_NOMBREBIN_AA_MC,'')='','','Visa')<>'',', ',''),
    IF(IFNULL(TC_NOMBREBIN_AA_MC,'')='','','MC Advantage'),IF(IF(IFNULL(TC_NOMBREBIN_VISA_SMART,'')='','','Visa')<>'',', ',''),
    IF(IFNULL(TC_NOMBREBIN_VISA_SMART,'')='','','Visa Smart')
    ) AS PRODUCTO,
    IF(IFNULL(TC_LINEA_VISA,'')<>'',TC_LINEA_VISA,
    IF(IFNULL(TC_LINEA_MC,'')<>'',TC_LINEA_MC,
    IF(IFNULL(TC_LINEA_AA,'')<>'',TC_LINEA_AA,
    IF(IFNULL(TC_LINEA_AA_MC,'')<>'',TC_LINEA_AA_MC,
    IF(IFNULL(TC_LINEA_VISA_SMART,'')<>'',TC_LINEA_VISA_SMART,''))))) AS LINEA
    from bdmovil.wap where NumeroDocumento = '".$documento."' LIMIT 1;");
    $strsql3->execute();
    $rows3 = $strsql3->fetchAll();

    foreach ($rows3 as $row_1){
        $producto=$row_1["PRODUCTO"];
        $linea=$row_1["LINEA"];
        $bandera1="1";
    }

    $strsql4 = $conn->prepare("SELECT
    doc_identidad,
    Estrategia_LD,
    Estrategia_PA,
    Estrategia_PAPC,
    Estrategia_DXP
    FROM bdmovil.BDCOMPARTIDOCREDITOBase_MultiProducto WHERE doc_identidad = '".$documento."';");
    $strsql4->execute();
    $rows4 = $strsql4->fetchAll();

    foreach ($rows4 as $row_4){
        $Estrategia_LD=$row_4["Estrategia_LD"];
        $Estrategia_PA=$row_4["Estrategia_PA"];
        $Estrategia_PAPC=$row_4["Estrategia_PAPC"];
        $Estrategia_DXP=$row_4["Estrategia_DXP"];
        $bandera2="1";
    }

    $btn_Estrategia_LD="";
    if($Estrategia_LD == "Rojo")$btn_Estrategia_LD="<img src='./vista/img/rojo.png' width='35px'>";
    if($Estrategia_LD == "Amarillo")$btn_Estrategia_LD="<img src='./vista/img/amarillo.jpg' width='35px'>";
    if($Estrategia_LD == "Rosado")$btn_Estrategia_LD="<img src='./vista/img/rosado.png' width='35px'>";
    if($Estrategia_LD == "Verde Claro")$btn_Estrategia_LD="<img src='./vista/img/verde_claro.png' width='35px'>";
    if($Estrategia_LD == "Verde Oscuro")$btn_Estrategia_LD="<img src='./vista/img/verde_oscuro.png' width='35px'>";

    $btn_Estrategia_PA="";
    if($Estrategia_PA == "Rojo")$btn_Estrategia_PA="<img src='./vista/img/rojo.png' width='35px'>";
    if($Estrategia_PA == "Amarillo")$btn_Estrategia_PA="<img src='./vista/img/amarillo.jpg' width='35px'>";
    if($Estrategia_PA == "Rosado")$btn_Estrategia_PA="<img src='./vista/img/rosado.png' width='35px'>";
    if($Estrategia_PA == "Verde Claro")$btn_Estrategia_PA="<img src='./vista/img/verde_claro.png' width='35px'>";
    if($Estrategia_PA == "Verde Oscuro")$btn_Estrategia_PA="<img src='./vista/img/verde_oscuro.png' width='35px'>";

    $btn_Estrategia_PAPC="";
    if($Estrategia_PAPC == "Rojo")$btn_Estrategia_PAPC="<img src='./vista/img/rojo.png' width='35px'>";
    if($Estrategia_PAPC == "Amarillo")$btn_Estrategia_PAPC="<img src='./vista/img/amarillo.jpg' width='35px'>";
    if($Estrategia_PAPC == "Rosado")$btn_Estrategia_PAPC="<img src='./vista/img/rosado.png' width='35px'>";
    if($Estrategia_PAPC == "Verde Claro")$btn_Estrategia_PAPC="<img src='./vista/img/verde_claro.png' width='35px'>";
    if($Estrategia_PAPC == "Verde Oscuro")$btn_Estrategia_PAPC="<img src='./vista/img/verde_oscuro.png' width='35px'>";

    $btn_Estrategia_DXP="";
    if($Estrategia_DXP == "Rojo")$btn_Estrategia_DXP="<img src='./vista/img/rojo.png' width='35px'>";
    if($Estrategia_DXP == "Amarillo")$btn_Estrategia_DXP="<img src='./vista/img/amarillo.jpg' width='35px'>";
    if($Estrategia_DXP == "Rosado")$btn_Estrategia_DXP="<img src='./vista/img/rosado.png' width='35px'>";
    if($Estrategia_DXP == "Verde Claro")$btn_Estrategia_DXP="<img src='./vista/img/verde_claro.png' width='35px'>";
    if($Estrategia_DXP == "Verde Oscuro")$btn_Estrategia_DXP="<img src='./vista/img/verde_oscuro.png' width='35px'>";

    $clasificacion="";
    $strsql5 = $conn->prepare("select
    NumeroDocumento,Clasificacion from 
    bdmovil.RCC_Clasf_201801 where NumeroDocumento = '".$documento."' LIMIT 1;");
    $strsql5->execute();
    $rows5 = $strsql5->fetchAll();

    foreach ($rows5 as $row_5){
        $clasificacion=$row_5["Clasificacion"];
        $bandera3="1";
    }

    $clasi_1="";
    if($clasificacion == "AMARILLO") $clasi_1 ="<img src='./vista/img/amarillo.jpg' width='35px'>";
    if($clasificacion == "NARANJA") $clasi_1 ="<img src='./vista/img/naranja.png' width='35px'>";
    if($clasificacion == "VERDE") $clasi_1 ="<img src='./vista/img/verde_oscuro.png' width='35px'>";
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-search home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/lista1.php');"><h5>Registro</h5></a>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Detalle Registro</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="header smaller lighter green">DNI - <?php echo $documento;?></h3>
                    <p></p>
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="campanas"><h5>Campañas</h5></label>
                            <div class="col-sm-9 col-xs-12">
                                <input type="text" id="campanas" class="col-xs-12 col-sm-6 input-lg" value="<?php if($bandera1=='0'){echo 'NO';}else{echo 'SI';}?>" readonly style="background-color:white !important;" />
                            </div>
                        </div>
                        <?php if($bandera1=="1"){?>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-12 control-label no-padding-right" for="tc"><h5>TC</h5></label>
                                <div class="col-sm-9 col-xs-12">
                                    <input type="text" id="tc" class="col-xs-12 col-sm-6 input-lg" value="<?php echo '$'.$linea.' '.$producto;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                        <?php }?>
                        <?php if($bandera3=="1"){?>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-6 control-label no-padding-right" for="calificacion"><h5>Calificación</h5></label>
                                <div class="col-sm-9 col-xs-6">
                                    <p><?php echo $clasi_1;?></p>
                                </div>
                            </div>
                        <?php }?>
                        <?php if($bandera2=="1" && $bandera1=="0"){?>
                            <div class="form-group">
                                <label class="col-sm-12 col-xs-12 control-label no-padding-right" for="pre_calificacion"><h5>Precalificación</h5></label>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-6 control-label no-padding-right" for="dxp"><h5>DxP</h5></label>
                                <div class="col-sm-9 col-xs-6">
                                    <p><?php echo $btn_Estrategia_DXP." PC";?></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-6 control-label no-padding-right" for="pa"><h5>PA</h5></label>
                                <div class="col-sm-9 col-xs-6">
                                    <p><?php echo $btn_Estrategia_PA." LP";?></p>
                                </div>
                            </div>
                        <?php }?>
                        <?php if($bandera2=="0" && $bandera1=="0"){?>
                            <div class="form-group">
                                <label class="col-sm-3 col-xs-6 control-label no-padding-right" for="pre_calificacion_2"><h5>Precalificación</h5></label>
                                <div class="col-sm-9 col-xs-6">
                                    <p><img src='./vista/img/negro.gif' width='35px' height='35px'></p>
                                </div>
                            </div>
                        <?php }?>
                        <?php if($bandera1=="125"){?>
                            <div class="form-group" id="sel_cboresultado">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="cboresultado"><h5>Resultado</h5></label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <select class="col-sm-9 col-xs-12 form-control input-lg" id="cboresultado">
                                        <option value="VENTA">VENTA</option>
                                        <option value="SEGUIMIENTO">SEGUIMIENTO</option>
                                        <option value="NO DESEA">NO DESEA</option>
                                    </select>
                                </div>
                            </div>
                        <?php }?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>