<?php 
    session_start();
    if ($_SESSION['usuario'] == '') {
        header('Location: ./index.php');
    }
    require_once("./configuracion/database.php");
    require_once("./modelo/usuario_model.php");
    $info = new usuario_model();
    $persona = $info->get_personal_info($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>:: App Bayental ::</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" href="./vista/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./vista/assets/font-awesome/4.5.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="./vista/assets/css/fonts.googleapis.com.css" />
    <link rel="stylesheet" href="./vista/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="./vista/assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="./vista/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="./vista/datatables/datatables.min.css">
    <link rel="stylesheet" href="./vista/plugins/iCheck/all.css">
    <script src="./vista/assets/js/ace-extra.min.js"></script>
    <style type="text/css">
        .navbar-fixed-top+.main-container {
            padding-top: 46px !important;
        }
        .navbar:not(.navbar-collapse) .ace-nav {
            text-align: right !important;
        }
        .navbar .navbar-brand {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }
    </style>
</head>
<body class="no-skin">
    <div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top">
        <div class="navbar-container ace-save-state" id="navbar-container">
            <div class="navbar-header pull-left">
                <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');" class="navbar-brand">
                    <span><img src="./vista/img/logo_2.png" id="id_img_header" class="center-block img-responsive" style="height:46px;"/></span>
                </a>
                <div class="navbar-buttons navbar-header pull-right" role="navigation">
                    <ul class="nav ace-nav">
                        <li class="light-blue dropdown-modal">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="./vista/img/avatar.png" alt="Jason's Photo" />
                                <span class="user-info">
                                    <small>Bienvenido(a),</small>
                                    <?php echo utf8_encode($persona[0]['nombre1']);?>
                                </span>
                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>
                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <li>
                                    <a href="javascript:void(0)" id="logout_btn">
                                        <i class="ace-icon fa fa-power-off"></i>
                                        Salir
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try{ace.settings.loadState('main-container')}catch(e){}
        </script>
        <div class="main-content">
            <div class="main-content-inner" id="contenido_principal">
            </div>
        </div>
        <div class="footer">
            <div class="footer-inner">
                <div class="footer-content">
                    <span class="bigger-120">
                        <span class="blue bolder">Bayental BPO</span>
                        2019
                    </span>
                </div>
            </div>
        </div>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
        <input type="hidden" id="codusuario" name="codusuario" value="<?php echo $_SESSION['usuario'];?>">
    </div>
    <script src="./vista/assets/js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='./vista/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="./vista/assets/js/bootstrap.min.js"></script>
    <script src="./vista/assets/js/ace-elements.min.js"></script>
    <script src="./vista/assets/js/ace.min.js"></script>
    <script src="./vista/js/geofunctions.js"></script>
    <script src="./vista/datatables/datatables.min.js"></script>
    <script type="text/javascript" src="./vista/sweetalert/dist/sweetalert.min.js"></script>
    <script src="./vista/plugins/iCheck/icheck.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            carga_contenido('./vista/principal.php');
            captura_coordenadas('<?php echo $_SESSION['id'];?>',1);
        });

        $("#logout_btn").on('click',function(){
            salir('<?php echo $_SESSION['id'];?>');
        });

        jQuery(function($) {
            $('#id-change-style').on(ace.click_event, function() {
                var toggler = $('#menu-toggler');
                var fixed = toggler.hasClass('fixed');
                var display = toggler.hasClass('display');
                
                if(toggler.closest('.navbar').length == 1) {
                    $('#menu-toggler').remove();
                    toggler = $('#sidebar').before('<a id="menu-toggler" data-target="#sidebar" class="menu-toggler" href="#">\
                        <span class="sr-only">Toggle sidebar</span>\
                        <span class="toggler-text"></span>\
                        </a>').prev();
        
                        var ace_sidebar = $('#sidebar').ace_sidebar('ref');
                        ace_sidebar.set('mobile_style', 2);
        
                        var icon = $(this).children().detach();
                        $(this).text('Hide older Ace toggle button').prepend(icon);
                        
                        $('#id-push-content').closest('div').hide();
                        $('#id-push-content').removeAttr('checked');
                        $('.sidebar').removeClass('push_away');
                    } else {
                    $('#menu-toggler').remove();
                    toggler = $('.navbar-brand').before('<button data-target="#sidebar" id="menu-toggler" class="three-bars pull-left menu-toggler navbar-toggle" type="button">\
                        <span class="sr-only">Toggle sidebar</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>\
                    </button>').prev();
                    
                        var ace_sidebar = $('#sidebar').ace_sidebar('ref');
                        ace_sidebar.set('mobile_style', 1);
                    
                    var icon = $(this).children().detach();
                    $(this).text('Show older Ace toggle button').prepend(icon);
                    
                    $('#id-push-content').closest('div').show();
                    }
        
                    if(fixed) toggler.addClass('fixed');
                    if(display) toggler.addClass('display');
                    
                    $('.sidebar[data-sidebar-hover=true]').ace_sidebar_hover('reset');
                    $('.sidebar[data-sidebar-scroll=true]').ace_sidebar_scroll('reset');
        
                    return false;
            });
        });

        function carga_contenido(url){
            $("#contenido_principal").load(url);
        }

        function unblock_user(id){
            id = id;

            $.ajax({
                type: "post",
                url: "controlador/unblock.php",
                data: {
                    id: id
                },
                success: function(datos) {
                    $('#my-table').DataTable().ajax.reload();
                    swal("¡Usuario desbloqueado! El usuario se encuentra activo para el login.", {icon: "success",});
                }
            });
        }

        function salir(id){
            var id = id;
            captura_coordenadas(id,2);

            $.ajax({
                type: "post",
                url: "controlador/logout.php",
                data: {
                    id: id
                },
                success: function(datos) {
                    location.assign("../index.php");
                }
            });
        }
    </script>
</body>
</html>
