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
    $f1 = $_GET['f1'];
    $f2 = $_GET['f2'];
    $data = new usuario_model();
    $elem = $data->get_all_regs($_SESSION['usuario'],$f1,$f2);
    if ($elem!=null) {
        $i=1;
        $consulta = 0;
        $efectivos = 0;
        foreach ($elem as $lista) {
            $arreglo["data"][] = array($i,$lista['FECHA'],$lista['CONSULTA'],$lista['EFECTIVOS']);
            $consulta+=$lista['CONSULTA'];
            $efectivos+=$lista['EFECTIVOS'];
            $i++;
        }
        $arreglo["data"][] = array('','<strong>TOTAL</strong>',$consulta,$efectivos);
    } else {
        $arreglo["data"][] = array('','','SIN REGISTROS','');
    }
    echo json_encode($arreglo,JSON_UNESCAPED_UNICODE|JSON_PARTIAL_OUTPUT_ON_ERROR|JSON_ERROR_UTF8|JSON_ERROR_RECURSION);
?>