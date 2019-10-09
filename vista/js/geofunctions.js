var id = 0;
var tipo = 0;

function captura_coordenadas(id, tipo) {
    this.id = id;
    this.tipo = tipo;
    if (navigator.geolocation) {
        var tiempo_de_espera = 3000;
        navigator.geolocation.getCurrentPosition(registraCoordenadas, registraError, { enableHighAccuracy: true, timeout: tiempo_de_espera, maximumAge: 0 });
    }
}

function registraCoordenadas(position) {
    var user = this.id;

    $.ajax({
        type: "post",
        url: "controlador/guarda_ubicacion.php",
        data: {
            latitud: position.coords.latitude,
            longitud: position.coords.longitude,
            usuario: user,
            tipo: this.tipo
        },
        success: function(datos) {}
    });
}

function registraError(error) {
    var latitude = 0;
    var longitude = 0;
    var user = this.id;

    $.ajax({
        type: "post",
        url: "controlador/guarda_ubicacion.php",
        data: {
            latitud: latitude,
            longitud: longitude,
            usuario: user,
            tipo: this.tipo
        },
        success: function(datos) {
            //location.assign("../prospecting_demo/inicio.php");
        }
    });
}