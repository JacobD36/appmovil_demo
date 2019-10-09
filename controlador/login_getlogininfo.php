<?php
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    session_start();
    date_default_timezone_set("America/Lima");
    $fecha_actual = date("Y-m-d");
    $hora_actual = date("H:m:s");
    $usuario = new usuario_model();
    $username = strtolower($_POST['username']);
    $userpass = $_POST['userpass'];
    $ip = $usuario->getRealIP();
    if($username!='' and $userpass!='') {
        $idperfil = $usuario->valida_acceso($username, $userpass);
        if ($idperfil!=null) {
            if ($usuario->esta_logueado($idperfil[0]['id'])==0) {
                $_SESSION['usuario'] = $username;
                $_SESSION['perfil'] = $idperfil[0]['idperfil'];
                $_SESSION['id'] = $idperfil[0]['id'];
                $_SESSION['start'] = time();
                $_SESSION['equipo'] = $idperfil[0]['cod_equipo'];
                $usuario->registra_actividad($idperfil[0]['id'], $ip, 1, $fecha_actual, $hora_actual);
                $usuario->cambia_estado_login($idperfil[0]['id'],1);
                ?>
                <script type="text/javascript">
                    location.assign("../inicio.php");
                </script>
                <?php
            } else {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                El usuario ya se encuentra logueado
            </div>
            <?php
            }
        } else {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                Usuario y/o contraseña incorrectos
            </div>
            <script type="text/javascript">
                $(":text").each(function () {
                    $($(this)).val('');
                });
                $(":password").each(function () {
                    $($(this)).val('');
                });
            </script>
            <?php
            $_SESSION = array();
        }
    } else {
        ?>
        <div class="alert alert-danger alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
            Por favor, ingrese la información solicitada
        </div>
        <?php
    }
?>