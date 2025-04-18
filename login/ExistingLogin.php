<?php //we do not include beforephp.php file as it will just redirect to this page which will lead to an infinite redirection loop
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


 ?><!DOCTYPE html>
<html>
<head>
	<title>Existing Login</title>
	 <link rel="stylesheet" href="styles.css">
<body background="henti.jpg"> 
	<style>

		body{
			background-size:cover;
			background-repeat: no-repeat;
		}
	</style>
	<div class = "credential-box" style = "height:max-content;">
		
			<h1>IONIZE</h1>
		
		<font size=6px>It appears you have logged in elsewhere.</font>
		<div class = "div-el-button">
			<?php $path = $protocol."://".$domain."/login/logout.php?session_id=".$_GET['session_id'] ;?> <!-- redirect to logout page with the session id obtained from the page before so that it can log that session ids user from the database, but not from the cookie set on the browser -->

			<a href = <?php echo $path; ?>> 
				<button class = "el-button" style = "margin-bottom: 0px;">
					<font color = white>Login</font>
				</button>
			</a>
		</div>
		<div style = "text-align: center; color: red; padding:0;">
			<font size=5px>*This will log you out from other devices and you'll be redirected to the main page.</font> 
		</div>
		<div class = "div-el-button">
			<?php $path =$protocol."://".$domain; ?> 
			<a href = <?php echo $path ?>> <!--Href for continue process-->
				<button class = "el-button">
					<font color =white>Continue without Log In</font>
				</button>
			</a>
		</div>
	</div>


</body>
</html>