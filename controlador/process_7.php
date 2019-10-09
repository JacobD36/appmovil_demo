<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $qwerty = new usuario_model();
    $tipo_reporte = '2';
    $fecha1 = $_GET["fecha1"];
    $fecha2 = $_GET["fecha2"];
    $usuario = $_GET["usuario"];

    if ($fecha2!=""){
        $sqlFecha ="   between '".$fecha1."' and '".$fecha2."' ";
    } else{
        $sqlFecha ="   = '".$fecha1."' ";
    }

    if($fecha1 == ""){
        $sqlFecha =" =date(now()) ";
    }

    if($usuario=="0")
        $sqlUsuario="";
    else
        $sqlUsuario=" and usuario = '".$usuario."'";

    if ($usuario=="") {
        $sqlUsuario="";
    } else {
        $sqlUsuario=" and usuario in ('".$usuario."')";
    }

    $sql = database::conexion_1()->prepare("select fec_reg,estado,usuario,dni FROM bdmovil.tbl_datos where date(fec_reg) $sqlFecha $sqlUsuario");
    $sql->execute();
    $rows = $sql->fetchAll();

    $i=0;
    if ($rows!=null) {
        foreach ($rows as $data) {
            $i++;
            $arreglo["data"][] = array($data['fec_reg'],$data['estado'],$data['usuario'],$data['dni']);
        }
    } else {
        $arreglo["data"][] = array('','<center>SIN REGISTROS</center>','','');
    }
	echo json_encode($arreglo);
?>