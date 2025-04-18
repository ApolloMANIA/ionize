<?php 
require_once 'beforephp.php';
$host ='localhost';
$dbname = $dbnamess;
$username =$dbusernamess;
$password =$dbpassword;

$ssdb= new mysqli(hostname:$host,
					username:$username,
					password:$password,
					database:$dbnamess);
if($ssdb-> connect_errno){
	die("Connection error: ".$ssdb->connect_error);
}
return $ssdb;



 ?>