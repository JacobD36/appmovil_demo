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
    $conn = database::conexion_1();
    $data = new usuario_model();
    $ip=$data->getRealIP();

    $usuario=$_SESSION["usuario"];
    $id=$_POST["txtid"];
    $documento=$_POST["txtdni"];
    $celular=$_POST["txtcelular"];
    $check=$_POST["tr_regular"];
    $score=$_POST["txtscore"];
    $base=$_POST["txtbase"];

    if($check == '1')
        $resultado='TRAMITE REGULAR';
    else
        $resultado='';

    $sqlinserta = $conn->prepare("update bdmovil.consulta_dni set tCelular = '".$celular."', tResultado='".$resultado."'  where Id ='".$id."';");
    $sqlinserta->execute();
    $sqlinserta2 = $conn->prepare("insert into bdmovil.consulta_hipotecario(tIp,tDni,fFechaGrabacion,tUsuario,tCelular,tUsuario2,tScore,tbaseNegativa) values ('".$ip."','".$documento."',now(),'".strtoupper($usuario)."','".$celular."','".$usuario."','".$score."','".$base."');");
    $sqlinserta2->execute();
?>