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

//echo "You are signed in as, ".$auths[1];


//$files=scandir("./modules/");
$modulen=fopen("users/".$auths[1].".txt","r");
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
	if($t)
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
	$tempa=explode(':',$a);
	$tempb=explode(':',$b);
  return $tempa[0] - $tempb[0];
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
    	<title>TV Listings</title>
			<meta name="viewport" content="width=100, initial-scale=1, maximum-scale=1, user-scalable=no,float = right">

    	<script src="src/libs/jquery-1.7.1.js"></script>
    	<script src="src/libs/jquery.animate-enhanced.js"></script>
    	<script src="src/libs/iscroll.js"></script>
    	<script src="src/libs/noClickDelay.js"></script>
        <script type="text/javascript" src="libs/jquery.address-1.4.js"></script>

    	
    	<link rel="stylesheet" href="src/viewnavigator/viewnavigator.css" type="text/css" />
    	<script src="src/viewnavigator/viewnavigator.js"></script>

    	<style>
    		
    		body,ul,li,header,nav,aside,section,article,p,a {
          padding: 0;
          margin: 0;
          border: 0;
		  left = 0px;
        }

        body {
          font: normal 1.25em Helvetica;
          background: #333;
        }

        object {
          -webkit-overflow-scrolling: touch;
        }

        #iframeWrapper {
          width: -50%;
          height: 100%;
          overflow: scroll;
          -webkit-overflow-scrolling: touch;
        }

        iframe {
          width: -50%;
          min-height: 100%;
          background-color: rgba(0,0,0,0);
          border: 0;
          overflow: scroll;
          -webkit-overflow-scrolling: touch;
        }

		#leftHalf {
		background: url("./assets/header_bg_wood.png");
		background-color: #333;
		width: -50%;
		width: -50%;
		position: absolute;
		left: 0px;
		 height: 100%;
		 font: bold 1em Helvetica;
		}
        
        .viewNavigator_content {
          border-top: 2px solid #666;
          background-color: #333;
        }

        .viewNavigator_contentHolder {
          background-color: #333;
        }

        .viewNavigator_header_title {
          max-width: -50%;
          text-shadow: 1px 2px #777;
        }

        .headerButton {
          -webkit-box-shadow: inset 0px 1px 0px 0px #999;
          box-shadow: inset 0px 1px 0px 0px #999;
          background-color: rgba(128,128,128,0.65);
          border-radius: 6px;
          border: 1px solid #777;
          display: inline-block;
          color: #ffffff;
          font-family: arial;
          font-size: 15px;
          font-weight: bold;
          padding: 6px 24px;
          text-decoration: none;
          text-shadow: 1px 1px 0px #736d73;
          padding: 6px;
          padding-top: 5px;
          padding-bottom: 4px;
        }

        .headerButton:active {
          position: relative;
          top: 1px;
        }

        .listItem {
          padding: 0 10px;
          background-color: #222;
          color: white;
          border-bottom: 1px solid #888;
          border-bottom: 1px solid #444;
          height: 40px;
          line-height: 40px;
          font-weight: bold;
          cursor: pointer;
          text-shadow: 1px 2px #777;
          display: block;
          text-decoration: none;
        }

        .oddRow {
          background-color: #333;
        }

        .listSelected {
          background: #015FE6;
          background-color: #015FE6;
          color: #FFF;
          font-weight: bold;
        }

    		
    	</style>
    	
		<script>
            // jQuery Address Event handlers
            $.address.externalChange(function(event) {
                var text = event.value.substr(1);
               
                if ( text.length > 0 ) {
                //	loadView( text );
';         
echo '
	var n=text.substr(0,1);';       
		$y=0;
foreach($events as $event)
{
	$field=explode(':',$event);
	echo '	
	if(n=='.$y.') loadView'.$y.'(text);	
	';
	$y++;
}

                
           echo'	window.defaultView.find("a").each(function(i){
						var $this = $(this);
						if ($this.text() == text ) {
							$this.addClass( "listSelected" );
						}
					});
                	$(this).addClass( "listSelected" );
                }
                else {        
					resetList();
                	window.viewNavigator.popView();
					$.address.value("");
                }
            });



			$(document).ready( function() {
				
				//Setup the default view
				var template = $("#defaultViewTemplate").html();
				window.defaultView = $(template);
				
				defaultViewDescriptor = { title: "Upcoming Events", 
						 view: window.defaultView
					   };
				
				//Setup the ViewNavigator
				window.viewNavigator = new ViewNavigator( \'body\', \'headerButton\' );	
				window.viewNavigator.pushView( defaultViewDescriptor );
				
				
			});
			
			function loadView( title ) {
				
			 	var html = "<div style=\'min-height:100%; background:#FFF; padding: 3px 15px;\'><h1>" + title + "</h1><strong>Cable television</strong> is a system of providing television programs to consumers via radio frequency (RF) signals transmitted to televisions through coaxial cables or digital light pulses through fixed optical fibers located on the subscriber\'s property. This can be compared to over-the-air method used in traditional broadcast television (via radio waves) in which a television antenna is required. FM radio programming, high-speed Internet, telephony, and similar non-television services may also be provided through cable television. Source: <a href=\'http://en.wikipedia.org/wiki/Cable_tv\'>http://en.wikipedia.org/wiki/Cable_tv</a></div>";
			 	
			 	var iframeView = { title: title, 
			 					backLabel: "Home",
						 		view: $(html),
						 		backCallback: handleNavigateBack
					   		 };
				window.viewNavigator.pushView( iframeView );
			}
			
			function handleNavigateBack() { 
				resetList();
				history.back();
			}
			
			function resetList() { 
				window.defaultView.find("a").each(function(i){
					$(this).removeClass( "listSelected" );
				});
			}
			';
				$y=0;
foreach($events as $event)
{
	$field=explode(':',$event);
echo 'function loadView'.$y.'( title ) {
				
			 	var html = "<div style=\'min-height:100%; background:#FFF; padding: 3px 15px;\'><h1>" + title + "</h1><strong>Cable television</strong> is a system of providing television programs to consumers via radio frequency (RF) signals transmitted to televisions through coaxial cables or digital light pulses through fixed optical fibers located on the subscriber\'s property. This can be compared to over-the-air method used in traditional broadcast television (via radio waves) in which a television antenna is required. FM radio programming, high-speed Internet, telephony, and similar non-television services may also be provided through cable television. Source: <a href=\'http://en.wikipedia.org/wiki/Cable_tv\'>http://en.wikipedia.org/wiki/Cable_tv</a></div>";
			 	
			 	var iframeView = { title: title, 
			 					backLabel: "Home",
						 		view: $(html),
						 		backCallback: handleNavigateBack
					   		 };
				window.viewNavigator.pushView( iframeView );
			}
			
			function handleNavigateBack() { 
				resetList();
				history.back();
			}
			
			function resetList() { 
				window.defaultView.find("a").each(function(i){
					$(this).removeClass( "listSelected" );
				});
			}
			';
			$y++;
}
echo'
		</script>

	</head>
	<body></body>
	
	<script type="text/html" id="defaultViewTemplate" style="width: 1000px; height: 600px;">
	  <ul>
	';
	$q=0;
foreach($events as $event)
{
	$field=explode(':',$event);
	echo '<a class="listItem oddRow" href="home.php#'.$q.".". $field[1].'" target="_parent" >'.$q.".". $field[1].'</a>';
	$q++;
}	  
	  	
	echo'  </ul>
	</script>
</html
';
?>