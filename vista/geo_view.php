<?php
    session_start();
    if (!isset($_SESSION['usuario'])) {
    ?>
    <script>
        location.assign("../prospecting_demo/index.php");
    </script>
    <?php
    }
    $lat = $_GET['lat'];
    $long = $_GET['long'];
?>
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <h5><i class="ace-icon fa fa-compass home-icon"></i>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/principal.php');">Inicio</a></h5>
        </li>
        <li>
            <a href="javascript:void(0)" onclick="carga_contenido('./vista/geoposicion.php');"><h5>Sucesos</h5></a>
        </li>
        <li class="active">
            <a href="javascript:void(0)"><h5>Detalle Ubicación</h5></a>
        </li>
    </ul>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-xs-12">
            <div class="row">
                <input type="hidden" id="lat" name="lat" value="<?php echo $lat;?>">
                <input type="hidden" id="long" name="long" value="<?php echo $long;?>">
                <div class="col-sm-12 col-md-12 col-xs-12">
                    <div id="mapa" style="width: 100%; height: 400px; border: 1px solid #d0d0d0;"></div>
                </div>
            </div>
            <p>&nbsp;</p>
            <div class="row">
                <p>Latitud: <?php echo $lat;?></p>
                <p>Longitud: <?php echo $long;?></p>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
       mapa();
    });
        
    function mapa(){
        var contenedor = document.getElementById("mapa");
        var latitud = $("#lat").val();
        var longitud = $("#long").val();;

        var centro = new google.maps.LatLng(latitud,longitud);

        var propiedades =
        {
            zoom: 15,
            center: centro,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(contenedor, propiedades);

        var marcador = new google.maps.Marker({
            position: centro,
            map: map,
            title: "Tu posicion actual"
        });
    }
</script>