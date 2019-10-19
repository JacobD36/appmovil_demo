<?php
    require_once("../configuracion/database.php");
    $conn = database::conexion_1();
    $id=$_POST["txtid"];
    $resultado=$_POST["cboresultado"];

    $stmt = $conn->prepare("update bdmovil.consulta_dni set tResultado='".$resultado."' where Id = ".$id." and date(fFechaGrabacion) = date(now());");
    $stmt->execute();

    //$stmt1 = $conn->prepare("update bdmovil.consulta_dni_banco2 set tResultado='".$resultado."' where Id = ".$id." and date(fFechaGrabacion) = date(now());");
    //$stmt1->execute();
?>