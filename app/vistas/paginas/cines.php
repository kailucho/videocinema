<?php require RUTA_APP.'/vistas/inc/header_user.php'; ?>

<style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */

    #map {
        height: 80%;
        width: 100%;
        position: relative; /* has to be position relative for left to work, or you could just do margin-left: -50px; too */
       
        z-index: 100;
    }
    /* Optional: Makes the sample page fill the window. */
  #pano {
        width: 150px;
        height: 150px;
      }

  #floating-panel {
    position: absolute;
    top: 130px;
    right: 5%;
    z-index: 102;
    background-color: #fff;
    padding: 5px;
    border: 1px solid #999;
    text-align: center;
    font-family: 'Roboto','sans-serif';
    line-height: 30px;
    padding-left: 10px;
  }
   
</style>

<h1> ESTOS SON LOS CINES MAS CERCANOS</h1>
<div id="floating-panel">
  <input id="address" type="textbox" value="puno">
  <input id="submit" type="button" value="Geocode">
</div>
<div id="map"></div>
    <script>
    	var markers = [];
		
      function initMap() {
        // Create a styles array to use with the map.
        var styles = [
  {
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#8ec3b9"
      }
    ]
  },
  {
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1a3646"
      }
    ]
  },
  {
    "featureType": "administrative.country",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#4b6878"
      }
    ]
  },
  {
    "featureType": "administrative.land_parcel",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#64779e"
      }
    ]
  },
  {
    "featureType": "administrative.province",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#4b6878"
      }
    ]
  },
  {
    "featureType": "landscape",
    "stylers": [
      {
        "lightness": -100
      }
    ]
  },
  {
    "featureType": "landscape.man_made",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#334e87"
      }
    ]
  },
  {
    "featureType": "landscape.natural",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#023e58"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#283d6a"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#6f9ba5"
      }
    ]
  },
  {
    "featureType": "poi",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#023e58"
      }
    ]
  },
  {
    "featureType": "poi.park",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#3C7680"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#304a7d"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#98a5be"
      }
    ]
  },
  {
    "featureType": "road",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#2c6675"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "geometry.stroke",
    "stylers": [
      {
        "color": "#255763"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#b0d5ce"
      }
    ]
  },
  {
    "featureType": "road.highway",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#023e58"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#98a5be"
      }
    ]
  },
  {
    "featureType": "transit",
    "elementType": "labels.text.stroke",
    "stylers": [
      {
        "color": "#1d2c4d"
      }
    ]
  },
  {
    "featureType": "transit.line",
    "elementType": "geometry.fill",
    "stylers": [
      {
        "color": "#283d6a"
      }
    ]
  },
  {
    "featureType": "transit.station",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#3a4762"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      {
        "color": "#0e1626"
      }
    ]
  },
  {
    "featureType": "water",
    "elementType": "labels.text.fill",
    "stylers": [
      {
        "color": "#4e6d70"
      }
    ]
  }
];
      	var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer({
          polylineOptions: {
            strokeColor: "red"            
          },
          suppressMarkers: true
        });

      		
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: new google.maps.LatLng(-15.83, -70.02),
          styles: styles,
        });
        var geocoder = new google.maps.Geocoder();

        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
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
            var marker = new google.maps.Marker({
              map: map,
              position: pos,
              animation: google.maps.Animation.DROP,
              icon:"https://maps.google.com/mapfiles/kml/shapes/parking_lot_maps.png",
              draggable: true
            });
            markers.push(marker);
            marker.addListener('dragend', function() {
              marcador_cercano(this.getPosition());
            });

            console.log(pos);

           setMarker(pos);
           marcador_cercano(new google.maps.LatLng(pos));

            
            
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
          animation: google.maps.Animation.DROP,
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
		    for (i = 1; i < markers.length; i++) {
		        var d = google.maps.geometry.spherical.computeDistanceBetween(markers[i].position,mylat);
		        distances[i] = d;
            console.log("iniPos ");
            console.log("distance are "+d);
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
            travelMode: 'WALKING',
            provideRouteAlternatives: true,
            //unitSystem: google.maps.UnitSystem.METRIC,
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
      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            /*var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });*/
            markers[0].setPosition(results[0].geometry.location);
            marcador_cercano(results[0].geometry.location);

          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }




      }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnnEXZOQHYy-LIZVjNOm6pTSatED60h8c&libraries=geometry&callback=initMap">
    </script>

<?php require RUTA_APP.'/vistas/inc/footer.php'; ?>