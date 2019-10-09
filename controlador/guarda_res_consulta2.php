<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
    ?>
    <script>
        location.assign("../index.php");
    </script>
    <?php
    }
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $data = new usuario_model();

    $conn = database::conexion_1();
    $ip = $data->getRealIP();

    $usuario=strtoupper($_SESSION["usuario"]);
    $documento=$_POST["txtdni"];
    $celular=$_POST["txtcelular"];
    $tarjeta=$_POST["txttarjeta"];
    $linea=$_POST["txtlinea"];
    $resultado=$_POST["cboresultado"];
    $motivo=$_POST["cboresultado2"];
    $score=$_POST["txtscore"];
    $base=$_POST["txtbase"];
    $id=$_POST["txtid"];

    if($id=='0'){
        $sqlinserta = $conn->prepare("update bdmovil.consulta_dni set fFechaGrabacion = now(),tCelular='".$celular."',tResultado='".$resultado."',tMotivo='".$motivo."',tUsuario='".$usuario."' where  tDni ='".$documento."' and date(ffechaGrabacion) = date(now()) and tResultado not in ('VENTA');");
        $sqlinserta->execute();
    }
    else{
        $sqlinserta = $conn->prepare("update bdmovil.consulta_dni set fFechaGrabacion = now(),tCelular='".$celular."',tResultado='".$resultado."',tMotivo='".$motivo."' where id ='".$id."';");
        $sqlinserta->execute();
    }
?>