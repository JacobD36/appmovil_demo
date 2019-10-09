<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $user = new usuario_model();
    $id = $_POST['id'];
    $user->cambia_estado_login($id,0);
?>