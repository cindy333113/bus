<!DOCTYPE html>
<html>
  <head>
    <style>
      #map {
        height: 400px;
        width: 100%;
       }
    </style>
  </head>
  <body>
    <h3>My Google Maps Demo</h3>
    <div id="map"></div>
    <script>

    var map;
function initMap() {}
    // 載入路線服務與路線顯示圖層
    var directionsService = new google.maps.DirectionsService();
    var directionsDisplay = new google.maps.DirectionsRenderer();

    // 初始化地圖
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 16,
        center: { lat: 25.034010, lng: 121.562428 }
    });

    // 放置路線圖層
    directionsDisplay.setMap(map);

    // 路線相關設定
    var request = {
    origin: { lat: 25.057448, lng: 121.557726 },
    destination: { lat: 25.048067, lng: 121.517475 },
    travelMode: 'TRANSIT',
    transitOptions: {modes:['BUS']}
};

    // 繪製路線
    directionsService.route(request, function (result, status) {
        if (status == 'OK') {
            // 回傳路線上每個步驟的細節
            console.log(result.routes[0].legs[0].steps);
            directionsDisplay.setDirections(result);
        } else {
            console.log(status);
        }
    });
}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWniij60ACTs6Ewx5ucvj3N6vi3jmnjlY&callback=initMap">
    </script>
  </body>
</html>