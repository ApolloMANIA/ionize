<?php 
include "essentialfiles/beforephp.php";//sets local/ live variables which are protocol domain subdomain1 dbname dbusername dbpassword and also checks if the user has logged in, if he has then retrieves the $user array.
include "essentialfiles/important_functions.php";

$room_id = generateRandomString(5);//add code to check if this room id exists
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Secret Santa</title>
		<link rel="stylesheet" href="styles.css">

	</head>
	<body>
		<div class = "Logo">
            LOGO
        </div>
        <div style = "text-align: center;">
            <div style = "display: block;">
                <div class = "TEXT">
                    CREATE ROOM
                </div>
                <div class = "TEXT">
                    JOIN ROOM
                </div>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 50% 50%; text-align: center;">
		    <div class="i-box">
		        <button class="cr-button" onclick="redirectToCreate()"> Create a Room </button>
		    </div>
		    <div class="i-box" style='translate:7%'>
		        <div>
		            <input id="roomInput" class="inp" placeholder="Enter Room ID">
		        </div>
		        <div>
		            <input id="linkInput" class="inp" placeholder="Enter Link">
		        </div>
		        <button class="cr-button" onclick="redirectToJoin()" style='translate:-160%'> Join Room </button>
		    </div>
		</div>

	<script>
	    function redirectToCreate() {
	        window.location.href = 'create.php?room_id=<?php echo $room_id?>';
	    }

	    function redirectToJoin() {
	        var roomID = document.getElementById('roomInput').value;
	        var link = document.getElementById('linkInput').value;

	        // Check if Room ID is provided, else use the Link
	        var destination = roomID.trim() !== '' ? 'create.php?room_id=' + roomID : link;

	        window.location.href = destination;
	    }
</script>

	</body>
	</html>

