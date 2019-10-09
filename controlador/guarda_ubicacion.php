<?php 
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    date_default_timezone_set("America/Lima");
    $fecha_actual = date("Y-m-d");
    $hora_actual = date("H:m:s");
    $info = new usuario_model();
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $usuario = $_POST['usuario'];
    $tipo = $_POST['tipo'];
    $info->registra_ubicacion($usuario,$latitud,$longitud,$tipo,$fecha_actual,$hora_actual);
?>