<?php 
include "essentialfiles/beforephp.php";//sets local/ live variables which are protocol domain subdomain1 dbname dbusername dbpassword and also checks if the user has logged in, if he has then retrieves the $user array.

if (isset($_COOKIE['session_id'])){//if cookie is set then the user is logged in

	header('Location: index.php');
}
else{
	
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Please log in</title>
		<link rel="stylesheet" href="styles.css">

	</head>
	<body>
		<div class="translucent-box">
			<font class='black-text'>Please log in to be able to access Secret Santa</font>
			<br>
			<button class="black-button" onclick="redirectToLogin()">Go to Login</button>

			<script>
				<?php $path = $protocol."://".$domain."/login/login.php?mode=SecretSanta" ;?>
			    function redirectToLogin() {
			        window.location.href = '<?php echo $path; ?>';
			    }
			</script>
		</div>

	
	</body>
	</html>


<?php
}//end of else

 ?>
