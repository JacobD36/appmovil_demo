<?php 
    session_start();
    require_once("../configuracion/database.php");
    require_once("../modelo/usuario_model.php");
    $usr = new usuario_model();
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $id = $_POST['id'];
    $usr_info = $usr->get_edit_persona($id);
    
    if($pass1!="" && $pass2!=""){
        if($pass1==$pass2){
            $usr->actualiza_password($usr_info[0]['codusuario'],$pass1);
        }
    }

?>