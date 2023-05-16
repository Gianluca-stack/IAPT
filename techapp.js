function NewsPage(){
   window.location.href = 'news.php';
}

function HomePage(){
   window.location.href = 'index.php';
}

function initMap(lat, lng, city){

    var coordinates = {lat: lat, lng: lng};

    var mapOptions = {
        center: coordinates,
        zoom: 12
    };

    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var marker = new google.maps.Marker({
        position: coordinates,
        map: map,
        title: city  
    });

}

function getCityCoordinates() {
    var city = "Valletta"; // Replace with the desired city name
  
    // Create a Geocoder object
    var geocoder = new google.maps.Geocoder();
  
    // Geocode the city to retrieve its coordinates
    geocoder.geocode({ address: city }, function(results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        // Check if any results are returned
        if (results.length > 0) {
          // Extract the latitude and longitude from the first geocoding result
          var latitude = results[0].geometry.location.lat();
          var longitude = results[0].geometry.location.lng();
  
          // Check if the coordinates are valid
          if (isValidCoordinate(latitude) && isValidCoordinate(longitude)) {
            initMap(latitude, longitude, city);
          } else {
            console.log("Invalid coordinates for the city: " + city);
          }
        } else {
          console.log("No geocoding results found for the city: " + city);
        }
      } else {
        console.log("Geocode was not successful for the following reason: " + status);
      }
    });
  }
  
  function isValidCoordinate(coord) {
    return typeof coord === "number" && !isNaN(coord) && isFinite(coord);
  }
