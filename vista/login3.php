<?php 
    require_once("./controlador/Mobile_Detect.php");
    $disp = new Mobile_Detect();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./vista/img/favicon.ico"/>
    <link rel="stylesheet" href="./vista/css/bootstrap.min.css">
    <link rel="stylesheet" href="./vista/css/login_style.css">
    <script type="text/javascript" src="./vista/js/getlogininfo.js"></script>
    <script src="./vista/js/jquery.min.js"></script>
    <script src="./vista/js/bootstrap.min.js"></script>
    <title>:: App Bayental ::</title>
    <?php if($disp->isMobile()){?>
        <style>
            body {
                background-color: white !important;
            }
            .card {
                box-shadow: 0px 0px 0px rgba(0,0,0,0.3) !important;
            }
        </style>
    <?php }?>
</head>
<body>
<?php if(!$disp->isMobile()){?>
    <div class="container">
        <div class="card card-container">
            <img src="./vista/img/LOGOBPO-FONDO-BLANCO.jpg" class="center-block img-responsive">
            <p id="profile-name" class="profile-name-card"></p>
            <div class="titulo"></div>
            <form class="form-signin">
                <div id="resultado"></div>
                <input type="text" id="username" class="form-control" placeholder="Usuario" required autofocus>
                <input type="password" id="userpass" class="form-control" placeholder="Contraseña" required>
                <div><p></p></div>
                <button type="button" onclick="captura_datos();" class="btn btn-primary">Ingresar</button>
            </form>
        </div>
    </div>
<?php } else {?>
    <div class="container" style="padding-right:0px !important;padding-left:0px !important;margin-right:0px !important;margin-left:0px !important;">
        <div class="card card-container" style="max-width:100% !important;padding-left:20px;padding-right:20px;">
            <img src="./vista/img/LOGOBPO-FONDO-BLANCO.jpg" class="center-block img-responsive">
            <p id="profile-name" class="profile-name-card"></p>
            <div class="titulo"></div>
            <form class="form-signin">
                <div id="resultado"></div>
                <input type="text" id="username" class="form-control" placeholder="Usuario" required autofocus>
                <input type="password" id="userpass" class="form-control" placeholder="Contraseña" required>
                <div><p></p></div>
                <button type="button" onclick="captura_datos();" class="btn btn-primary">Ingresar</button>
            </form>
        </div>
    </div>
<?php }?>
</body>
</html>