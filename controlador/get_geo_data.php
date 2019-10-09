<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $id = $_GET['usr'];
    $f1 = $_GET['f1'];
    $f2 = $_GET['f2'];
    $data = new usuario_model();
    $elem = $data->get_geo_data($id,$f1,$f2);
    if ($elem!=null) {
        foreach ($elem as $lista) {
            $codusuario = $data->get_user_info($lista['idusuario']);
            $url = "\"./vista/geo_view.php?lat=".$lista['latitud']."&long=".$lista['longitud']."\"";
            $geo_ref = "<a href='javascript:void(0)' onclick='carga_contenido(".$url.")'>".$codusuario[0]['codusuario']."</a>";
            $arreglo["data"][] = array($lista['id'],$geo_ref,$lista['tipo'],$lista['fecha'],$lista['hora']);
        }
    } else {
        $arreglo["data"][] = array('','SIN REGISTROS','','','');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>