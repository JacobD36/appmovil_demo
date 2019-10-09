<?php
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    date_default_timezone_set("America/Lima");
    $usuario = new usuario_model();
    $fecha_actual = date("Y-m-d");
    $hora_actual = date("H:m:s");
    $ip = $usuario->getRealIP();
    $usuario->registra_actividad($_SESSION['id'],$ip,2,$fecha_actual,$hora_actual);
    $usuario->cambia_estado_login($_SESSION['id'],0);
    session_destroy();
?>