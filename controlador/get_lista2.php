<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $codusuario = $_GET['cod'];
    $data = new usuario_model();
    $elem = $data->get_lista2($codusuario);
    $i=1;
    if ($elem!=null) {
        foreach ($elem as $lista) {
            $det_dni = "<a href='javascript:void(0)' onclick='muestra_dni(".$lista['tDni'].")'>".$lista['tDni']."</a>";
            $arreglo["data"][] = array($i,$get_dni,$lista['fFechaGrabacion']);
            $i++;
        }
    } else {
        $arreglo["data"][] = array('','SIN REGISTROS','');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>