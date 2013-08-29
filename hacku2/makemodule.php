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

echo '
<br><br><font color ="white" size="3"> Here you can edit your personal module</font><br>

<body bgcolor="#222222">

<br><h1 align="center" style="background-color:"><font color="#FFFFFF"><u>Make Your Own Module</font></u></h1><br><br>
<form name="event" action="makemodule.php" method="get">
<br><font size="4" color="#FFFFFF" >Event time (yyyy-mm-dd hh:ii:ss):</font><span style="padding: 0 21px">&nbsp;</span><input type="text" name="date"><br>
<br><font size="4" color="#FFFFFF" >Event Title :          </font><span style="padding: 0 98px">&nbsp;</span><input type="text" name="title"><br>
<br><font size="4" color="#FFFFFF" >Event Latitude:        </font><span style="padding: 0 88px">&nbsp;</span><input type="text" name="lat"><br>
<br><font size="4" color="#FFFFFF" >Event Longitude :      </font><span style="padding: 0 77px">&nbsp;</span><input type="text" name="long"><br>
<br><font size="4" color="#FFFFFF" >Event Description:     </font><span style="padding: 0 74px">&nbsp;</span><input type="text" name="desc"><br>
<br>                       <span style="padding: 0 110px">&nbsp;</span><input type="submit" value="Submit"><br>
</form>
</body>
';
 
if(isset($_GET['title']))
{
	
	$timestr=$_GET['date']." GMT";
	$time=strtotime($timestr);
	$title=$_GET['title'];
	$lat=$_GET['lat'];
	$long=$_GET['long'];
	$desc=$_GET['desc'];
	$filen="./users/".$auths[1]."personal.txt";
	$fp=fopen($filen,"a+");
	$towrite=$time.":".$title.":".$lat.":".$long.":".$desc.":\n";
	fwrite($fp,$towrite);
	echo '<br><font color="olive green" style="align:center" size="4">An event with title: '. $title.' has been successfully added to your personal module. Enter next event.</font>';
}
echo '

<br><br> 
<button type="button"><a href="home.php" target="_blank">I\'m done with entering events</a></button>
 <br><br>
 '
?>