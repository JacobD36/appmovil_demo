<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $data = new usuario_model();
    $elem = $data->get_all_personas();
    if ($elem!=null) {
        foreach ($elem as $lista) {
            $logueado = 0;
            if($data->esta_logueado($lista['id'])==1){$logueado=1;}
            $url = "\"./vista/edita_usuario.php?id=".$lista['id']."\"";
            $btn_editar = "<a href='javascript:void(0)' style='text-decoration:none;' onclick='carga_contenido(".$url.");'><button type='button' class='btn btn-success btn-sm'><i class='glyphicon glyphicon-pencil'></i></button></a>";
            $btn_unblock = "<a href='javascript:void(0)' style='text-decoration:none;' onclick='unblock_user(".$lista['id'].");'><button type='button' class='btn btn-danger btn-sm'><i class='glyphicon glyphicon-off'></i></button></a>";
            $arreglo["data"][] = array($lista['tCodigo'],$lista['nombre'],$lista['apellido1'],$lista['apellido2'],$lista['codusuario'],$logueado,$lista['nivel'],$lista['cod_equipo'],$lista['medio_tiempo'],$lista['estado'],$btn_editar." ".$btn_unblock);
        }
    } else {
        $arreglo["data"][] = array('SIN REGISTROS','','','','','','','','','');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>