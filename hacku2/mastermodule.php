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
  $t++;
  fclose($fp);
}

function compareOrder($a, $b)
{
  return $a[0] - $b[0];
}

usort($events, 'compareOrder');
foreach($events as $event)
{
	$field=explode(':',$event);
	echo $field[1];
}

?>