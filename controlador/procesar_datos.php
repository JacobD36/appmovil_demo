<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    if (!isset($_SESSION['usuario'])) {
        ?>
        <script>
            location.assign("../index.php");
        </script>
        <?php
    }
    $zona = $_POST['zona'];
    $usuario = strtoupper($_SESSION['usuario']);
    $elem = new usuario_model();
    $q3 = $elem->set_abordamiento($usuario,$zona);
    echo "<a href='javascript:void(0)' class='btn btn-lg btn-danger radius-4' style='float:right;margin:5px;'><i class='ace-icon fa fa-user'></i><span class='badge'>".$q3."</span></a>";
?>