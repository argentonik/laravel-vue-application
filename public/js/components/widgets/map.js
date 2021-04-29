var coordinates = {lat: 50.4500336, lng: 30.5241361};

var mapOptions = {
    zoom: 12, 
    center: coordinates,
    draggableCursor: 'default'
}


function initMap() {
    var latInput = document.getElementById('latitude');
    var lngInput = document.getElementById('longitude');
    if (latInput.value && lngInput.value) {
        //if is coordinates from server set it to map
        coordinates.lat = Number.parseFloat(latInput.value);
        coordinates.lng = Number.parseFloat(lngInput.value);
    }

    var map = new google.maps.Map(
        document.getElementById('map'), mapOptions);

    if (document.getElementById('edit-card') || document.getElementById('create-card')) {
        google.maps.event.addListener(map, 'click', function(e) {
            if ( !marker ) {
                marker = new google.maps.Marker({ map: map });
            }
            marker.setPosition(e.latLng);
            latInput.value = e.latLng.lat().toFixed(7);
            lngInput.value = e.latLng.lng().toFixed(7);
        });
    }

    var marker = new google.maps.Marker({position: coordinates, map: map});
}

$(document).ready(function () {
    google.maps.event.addDomListener(window, 'load', initMap);
});
