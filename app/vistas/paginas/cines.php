<?php require RUTA_APP.'/vistas/inc/header_user.php'; ?>

<style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */

    #map {
        height: 80%;
        width: 50%;
        position: relative; /* has to be position relative for left to work, or you could just do margin-left: -50px; too */
       
        z-index: 100;
    }
    /* Optional: Makes the sample page fill the window. */
  #pano {
        width: 150px;
        height: 150px;
      }
   
</style>

<h1> ESTOS SON LOS CINES MAS CERCANOS</h1>

<div id="map"></div>
    <script>
    	var markers = [];
		
      function initMap() {
      	var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
      		
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: new google.maps.LatLng(-15.83, -70.02)
        });
        directionsDisplay.setMap(map); 
    	
    	//infowindow.unbind('position');
    	

    	 //HTML GEOLOCALITATION

        
          navigator.geolocation.getCurrentPosition(function(position) {
            pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };     
            map.setCenter(pos);            
            console.log(pos);

           setMarker(pos);
           marcador_cercano(pos);

            
            
          }, function() {
              handleLocationError(true, infoWindow, map.getCenter());
          });  
               
        //END OF HTML 	LOCALITATION

    	function setMarker(pos){
         <?php 
          
          foreach($datos['cines'] as $cines){

         ?>       

         
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(<?php echo $cines->latitudCine.",".$cines->longitudCine; ?>),
          map: map,
          title: '<?php echo $cines->nombreCine;  ?>'
        });
        markers.push(marker);

        marker.addListener('click', function() {
            calculateAndDisplayRoute(directionsService, directionsDisplay,this,pos);
        });

        var largeInfowindow = new google.maps.InfoWindow();
        marker.addListener('mouseover', function() {
            populateInfoWindow(this, largeInfowindow)
        });

        <?php } ?>
      }

    	function marcador_cercano(mylat){
			var distances = [];
		    var closest = -1;
		    for (i = 0; i < markers.length; i++) {
		        var d = google.maps.geometry.spherical.computeDistanceBetween(markers[i].position,new google.maps.LatLng(mylat));
		        distances[i] = d;
		        if (closest == -1 || d < distances[closest]) {
		            closest = i;
		        }
    		}
   		 //console.log('Closest marker is: ' + markers[closest].getTitle());
   		 //console.log(markers[closest].position);
   		 //console.log(new google.maps.LatLng(-15.83, -70.08));
   		 calculateAndDisplayRoute(directionsService, directionsDisplay,markers[closest],mylat);

		}
		function calculateAndDisplayRoute(directionsService, directionsDisplay,marker,myposition) {          
          directionsService.route({
            origin: myposition,
            destination: marker.getPosition(),
            travelMode: 'DRIVING'
          }, function(response, status) {
            if (status === 'OK') {
              directionsDisplay.setDirections(response);
            } else {
              window.alert('Directions request failed due to ' + status);
            }
          });
    }

    function populateInfoWindow(marker, infowindow) {
        // Check to make sure the infowindow is not already opened on this marker.
        if (infowindow.marker != marker) {
          // Clear the infowindow content to give the streetview time to load.
          infowindow.setContent('');
          infowindow.marker = marker;
          // Make sure the marker property is cleared if the infowindow is closed.
          infowindow.addListener('closeclick', function() {
            infowindow.marker = null;
          });
          var streetViewService = new google.maps.StreetViewService();
          var radius = 50;
          // In case the status is OK, which means the pano was found, compute the
          // position of the streetview image, then calculate the heading, then get a
          // panorama from that and set the options
          function getStreetView(data, status) {
            if (status == google.maps.StreetViewStatus.OK) {
              var nearStreetViewLocation = data.location.latLng;
              var heading = google.maps.geometry.spherical.computeHeading(
                nearStreetViewLocation, marker.position);
                infowindow.setContent('<div>' + marker.title + '</div><div id="pano"></div>');
                var panoramaOptions = {
                  position: nearStreetViewLocation,
                  pov: {
                    heading: heading,
                    pitch: 30
                  }
                };
              var panorama = new google.maps.StreetViewPanorama(
                document.getElementById('pano'), panoramaOptions);
            } else {
              infowindow.setContent('<div>' + marker.title + '</div>' +
                '<div>No Street View Found</div>');
            }
          }
          // Use streetview service to get the closest streetview image within
          // 50 meters of the markers position
          streetViewService.getPanoramaByLocation(marker.position, radius, getStreetView);
          // Open the infowindow on the correct marker.
          infowindow.open(map, marker);
        }
      }




      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnnEXZOQHYy-LIZVjNOm6pTSatED60h8c&libraries=geometry&callback=initMap">
    </script>

<?php require RUTA_APP.'/vistas/inc/footer.php'; ?>