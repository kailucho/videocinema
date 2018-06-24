<?php require RUTA_APP.'/vistas/inc/header_admin.php'; ?>
<style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */

    #map {
        height: 100%;
        width: 100%;
        position: relative; /* has to be position relative for left to work, or you could just do margin-left: -50px; too */
       
        z-index: 100;
    }
    /* Optional: Makes the sample page fill the window. */

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        z-index: -1;
        
    }
</style>
<div class="row">
  <div class="container">
    <div class="col-50">
      <form method="post" enctype="multipart/form-data" action="<?php echo RUTA_URL; ?>paginas/agregarCine">
        <div class="row">
            <div class="col-50">
                <h3>Datos del videocinema</h3>
                <label>
                <i class="fa fa-user"></i> Nombre del videocinema
                </label>
                <input type="text" name="nombreCine">

                <label>
                <i class="fa fa-user"></i> Descripcion
                </label>
                <input type="text" name="descripcionCine">

                <label>
                <i class="fa fa-user"></i> Logo
                </label>
                <input type="file" name="logoCine">
                <br>

                <div class="row">
                    <div class="col-25">
                         <label>
                        <i class="fa fa-user"></i> Horario
                        </label>
                        <input type="text" name="horarioCine">
                    </div>
                    <div class="col-25">
                        <label>
                        <i class="fa fa-user"></i> direccion
                        </label>
                        <input type="text" name="direccionCine">
                    </div>
                    <div class="col-25">
                        <label>
                        <i class="fa fa-user"></i> salas
                        </label>
                        <input type="text" name="salasCine">
                    </div>
                </div>       

                <div class="row">
                    <div class="col-25">
                        <label>
                        <i class="fa fa-user"></i> telefono
                        </label>
                        <input type="text" name="telefonoCine">
                    </div>
                    <div class="col-25">
                        <label>
                        <i class="fa fa-user"></i> latitud
                        </label>
                        <input id="lat"  type="text" name="latitudCine">
                    </div>
                    <div class="col-25">
                        <label>
                        <i class="fa fa-user"></i> longitud
                        </label>  
                        <input id="long"   type="text" name="longitudCine">   
                    </div>
                </div>               
            
            </div>
            <div class="col-50">                
                <div id="map"></div>
            </div>
          
        </div>
        <input type="submit">
      </form>
    </div>
    
  </div> 
  

</div>

 <script src="<?php echo(RUTA_URL) ?>/js/jquery-3.2.1.min.js"></script> 
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnnEXZOQHYy-LIZVjNOm6pTSatED60h8c&callback=initMap"></script>

 <script>

    $.myjQuery = function(a) {
        $("#lat").val(a.lat);
        $("#long").val(a.lng);
    };

    function initMap() {
    	console.log("hola mundo");
        var map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 15
        });

        // Try HTML5 geolocation.
        var pos = {
            lat: 0,
            lng: 0
        };
        var marker = new google.maps.Marker({

            position: pos,
            map: map,
            title: 'Hello World!',
            draggable: true
        });
        navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            marker.setPosition(pos);
            console.log(pos);

            $.myjQuery(pos);

            map.setCenter(pos);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });

        marker.addListener('dragend', function() {
            $.myjQuery(marker.getPosition());
        });

    }
    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
    }
    </script>
<?php require RUTA_APP.'/vistas/inc/footer.php'; ?>