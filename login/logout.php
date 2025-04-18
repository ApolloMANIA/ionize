<?php
require_once '../essentialfiles/beforephp.php';//sets local/ live variables which are protocol domain subdomain1 dbname dbusername dbpassword and also checks if the user has logged in, if he has then retrieves the $user array.



/////////////////////////////////////////////////////////////////////////////////////////////////////////
///if this code is run it means that user has been redirected from the existing login page and it is supposed to delete the session id from the database
if (isset($_GET['session_id'])) {
	   //code to access the $user array since the code in beforephp.php sets it using cookie and it was not set
	$mysqli= require __DIR__."/database.php";

	$sql = sprintf("SELECT * FROM user 
	    WHERE session_id ='%s'",
	    $mysqli->real_escape_string($_GET['session_id']));
	$result = $mysqli->query($sql);
	$user = $result ->fetch_assoc();
	$email = $user['email'];
	
	$sql = "UPDATE user SET session_id = NULL WHERE email = '$email'";//we use email to identify which session id to delete since using session_id was not working 
	
	$mysqli->query($sql);
	
    
    $session_id=null;//remove the session_id variable just in case 
	
} 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if (isset($_COOKIE['session_id'])) {
	   //code to set session id to null in the database
	$mysqli= require __DIR__."/database.php";

	$sql = sprintf("SELECT * FROM user 
	    WHERE session_id ='%s'",
	    $mysqli->real_escape_string($_COOKIE['session_id']));
	$result = $mysqli->query($sql);
	$user = $result ->fetch_assoc();
	$email = $user['email'];
	
	$sql = "UPDATE user SET session_id = NULL WHERE email = '$email'";
	
	$mysqli->query($sql);
	
    
    $session_id=null;
	


    // Set the expiration time in the past (1 second ago) to remove the cookie
    setcookie('session_id', '', time() - 1, '/', $_SERVER['HTTP_HOST'], false, true);

   


}


$path_to_subdomain1 = $protocol."://".$subdomain1.".".$domain."/loading.php?logout=yes"."&mode=".$mode;//need to delete cookies from the browser, logout variable is declared because the loading.php file performs two functions:1)sets the cookies in all subdomains 2) deletes the cookies in all the subdomains, we want now to delete the cookies.
header("Location: ".$path_to_subdomain1);
exit;
 ?>