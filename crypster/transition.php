<?php 
include "essential files/beforephp.php";//sets local/ live variables which are protocol domain subdomain1 dbname dbusername dbpassword and also checks if the user has logged in, if he has then retrieves the $user array.

if (isset($_COOKIE['session_id'])){//if cookie is set then the user is logged in

	include "logging in.php";

}
else{
	include "asklogin.php";
}

 ?>
