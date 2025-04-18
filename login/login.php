<?php 
require_once '../essentialfiles/beforephp.php';//sets local/ live variables which are protocol domain subdomain1 dbname dbusername dbpassword and also checks if the user has logged in, if he has then retrieves the $user array.
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//random string generator function
function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomString = '';

  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $randomString;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//if session already exists(before the log in button is clicked, so server doesn't know who is logging in)
if(isset($_COOKIE['session_id'])){
	$mysqli= require __DIR__."/database.php";
	$session_id=$_COOKIE['session_id'];
	$sql = sprintf("SELECT * FROM user 
	    WHERE session_id ='%s'",
	    $mysqli->real_escape_string($session_id));
	$result = $mysqli->query($sql);
	$user = $result ->fetch_assoc();

	if($user){ //if user exists with the current session id
		echo "<h2>Note that you are currently logged in as ".$user['username'].". <font color=red>Logging in now will log you out of that account.</font></h2>";


	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//log in button is clicked
$is_invalid = false;//$is_invalids default value is set to false(a variable to determine if log in credentitals are correct, is later used in html do show invalid login message)

if($_SERVER["REQUEST_METHOD"]==="POST"){//when login button is clicked
	$mysqli= require __DIR__."/database.php";
	$sql = sprintf("SELECT * FROM user 
			WHERE email ='%s'",
			$mysqli->real_escape_string($_POST["email"]));
	$result = $mysqli->query($sql);
	$user = $result ->fetch_assoc();
	if(!$user){// if user wasn't found using email
		$sql = sprintf("SELECT * FROM user 
				WHERE username ='%s'",
				$mysqli->real_escape_string($_POST["email"]));// since they are sent from the same field
		$result = $mysqli->query($sql);
		$user = $result ->fetch_assoc();

	}
	if($user){//check if user exists with that email
		if(password_verify($_POST["password"],$user["password_hash"]) ) {//check if password is correct

			///////if mode is set in the url then set it to $mode else set it to null to prevent any mishandling of $mode
			if(isset($_GET['mode'])){
				$mode = $_GET['mode'];
			}
			else{
				$mode=null; 
			}
			///////////////////////////////////////////////




			///////////////////////////////////////////////////////////////////
			//code to see if user is already logged in
			if($user['session_id']!==null){ //if the session id is already set in the database for this user (he has logged in elsewhere)
			  $path = "Existinglogin.php?session_id=".$user['session_id'];
			  header("Location: ".$path); //then send to existing login page with the session id 
			  //the session id is sent to existing login page so that it can pass it to logout page which will logout that user from the database using that session id
			  exit();//exit so that the code ahead doesn't get executed 
			}
			//////////////////////////////////////////////////////////////////




			////////////////////////////////////////////////////////////////////
			//if the user hasn't logged in elsewhere
			$session_id = generateRandomString(10);//generating session_id
			// Set the cookie to last for 10 years 
			$expiration_time = time() + (10 * 365 * 24 * 60 * 60); // 10 years in seconds
			// Set the httponly cookie on the subdomain with a long expiration time
			setcookie("session_id", $session_id, $expiration_time, '/', $_SERVER['HTTP_HOST'], false, true);
			$email = $user['email'];// making $email variable so that it is easy to concatenate
			$sqlQuery = "UPDATE user SET session_id = '$session_id' WHERE email = '$email'";//statement to add session_id to database
			$mysqli->query($sqlQuery);//add session_id to database
			$path_to_subdomain1 = $protocol."://".$subdomain1.".".$domain."/loading.php?session_id=".$session_id."&mode=".$mode;//redirect to all subdomains so that they can set their cookies and also the mode so that it can redirect to the most convenient page
			header("Location: ".$path_to_subdomain1);

					}
			}
	$is_invalid = true;// if everything goes smoothely then this becomes true and user can login
		}

?>



<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	 <link rel="stylesheet" href="styles.css">
	 <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
</head>
<body>
<h1>Log in</h1>
<h2 id="orLogin">OR <a href="signup.html"> Sign up</a></h2>
<h2>Ionize.fun</h2>

<form method='POST'>
<div class="credential-box">
	<div id='email-div'>
		<?php if($is_invalid):?><!-- if invalid then show this 
 -->	<em><font class ='label-red'>Invalid login</font></em>
 			<div class='submit-button-div'>
				<a class='submit-button' href='forgot-password.php'>Forgot password</a>
			</div>

<?php endif;?>
		<label for='email'><font class='label-black'>Email or Username: </font> 
</label> <input type='text' id = 'email' class='one-line-text-input' name='email' value ="<?=$_POST['email'] ?? ''?>">
	</div>
	
	<div id="emailSuggestions"></div><!--  email suggestions -->
	<script src='script.js'></script> <!-- javascript to suggest emails -->
	<div id='password-div'>
		<label for='password'><font class='label-black'>Password:</font></label> <input type='password' id = 'password' class='one-line-text-input' name='password'>
	</div>


	<div class='submit-button-div'>
		<button class='submit-button'>Log in</button>
	</div>



</div>
</form>
</body>
</html>