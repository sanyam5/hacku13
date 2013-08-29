<?php

$authval=$_COOKIE['auth'];
if(!$authval)

{
	header("Location:signin.html");
	die();
}
$auths=explode("::",$authval);
if($auths[0]!="valid")
{
	header("Location:signin.html");
	die();
}

echo "You are signed in as, ".$auths[1];


//$files=scandir("./modules/");
 $valu="users/".$auths[1].".txt";
$modulen=fopen($valu,"r");
$files = array();
$k=0;

while($temp=fgets($modulen,4096))
{
	$temp2=explode("::",$temp);
	$files[$k]=$temp2[0];
	$k++;
}
$now=strtotime("now");
if(isset($_GET['days']))
 $offstr="1970-01-".($_GET['days']+1)."  ".$_GET['hours'].":00:00 GMT";
else 
{
	$offstr="1970-01-".(0+1)."  ".(23).":00:00 GMT";
}
$offset=strtotime($offstr);
//echo "offset is".$offset;
$events = array();
$i=0;

//echo "now=".$now. "  now+offset=".($now+$offset)."<br>";
$t=0;
foreach($files as $filen)

{
	
	if($t!=0)
	$filen="./modules/".$filen;
	//echo $filen;
	$fp=fopen($filen,'r');
	
	
  while( $str = fgets($fp, 4096))
  {    
 
 //echo $str."<br>";
    // Do something with $str
     $fields=explode(':',$str);
    if($fields[0]>$now&&$fields[0]<$now+$offset)
    {    	
    $events[$i]=$str;
   
    	 $i++;
    }
  }
  fclose($fp);
  $t++;
}

function compareOrder($a, $b)
{
  return $a[0] - $b[0];
}

usort($events, 'compareOrder');
foreach($events as $event)
{
	$field=explode(':',$event);
	//echo $field[1];
}


echo '
<!DOCTYPE html>
<html>
  <head>
    <title>Google Maps JavaScript API v3 Example: Map Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link href="https://google-developers.appspot.com/maps/documentation/javascript/examples/default.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
    <script>
      var map;
      var pos;
      var directionDisplay;
      var directionsService = new google.maps.DirectionsService();
      function initialize()
       {
        directionsDisplay = new google.maps.DirectionsRenderer();
        var mapOptions = {
          zoom: 16,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById(\'map_canvas\'),
            mapOptions);
        directionsDisplay.setMap(map);
        // Try HTML5 geolocation
        if(navigator.geolocation)
         {
          navigator.geolocation.getCurrentPosition(function(position) {
            pos = new google.maps.LatLng(position.coords.latitude,
                                             position.coords.longitude);

            var infowindow = new google.maps.InfoWindow({
              map: map,
              position: pos,
              content: \'You Are Here.\'
            });

            map.setCenter(pos);
          }, function() {
            handleNoGeolocation(true);
          });
        } 
        else {
          // Browser doesn\'t support Geolocation
          handleNoGeolocation(false);
        }
        
        var beach_name =new Array();
         var lat =new Array();
          var longi =new Array();
         var n='.count($events).';';
         $q=0;
         foreach($events as $field)
        { 
        $event=explode(':',$field);
        
        echo '   beach_name['.$q.']="'.$event[1] .'";'; 
        echo '  lat['.$q.']='.$event[2]. ';';
        echo '  longi['.$q.']='.$event[3]. ';';
       
       $q++;
       }
       echo'
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
       function calcRoute(end) {
        var start =pos;
        //var end = new google.maps.LatLng(22.316294,87.297750);
        var request = {
            origin:start,
            destination:end,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {
          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
          }
        });
      }
      function attachSecretMessage(marker, num) {
      	var message = new Array();
    	';
      	   $q=0;
         foreach($events as $field)
        { 
        $event=explode(':',$field);
        
        echo '   message['.$q.']="'.$event[4]."<br>DATE:".date("Y-m-d ",$event[0])."<br>TIME:".date("H:i:s",$event[0]) .'";'; 
       $q++;
       }
        
echo'        
        var infowindow = new google.maps.InfoWindow({
          content: message[num]
        });

        google.maps.event.addListener(marker, \'mouseover\', function() {
          infowindow.open(marker.get(\'map\'), marker);
        });
google.maps.event.addListener(marker,\'mouseout\',function(){
 infowindow.close(marker.get(\'map\'), marker);});
google.maps.event.addListener(marker,\'click\',function(){
 calcRoute(marker.position);});
      }


      function handleNoGeolocation(errorFlag)
       {
        if (errorFlag) {
          var content = \'Error: The Geolocation service failed.\';
        } else {
          var content = \'Error: Your browser doesnt support geolocation.\';
        }

        var options = {
          map: map,
          position: new google.maps.LatLng(60, 105),
          content: content
        };

        var infowindow = new google.maps.InfoWindow(options);
        map.setCenter(options.position);
      }

      google.maps.event.addDomListener(window, \'load\', initialize);
    </script>
  </head>
  <body> <div id="map_canvas" style="width: 1000px; height:470px; float:bottom">map div</div>
 </body>
</html>
';
?>
