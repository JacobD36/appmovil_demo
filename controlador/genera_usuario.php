<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    date_default_timezone_set("America/Lima");
    $fecha_actual = date("Y-m-d H:m:s");
    $usr = new usuario_model();

    $codigo = $_POST['codigo'];
    $nombre1 = utf8_decode($_POST['nombre1']);
    $nombre2 = utf8_decode($_POST['nombre2']);
    $apellido1 = utf8_decode($_POST['apellido1']);
    $apellido2 = utf8_decode($_POST['apellido2']);
    $correo = $_POST['correo'];
    $dni = $_POST['dni'];
    $cex = $_POST['cex'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $equipo = $_POST['equipo'];
    $nivel = $_POST['nivel'];
    $estado_l = $_POST['estado_l'];
    $estado = $_POST['estado'];
    $nReporte = $_POST['nReporte'];

    if($nombre1!="" && $apellido1!="" && $apellido2!="" && $dni!="" && $cex!="" && $password1!="" && $password2!="" && $equipo!="" && $nivel!=""){
        if($password1==$password2){
            $usuario = $usr->set_new_user($codigo,$nombre1,$nombre2,$apellido1,$apellido2,$correo,$dni,$cex,$password1,$equipo,$nivel,$estado_l,$estado,$fecha_actual,$nReporte);
            echo $usuario;
        }
    }
?>