<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $usr = new usuario_model();
    $id = $_POST['id'];
    $nombre1 = strtoupper($_POST['nombre1']);
    $nombre2 = strtoupper($_POST['nombre2']);
    $apellido1 = strtoupper($_POST['apellido1']);
    $apellido2 = strtoupper($_POST['apellido2']);
    $correo = $_POST['correo'];
    $dni = $_POST['dni'];
    $cex = $_POST['cex'];
    $equipo = $_POST['equipo'];
    $nivel = $_POST['nivel'];
    $estado_l = $_POST['estado_l'];
    $estado = $_POST['estado'];
    $nReporte = $_POST['nReporte'];
    $turno = $_POST['turno'];

    if($nombre1!="" && $apellido1!="" && $apellido2!="" && $dni!="" && $cex!="" && $equipo!="" && $nivel!=""){
        $usr->actualiza_persona($id,$nombre1,$nombre2,$apellido1,$apellido2,$correo,$dni,$cex,$equipo,$nivel,$estado_l,$estado,$nReporte,$turno);
    }
?>