<!DOCTYPE html>
<html lang="en">
<head>
	<title>:: App Bayental ::</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="./vista/img/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="./vista/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./vista/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./vista/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="./vista/vendor/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="./vista/vendor/css-hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="./vista/vendor/animsition/css/animsition.min.css">
	<link rel="stylesheet" type="text/css" href="./vista/vendor/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="./vista/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="./vista/css/login/util.css">
	<link rel="stylesheet" type="text/css" href="./vista/css/login/main.css">
    <style type="text/css">
        .p-t-85 {
            padding-top: 10px !important;
        }
        .m-t-85 {
            margin-top: 20px !important;
        }
    </style>
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-t-85 p-b-20">
				<form class="login100-form" method="POST">
					<span class="login100-form-avatar">
						<img src="./vista/img/Bpro_v2.jpg" alt="AVATAR">
					</span>
					<div class="wrap-input100 validate-input m-t-85 m-b-35" id="usr_input" data-validate = "Ingrese Usuario">
						<input class="input100" type="text" name="usuario" id="usuario">
						<span class="focus-input100" data-placeholder="Usuario"></span>
					</div>
					<div class="wrap-input100 validate-input m-b-50" id="pass_input" data-validate="Ingrese Contraseña">
						<input class="input100" type="password" name="pass" id="pass">
						<span class="focus-input100" data-placeholder="Contraseña"></span>
					</div>
					<div class="container-login100-form-btn">
                        <a href="javascript:void(0)" class="login100-form-btn" style="color:white;" onclick="verifica_login();">Ingresar</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="./vista/vendor/jquery/jquery-3.2.1.min.js"></script>
	<script src="./vista/vendor/animsition/js/animsition.min.js"></script>
	<script src="./vista/vendor/bootstrap/js/popper.js"></script>
	<script src="./vista/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="./vista/vendor/select2/select2.min.js"></script>
	<script src="./vista/vendor/daterangepicker/moment.min.js"></script>
	<script src="./vista/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="./vista/vendor/countdowntime/countdowntime.js"></script>
    <script src="./vista/js/login/main.js"></script>
    <script>
        function verifica_login(){
            var user = $("#usuario").val();
            var pass = $("#pass").val();

            if(user!="" && pass!=""){
                $.ajax({
                    type: "post",   
                    url: "controlador/login_getlogininfo.php",
                    data: {
                        username: user,
                        userpass: pass
                    },
                    success: function(datos) {
                        if(datos!="error"){
                            $("#usr_input").removeClass('alert-validate');
                            $("#pass_input").removeClass('alert-validate');
                            location.assign("../prospecting_demo/inicio.php");
                        } else {
                            location.assign("../prospecting_demo/inicio.php");
                        }
                    }
                });
            } else {
                if(user==""){
                    $("#usr_input").addClass('alert-validate');
                    if(pass!=""){
                        $("#pass_input").removeClass('alert-validate');
                    }
                }
                if(pass==""){
                    $("#pass_input").addClass('alert-validate');
                    if(user!=""){
                        $("#usr_input").removeClass('alert-validate');
                    }
                }
            }
        }

        function registraCoordenadas(position) {
            //alert("Latitud: " + position.coords.latitude + ", Longitud: " + position.coords.longitude);
            alert("Latitud: " + position.coords.latitude);
            alert("Longitud: " + position.coords.longitude);
        }
    </script>
</body>
</html>