var locations = [
    [
        "SupeCarLoans - 10212 178 Street, Edmonton, AB Canada T5S 1H3",
        53.543938,
        -113.6301377,
        1,
        "SupeCarLoans",
        "",
        "10212 178 Street, Edmonton, AB Canada T5S 1H3",
        
    ]
]

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      // center: new google.maps.LatLng(-33.92, 151.25),
      center: new google.maps.LatLng(53.543938,-113.6301377),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0], locations[i][6]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }