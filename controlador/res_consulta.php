<?php
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    if (!isset($_SESSION['usuario'])) {
    ?>
    <script>
        location.assign("../index.php");
    </script>
    <?php
    }

    $data = new usuario_model();
    $ip = $data->getRealIP();
    $celu="";
    //Código heredado
    $hipotecario="";

    $prestamo="";
    $prestamo2="";
    $barrac="";
    
    $documento=$_POST["dni"];
    $conn = database::conexion_1();
    $usuario=$_SESSION["usuario"];
    $id_zona=$_POST["zona"];
    
    $id_zona=$_POST["zona"];
    $sqlinserta_zona = $conn->prepare("insert into bdmovil.tbl_historico_zona(usuario,id_zona,fec_reg) values ('".strtoupper($usuario)."','".$id_zona."',now());");
    $sqlinserta_zona->execute();
    
    $sqlinserta_datos = $conn->prepare("insert into bdmovil.tbl_datos(usuario,dni,estado,fec_reg,tZona) values ('".strtoupper($usuario)."','".$documento."','SI',now(),'".$id_zona."');");
    $sqlinserta_datos->execute();
    
    $color="";
    $strsql5 = $conn->prepare("select NumeroDocumento,Clasificacion from bdmovil.RCC_Clasf_201801 where NumeroDocumento  ='".$documento."';");
    $strsql5->execute();
    $rows5 = $strsql5->fetchAll();
    
    if( $rows5!=null ) {
        foreach ($rows5 as $row_c){
            $color=$row_c["Clasificacion"];
        }
    }
    
    $Estrategia_LD="";
    $Estrategia_PA="";
    $Estrategia_PAPC="";
    $Estrategia_DXP="";
    $bandera2="0";
    $bandera3="0";
    
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
    if($Estrategia_DXP == "Verde")$btn_Estrategia_DXP="<img src='./vista/img/verde_oscuro.png' width='35px'>";
    if($Estrategia_DXP == "Naranja")$btn_Estrategia_DXP="<img src='./vista/img/naranja.png' width='35px'>";
    
    $hipo1="";
    $bandera9='0';
    $hipotecario="";
    $score="";
    $strsql6 = $conn->prepare("select
    doc_identidad,score from 
    bdmovil.hipotecario_wap where doc_identidad = '".$documento."' LIMIT 1;");
    $strsql6->execute();
    $rows6 = $strsql6->fetchAll();
    
    foreach ($rows6 as $row_6){
        $hipotecario=$row_6["doc_identidad"];
        $score9=$row_6["score"];
        $bandera9='1';
        $hipo1="SI";
    }
    
    $hipo2="";
    $bandera10='0';
    $hipotecario10="";
    $score10="";
    $strsql10 = $conn->prepare("select
    doc_identidad,score from 
    bdmovil.hipotecario_wap_OK where doc_identidad = '".$documento."' LIMIT 1;");
    $strsql10->execute();
    $rows10 = $strsql10->fetchAll();
    
    $score10="";
    foreach ($rows10 as $row_10){
        $hipotecario10=$row_10["doc_identidad"];
        $score10=$row_10["score"];
        $bandera10='1';
        $hipo2="NO";
    }
    
    $CD12="";
    $MONTOCD12="";
    $TASACD12="";
    $bandera25='0';
    $strsql12 = $conn->prepare("select
    NUM_DOCUMENTO,MontoAprobadoCompraDeudaTCSoles,TEACD38AMAS from  bdmovil.BD_COMPLETA_CDATAQUE where NUM_DOCUMENTO = '".$documento."' LIMIT 1;");
    $strsql12->execute();
    $rows12 = $strsql12->fetchAll();
    
    foreach ($rows12 as $row_12){
        $CD12=$row_12["NUM_DOCUMENTO"];
        $MONTOCD12=$row_12["MontoAprobadoCompraDeudaTCSoles"];
        $TASACD12=$row_12["TEACD38AMAS"];
        $bandera25='1';
    }
    
    $strsql3 = $conn->prepare("SELECT NumeroDocumento,PrimerApellido,SegundoApellido,PrimerNombre,SegundoNombre,Campanha,Score,TC_NOMBREBIN_VISA,TC_LINEA_VISA,TC_TEA_VISA,
    TC_NOMBREBIN_MC,TC_LINEA_MC,TC_TEA_MC,
    TC_NOMBREBIN_AA,TC_LINEA_AA,TC_TEA_AA,TC_NOMBREBIN_AA_MC, TC_LINEA_AA_MC, TC_TEA_AA_MC,
    TC_NOMBREBIN_VISA_SMART,TC_LINEA_VISA_SMART,TC_TEA_VISA_SMART
    FROM bdmovil.wap WHERE NumeroDocumento  ='".$documento."' LIMIT 1;");
    $strsql3->execute();
    $rows3 = $strsql3->fetchAll();
    
    if ($rows3==null) {
        $sqlFer1 = $conn->prepare("select Id from bdmovil.consulta_dni where tDni ='".$documento."' and date(fFechaGrabacion) = date(now());");
        $sqlFer1->execute();
        $rowsFer1 = $sqlFer1->fetchAll();
    
        if ($rowsFer1==null) {
            $sqlinserta_cons = $conn->prepare("insert into bdmovil.consulta_dni(tIp,tDni,fFechaGrabacion,tUsuario,tCelular,tZona) values ('".$ip."','".$documento."',now(),'".strtoupper($usuario)."','".$celu."','".$id_zona."');");
            $sqlinserta_cons->execute();
            $stmt1 = $conn->prepare("select Id from bdmovil.consulta_dni where tDni='".$documento."' order by Id desc limit 1;");
            $stmt1->execute();
            $res_stmt1 = $stmt1->fetchAll();
            $id_generado = $res_stmt1[0]['Id'];
        } else {
            $id_generado=$rowsFer1[0]['Id'];
        }
?>
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <h5><i class="ace-icon fa fa-search home-icon"></i>
                <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
            </li>
            <li>
                <a href="javascript:void(0)" onclick="carga_contenido('./vista/consulta_cliente.php');"><h5>Consulta</h5></a>
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
                        <h3 class="header smaller lighter green">Datos Cliente</h3>
                        <p></p>
                        <form class="form-horizontal" role="form">
                            <input type="hidden" id="txtid" name="txtid" value="<?php echo $id_generado;?>">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                    <p class="form-control-static"><span class="label label-danger" style="font-size:150% !important;height:30px !important;">NO SE ENCUENTRA EN CAMPAÑA</span></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="dni"><h5>DNI</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="dni" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $documento;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <?php if($bandera10=="1"){?>
                                <div class="form-group">
                                    <label class="col-md-9 col-sm-3 col-xs-12 control-label no-padding-right" for="score"><h5>Score</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="score" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="<?php echo $score10;?>" readonly style="background-color:white !important;" />
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera9=="1"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="score"><h5>Score</h5></label>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input type="text" id="score" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="<?php echo $score9;?>" readonly style="background-color:white !important;" />
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($color == "VERDE"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"><h5>Prospección</h5></label>
                                    <div class="col-md-3 col-sm-9 col-xs-12" style="text-align:center;">
                                    <input type="text" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="VERDE" readonly style="background-color:green !important;color:white !important;" />
                                    </div>
                                </div>
                            <?php } elseif($color == "NARANJA") {?>
                                <div class="form-group">
                                    <label class="col-md-9 col-sm-3 col-xs-12 control-label no-padding-right"><h5>Prospección</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12" style="text-align:center;">
                                    <input type="text" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="NARANJA" readonly style="background-color:orange !important;color:white !important;" />
                                    </div>
                                </div>
                            <?php } elseif($color == "AMARILLO"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"><h5>Prospección</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12" style="text-align:center;">
                                    <input type="text" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="AMARILLO" readonly style="background-color:yellow !important;color:black !important;" />
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"><h5>Prospección</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12" style="text-align:center;">
                                        <input type="text" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="NO CAMPAÑA" readonly style="background-color:black !important;color:white !important;" />
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera2=="1"){?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>DxP</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><?php echo $btn_Estrategia_DXP;?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>PA</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><?php echo $btn_Estrategia_PA;?></p>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera2=="0"){?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>Segmentación PP</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><img src="./vista/img/negro.gif" width=35px></p>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera9=="1"){?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>Hipotecario</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><img src="./vista/img/checked.svg" width=35px></p>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera10=="1"){?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>Hipotecario</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><img src="./vista/img/unchecked_sbp.svg" width=35px></p>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera25=="1"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="montocd"><h5>Monto CD</h5></label>
                                    <div class="col-md-3 col-sm-9 col-xs-12">
                                        <input type="text" id="montocd" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="<?php echo $MONTOCD12;?>" readonly style="background-color:white !important;" />
                                    </div>
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="celular"><h5>Celular</h5></label>
                                <div class="col-md-3 col-sm-9 col-xs-12">
                                    <input type="tel" id="celular" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="<?php echo $celu;?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="minimal" id="chk_tr_regular" name="chk_tr_regular" value="1"> Trámite Regular
                                    </label>
                                </div>
                            </div>
                            <p>&nbsp;</p>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                    <a href="javascript:void(0)" id="guardar1" class="btn btn-primary btn-lg">
                                        <i class="ace-icon fa fa-save bigger-120"></i>
                                        Guardar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    foreach ($rows3 as $row_1){
        $nombre1=$row_1["PrimerNombre"];
        $nombre2=$row_1["SegundoNombre"];
        $paterno=$row_1["PrimerApellido"];
        $materno=$row_1["SegundoApellido"];
        $linea=$row_1["TC_LINEA_VISA"];
        $tarjeta=$row_1["TC_NOMBREBIN_VISA"];
        $campana=$row_1["Campanha"];
        $tasa=$row_1["TC_TEA_VISA"];
        $score=$row_1["Score"];
        $linea2=$row_1["TC_LINEA_MC"];
        $tarjeta2=$row_1["TC_NOMBREBIN_MC"];
        $tasa2=$row_1["TC_TEA_MC"];
        $linea3=$row_1["TC_LINEA_AA"];
        $tarjeta3=$row_1["TC_NOMBREBIN_AA"];
        $tasa3=$row_1["TC_TEA_AA"];
        $tarjeta4=$row_1["TC_NOMBREBIN_AA_MC"];
        $linea4=$row_1["TC_LINEA_AA_MC"];
        $tasa4=$row_1["TC_TEA_AA_MC"];
        $lineas=$row_1["TC_LINEA_VISA_SMART"];
        $tarjetas=$row_1["TC_NOMBREBIN_VISA_SMART"];
        $tasas=$row_1["TC_TEA_VISA_SMART"];
    }
    
    $sqlFer2 = $conn->prepare("select Id from bdmovil.consulta_dni where tDni ='".$documento."' and date(fFechaGrabacion) = date(now());");
    $sqlFer2->execute();
    $rowsFer2 = $sqlFer2->fetchAll();
    
    if($rowsFer2==null) {
        $sqlinserta_cons2 = $conn->prepare("insert into bdmovil.consulta_dni(tIp,tDni,tTarjeta,tLinea,tCampana,fFechaGrabacion,tUsuario,tCelular,tResultado,tZona) values ('".$ip."','".$documento."','".$tarjeta."','".$linea."','".$campana."',now(),'".strtoupper($usuario)."','".$celu."','SIN RESULTADO','".$id_zona."');");
        $sqlinserta_cons2->execute();
        $stmt2 = $conn->prepare("select Id from bdmovil.consulta_dni where tDni='".$documento."' order by Id desc limit 1;");
        $stmt2->execute();
        $res_stmt2 = $stmt2->fetchAll();
        $id_generado = $res_stmt2[0]['Id'];
        
        $sqlinserta_datos = $conn->prepare("insert into bdmovil.tbl_consulta_zona(dni,usuario,id_zona) values ('".$documento."','".strtoupper($usuario)."','".$id_zona."');");
        $sqlinserta_datos->execute();   
    } else {
        $id_generado=$rowsFer2[0]['Id'];
    }
        
?>
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <ul class="breadcrumb">
            <li>
                <h5><i class="ace-icon fa fa-search home-icon"></i>
                <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
            </li>
            <li>
                <a href="javascript:void(0)" onclick="carga_contenido('./vista/consulta_cliente.php');"><h5>Consulta</h5></a>
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
                        <h3 class="header smaller lighter green">Datos Cliente</h3>
                        <p></p>
                        <form class="form-horizontal" role="form">
                            <input type="hidden" id="txtid" name="txtid" value="<?php echo $id_generado;?>">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                    <p class="form-control-static"><span class="label label-success" style="font-size:160% !important;height:30px !important;">SE ENCUENTRA EN CAMPAÑA</span></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="dni"><h5>DNI</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="dni" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $documento;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <?php if($bandera10=="1"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="score"><h5>Score</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="score" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $score9;?>" readonly style="background-color:white !important;" />
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera10=="1"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="score"><h5>Score</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="score" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $score10;?>" readonly style="background-color:white !important;" />
                                    </div>
                                </div>
                            <?php }?>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="paterno"><h5>Paterno</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="paterno" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $paterno;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="materno"><h5>Materno</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="materno" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $materno;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="nombres"><h5>Nombres</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="nombres" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $nombre1;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="score1"><h5>Score</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="score" class="col-xs-12 col-sm-6 input-lg" value="" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tarjeta"><h5>Tarjeta</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tarjeta" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tarjeta;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="linea1"><h5>Línea</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="linea" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $linea;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tasa1"><h5>Tasa</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tasa1" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tasa;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tc1"><h5>TC</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tc1" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tarjeta2;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="linea2"><h5>Línea</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="linea2" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $linea2;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tasa2"><h5>Tasa</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tasa2" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tasa2;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tc2"><h5>TC</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tc2" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tarjeta3;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="linea3"><h5>Linea</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="linea3" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $linea3;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tasa3"><h5>Tasa</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tasa3" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tasa3;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tc3"><h5>TC</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tc3" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tarjeta4;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="linea4"><h5>Línea</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="linea4" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $linea4;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tasa4"><h5>Tasa</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tasa4" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tasa4;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tc4"><h5>TC</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tc4" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tarjetas;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="linea5"><h5>Línea</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="linea5" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $lineas;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tasa5"><h5>Tasa</h5></label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input type="text" id="tasa5" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $tasas;?>" readonly style="background-color:white !important;" />
                                </div>
                            </div>
                            <?php if($color == "VERDE"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"><h5>Prospección</h5></label>
                                    <div class="col-md-3 col-sm-9 col-xs-12" style="text-align:center;">
                                    <input type="text" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="VERDE" readonly style="background-color:green !important;color:white !important;" />
                                    </div>
                                </div>
                            <?php } elseif($color == "NARANJA") {?>
                                <div class="form-group">
                                    <label class="col-md-9 col-sm-3 col-xs-12 control-label no-padding-right"><h5>Prospección</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12" style="text-align:center;">
                                    <input type="text" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="NARANJA" readonly style="background-color:orange !important;color:white !important;" />
                                    </div>
                                </div>
                            <?php } elseif($color == "AMARILLO"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"><h5>Prospección</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12" style="text-align:center;">
                                    <input type="text" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="AMARILLO" readonly style="background-color:yellow !important;color:black !important;" />
                                    </div>
                                </div>
                            <?php } else {?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right"><h5>Prospección</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12" style="text-align:center;">
                                        <input type="text" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="NO CAMPAÑA" readonly style="background-color:black !important;color:white !important;" />
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera2=="1"){?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>DxP</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><?php echo $btn_Estrategia_DXP;?></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>PA</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><?php echo $btn_Estrategia_PA;?></p>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera9=="1"){?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>Hipotecario</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><img src='./vista/img/checked.svg' width='35px'></p>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera10=="1"){?>
                                <div class="form-group">
                                    <label class="col-sm-3 col-xs-6 control-label no-padding-right"><h5>Hipotecario</h5></label>
                                    <div class="col-sm-9 col-xs-6">
                                        <p><img src='./vista/img/unchecked_sbp.svg' width='35px'></p>
                                    </div>
                                </div>
                            <?php }?>
                            <?php if($bandera25=="1"){?>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="montocd"><h5>Monto CD</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="montocd" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $MONTOCD12;?>" readonly style="background-color:white !important;" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="tasacd"><h5>Tasa CD</h5></label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <input type="text" id="tasacd" class="col-xs-12 col-sm-6 input-lg" value="<?php echo $TASACD12;?>" readonly style="background-color:white !important;" />
                                    </div>
                                </div>
                            <?php }?>
                            <div class="form-group" id="sel_res">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="cboresultado"><h5>Resultado</h5></label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <select class="col-sm-9 col-xs-12 form-control input-lg" id="cboresultado">
                                        <option value="">SELECCIONE UNA CATEGORIA</option>
                                        <option value="VENTA">VENTA</option>
                                        <option value="SEGUIMIENTO">SEGUIMIENTO</option>
                                        <option value="NO DESEA">NO DESEA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="sel_motivo" style="display:none;">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="cboresultado2"><h5>Motivo</h5></label>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <select class="col-sm-9 col-xs-12 form-control input-lg" id="cboresultado2">
                                        <option value="">SELECCIONE UNA CATEGORIA</option>
                                        <option value="LC INSUFICIENTE">LC INSUFICIENTE</option>
                                        <option value="INTERESES">INTERESES</option>
                                        <option value="MALA EXPERIENCIA CON EL BANCO">MALA EXPERIENCIA CON EL BANCO</option>
                                        <option value="EXCESO DE TCS">EXCESO DE TCS</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-sm-3 col-xs-12 control-label no-padding-right" for="celular"><h5>Celular</h5></label>
                                <div class="col-md-3 col-sm-9 col-xs-12">
                                    <input type="tel" id="celular" class="col-xs-12 col-md-6 col-sm-6 input-lg" value="<?php echo $celu;?>"/>
                                </div>
                            </div>
                            <p>&nbsp;</p>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center;">
                                    <a href="javascript:void(0)" id="guardar2" class="btn btn-primary btn-lg">
                                        <i class="ace-icon fa fa-save bigger-120"></i>
                                        Guardar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<script>
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    });

    $("#sel_res").change(function(){
        var resultado = $("#cboresultado").val();

        if(resultado=="NO DESEA"){
            $("#sel_motivo").css('display','block');
        } else {
            $("#sel_motivo").css('display','none');
        }
    });

    $("#guardar1").on('click',function(){
        var txtid = $("#txtid").val();
        var txtdni = $("#dni").val();
        var txtcelular = $("#celular").val();
        var tr_regular = 0;

        if(document.getElementById("chk_tr_regular").checked == true){
            tr_regular = 1;
        }

        var txtscore = $("#score").val();
        var txtbase = "";

        $.ajax({
            type: "post",
            url: "controlador/guarda_res_consulta.php",
            data: {
                txtid: txtid,
                txtdni: txtdni,
                txtcelular: txtcelular,
                tr_regular: tr_regular,
                txtscore: txtscore,
                txtbase: txtbase
            },
            success: function(datos) {
                carga_contenido('./vista/consulta_cliente.php');
            }
        });
    });

    $("#guardar2").on('click',function(){
        var txtid = $("#txtid").val();
        var txtdni = $("#dni").val();
        var txtcelular = $("#celular").val();
        var txttarjeta = $("#tarjeta").val();
        var txtlinea = $("#linea1").val();
        var cboresultado = $("#cboresultado").val()
        var cboresultado2 = "";

        if(cboresultado=="NO DESEA"){
            cboresultado2 = $("#cboresultado2").val();
        }

        var txtscore = $("#score1").val();
        var txtbase = "";

        if(cboresultado!=""){
            var res = 1;

            if(cboresultado=="NO DESEA" && cboresultado2==""){res=0;}

            if(res==1){
                $.ajax({
                    type: "post",
                    url: "controlador/guarda_res_consulta2.php",
                    data: {
                        txtid: txtid,
                        txtdni: txtdni,
                        txtcelular: txtcelular,
                        txttarjeta: txttarjeta,
                        txtlinea: txtlinea,
                        cboresultado: cboresultado,
                        cboresultado2: cboresultado2,
                        txtscore: txtscore,
                        txtbase: txtbase
                    },
                    success: function(datos) {
                        carga_contenido('./vista/consulta_cliente.php');
                    }
                });
            } else {
                if(cboresultado2==""){
                    $("#sel_motivo").addClass("has-error has-feedback");
                    swal("¡Error! Por favor, seleccione un motivo.", { icon: "error", });
                } else {
                    $("#sel_motivo").removeClass("has-error has-feedback");
                }
            }
        } else {
            if(cboresultado==""){
                $("#sel_res").addClass("has-error has-feedback");
                swal("¡Error! Por favor, seleccione un resultado.", { icon: "error", });
            } else {
                $("#sel_res").removeClass("has-error has-feedback");
            }
        }
    });
</script>