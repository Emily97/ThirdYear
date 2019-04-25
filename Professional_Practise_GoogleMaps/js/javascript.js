var map, infoWindow, service;
function initMap() {
  // we define a Javascript function that creates a map in the div
  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat:53.294118, lng: -6.134221},
    zoom: 10,
    styles: [{
      stylers: [{visibility: 'simplified'}]
    }, {
      elementType: 'labels',
      stylers: [{ visibility: 'off'}]
    }]
  });
  infoWindow = new google.maps.InfoWindow;
  service = new google.maps.places.PlacesService(map);

  //The idle event is a debounced event, so we can query & listen without
  //throwing too many requests at the server.
  map.addListener('idle', performSearch);

  //Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      infoWindow.setPosition(pos);
      infoWindow.setContent('Location found.');
      infoWindow.open(map);
      map.setCenter(pos);

    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    });
  } else {
    //Browser doesn't support GeoLocation
    handleLocationError(false, infoWindow, map.getCenter());
  }
}

function handleLocationError(browserHasGeoLocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeoLocation ?
                        'Error: The Geolocation service failed.':
                        'Error: Your browser doesn\'t support geolocation.');
  infoWindow.open(map);
}

function performSearch() {
  var request = {
    bounds: map.getBounds(),
    keyword: 'best view'
  };
  service.radarSearch(request, callback);
}

function callback(results, status) {
  if (status !== google.maps.places.PlacesServiceStatus.OK) {
    console.error(status);
    return;
  }
  for (var i = 0, result; result = results[i]; i++) {
    addMarker(result);
  }
}

function addMarker(place) {
  var marker = new google.maps.Marker({
    map: map,
    position: place.geometry.location,
    icon: {
      url:'https://developers.google.com/maps/documentation/javascript/images/circle.png',
      anchor: new google.maps.Point(20,20),
      scaledSize: new google.maps.Size(15,24)
    }
  });

  google.maps.event.addListener(marker, 'click', function() {
    service.getDetails(place, function(result, status) {
      if (status !== google.maps.places.PlacesServiceStatus.OK) {
        console.error(status);
        return;
      }
      infoWindow.setContent(result.name);
      infoWindow.open(map, marker);
    });
  });
}
