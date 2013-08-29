<?php
echo "This is home .php";
$authval=$_COOKIE['auth'];
$auths=explode("::",$authval);

if($auths[0]=="valid")
echo" You are signed in as, " .$auths[1];

else 
echo file_get_contents("signin.html");
?>