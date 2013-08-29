<!DOCTYPE html>
<html>
  <head>
    <title>Google Maps JavaScript API v3 Example: Map Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link href="https://google-developers.appspot.com/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <!--
    Include the maps javascript with sensor=true because this code is using a
    sensor (a GPS locator) to determine the user's location.
    See: https://developers.google.com/apis/maps/documentation/javascript/basics#SpecifyingSensor
    -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>

    <script>
      var map;

      function initialize()
       {
        var mapOptions = {
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById('map_canvas'),
            mapOptions);

        // Try HTML5 geolocation
        if(navigator.geolocation)
         {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = new google.maps.LatLng(position.coords.latitude,
                                             position.coords.longitude);

            var infowindow = new google.maps.InfoWindow({
              map: map,
              position: pos,
              content: 'You Are Here.'
            });

            map.setCenter(pos);
          }, function() {
            handleNoGeolocation(true);
          });
        } 
        else {
          // Browser doesn't support Geolocation
          handleNoGeolocation(false);
        }
         var n=3;
       var beach_name=['tata sports complex','tsg','tennis court'];
       var lat=[22.315322,22.315897,-22.319748];
       var longi=[87.308693,87.303586,87.301161];
       var beaches = new Array();
       for(var i=0;i<n;i++)
       {
        beaches[i]=[beach_name[i],lat[i],longi[i],n-i];
       }
        for (var i = 0; i < n; i++) {
          var position = new google.maps.LatLng(lat[i],longi[i]);
          var marker = new google.maps.Marker({
            position: position,
            title:beach_name[i],
            map: map
          });

          //marker.setTitle((i + 1).toString());
          attachSecretMessage(marker, i);
        }
      }
      function attachSecretMessage(marker, num) {
        var message = ['This event number oneis happening in tsc', 'event number 2 is happening in technology guest house', 'event number three in tennnis court'];
        var infowindow = new google.maps.InfoWindow({
          content: message[num]
        });

        google.maps.event.addListener(marker, 'mouseover', function() {
          infowindow.open(marker.get('map'), marker);
        });
google.maps.event.addListener(marker,'mouseout',function(){
 infowindow.close(marker.get('map'), marker);});
      }


      function handleNoGeolocation(errorFlag)
       {
        if (errorFlag) {
          var content = 'Error: The Geolocation service failed.';
        } else {
          var content = 'Error: Your browser doesn\'t support geolocation.';
        }

        var options = {
          map: map,
          position: new google.maps.LatLng(60, 105),
          content: content
        };

        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
      }

      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
  <div id="map_canvas" style="width: 940px; height:440px; float:bottom">map div</div>
  </body>
</html>
