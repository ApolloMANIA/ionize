<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//code to set local/live variables
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$environment = 'local'; // Set the environment variable to 'local' for local development

$host = $_SERVER['HTTP_HOST'];
if (strpos($host, 'ionize.fun') !== false) {
    $environment = 'live'; // Set the environment variable to 'live' for the live web host
}

if ($environment === 'local') {
	// Read the configuration file
	$configFile = "http://localhost/essentialfiles/config_local.txt";
	$configData = file($configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	// Process each line in the configuration file
	foreach ($configData as $line) {
	    // Split the line into key and value
	    list($key, $value) = explode('=', $line, 2);

	    // Trim leading/trailing whitespace
	    $key = trim($key);
	    $value = trim($value);

	    // Set the variable dynamically
	    if (!empty($key)) {
	        $$key = $value;
	    }
	}

} elseif ($environment === 'live') {
    $configFile = "https://ionize.fun/essentialfiles/config_live.txt";
	$configData = file($configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	// Process each line in the configuration file
	foreach ($configData as $line) {
	    // Split the line into key and value
	    list($key, $value) = explode('=', $line, 2);

	    // Trim leading/trailing whitespace
	    $key = trim($key);
	    $value = trim($value);

	    // Set the variable dynamically
	    if (!empty($key)) {
	        $$key = $value;
	    }
	}
}




//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//code to set $user variable and check if the user has logged in
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$mysqli= require 'database.php';


//if cookie is set that means that user has logged in.
//if cookie is set and user is not found in the database that means the session id has changed and the user has logged in elsewhere
if(isset($_COOKIE['session_id'])){
  $session_id=$_COOKIE['session_id'];
  //code to fetch user assoc array
  $sql = sprintf("SELECT * FROM user 
      WHERE session_id ='%s'",
      $mysqli->real_escape_string($session_id));
  $result = $mysqli->query($sql);
  $user = $result ->fetch_assoc();


  if(!$user && $session_id &&strpos($_SERVER['REQUEST_URI'], 'logout') == false){ //if user is not found in database while session id exists as cookie and it is't part of a logout process
    $path = $protocol."://".$domain."/login/Existinglogin.php?session_id=".$session_id;
    header("Location: ".$path);
    exit();

  }
}

?>