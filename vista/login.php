<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>:: App Bayental ::</title>
    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="./vista/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./vista/assets/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./vista/assets/css/fonts.googleapis.com.css" />
    <link rel="stylesheet" href="./vista/assets/css/ace.min.css" />
    <link rel="stylesheet" href="./vista/assets/css/ace-rtl.min.css" />
</head>
<body class="login-layout light-login">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <h1>
                                <i class="ace-icon fa fa-desktop green"></i>
                                <span class="blue">App</span>
                                <span class="white" id="id-text2">Bayental</span>
                            </h1>
                            <h4 class="blue" id="id-company-text">&copy; 2019</h4>
                        </div>
                        <div class="space-6"></div>

                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                            <i class="ace-icon glyphicon glyphicon-pencil green"></i>
                                            Por favor, ingresa tus credenciales
                                        </h4>
                                        <div class="row">
                                            <div class="col-xs-12" id="mensaje" style="display:none;">
                                                <div class='alert alert-danger'>
                                                    <button type='button' class='close' id="alert_close_1" data-dismiss='alert'>
                                                        <i class='ace-icon fa fa-times'></i>
                                                    </button>Por favor Ingrese su usuario y contraseña
                                                </div>
                                            </div>
                                            <div class="col-xs-12" id="mensaje1" style="display:none;">
                                                <div class='alert alert-danger'>
                                                    <button type='button' class='close' id="alert_close_2" data-dismiss='alert'>
                                                        <i class='ace-icon fa fa-times'></i>
                                                    </button>Usuario y/o contraseña incorrectos
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <form>
                                            <fieldset>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="text" id="usuario" nombre="usuario" class="form-control" placeholder="Usuario" />
                                                        <i class="ace-icon fa fa-user"></i>
                                                    </span>
                                                </label>

                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="password" id="password" nombre="password" class="form-control" placeholder="Contraseña" />
                                                        <i class="ace-icon fa fa-lock"></i>
                                                    </span>
                                                </label>
                                                <div class="space"></div>
                                                <div class="clearfix">
                                                    <button type="button" id="login_btn" class="width-35 pull-right btn btn-sm btn-primary">
                                                        <i class="ace-icon fa fa-key"></i>
                                                        <span class="bigger-110">Ingresar</span>
                                                    </button>
                                                </div>
                                                <div class="space-4"></div>
                                            </fieldset>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./vista/assets/js/jquery-2.1.4.min.js"></script>
    <script src="./vista/js/getlogininfo.js"></script>
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='./vista/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script type="text/javascript">
        jQuery(function($) {
            $(document).on('click', '.toolbar a[data-target]', function(e) {
            e.preventDefault();
            var target = $(this).data('target');
            $('.widget-box.visible').removeClass('visible');
            $(target).addClass('visible');
            });
        });

        $("#alert_close_1").on('click',function(){
            $("#mensaje").css('display','none');
        });

        $("#alert_close_2").on('click',function(){
            $("#mensaje1").css('display','none');
        });

        $("#login_btn").on('click',function(){
            var user = $("#usuario").val();
            var pass = $("#password").val();

            if(user!="" && pass!=""){
                $("#mensaje").css('display','none');
                $.ajax({
                    type: "post",
                    url: "controlador/login_getlogininfo.php",
                    data: {
                        username: user,
                        userpass: pass
                    },
                    success: function(datos) {
                        if(datos!="error"){
                            if (navigator.geolocation) {
                                var tiempo_de_espera = 3000;
                                navigator.geolocation.getCurrentPosition(registraCoordenadas, registraError, { enableHighAccuracy: true, timeout: tiempo_de_espera, maximumAge: 0 } );
                            }
                        } else {
                            $(":text").each(function () {
                                $($(this)).val('');
                            });
                            $(":password").each(function () {
                                $($(this)).val('');
                            });
                            $("#mensaje1").css('display','block');
                        }
                    }
                });
            } else {
                $("#mensaje").css('display','block');
            }
        });

        function registraCoordenadas(position) {
            var user = $("#usuario").val();

            $.ajax({
                type: "post",
                url: "controlador/guarda_ubicacion.php",
                data: {
                    latitud: position.coords.latitude,
                    longitud: position.coords.longitude,
                    usuario: user,
                    tipo: 1
                },
                success: function(datos) {
                    location.assign("../prospecting_demo/inicio.php");
                }
            });
        }

        function registraError(error) {
            var latitude = 0;
            var longitude = 0;
            var user = $("#usuario").val();

            $.ajax({
                type: "post",
                url: "controlador/guarda_ubicacion.php",
                data: {
                    latitud: latitude,
                    longitud: longitude,
                    usuario: user,
                    tipo: 1
                },
                success: function(datos) {
                    location.assign("../prospecting_demo/inicio.php");
                }
            });
        }
    </script>
</body>
</html>
