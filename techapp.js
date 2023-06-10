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

