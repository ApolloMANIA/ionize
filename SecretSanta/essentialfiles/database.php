<?php 
require_once 'beforephp.php';
$host ='localhost';
$dbname = $dbname;
$username =$dbusername;
$password =$dbpassword;

$mysqli= new mysqli(hostname:$host,
					username:$username,
					password:$password,
					database:$dbname);
if($mysqli-> connect_errno){
	die("Connection error: ".$mysqli->connect_error);
}
return $mysqli;

 ?>
