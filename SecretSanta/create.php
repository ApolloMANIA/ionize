<?php 
include "essentialfiles/beforephp.php";//sets local/ live variables which are protocol domain subdomain1 dbname dbusername dbpassword and also checks if the user has logged in, if he has then retrieves the $user array.
include "essentialfiles/important_functions.php";
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//code to set ssdb (secretsanta database) variables
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$ssdb= require 'essentialfiles/ssdb.php';

if (!isset($_GET['room_id'])){//if room id doesn't exist then just redirect to index
	header("Location: index.php");
}
// Get room_id from URL parameter
$room_id = isset($_GET['room_id']) ? $_GET['room_id'] : '';


// Ensure room_id is alphanumeric to prevent SQL injection
if (!ctype_alnum($room_id)) {
    header("Location: index.php");
}

$sql = "SHOW TABLES LIKE '$room_id'"; // check if the table exists
$result = $ssdb->query($sql);
$tableName = $room_id;
if ($result->num_rows == 0){//if the table doesn't exist then create table and make this guy the host
// Create table query

$sql = "CREATE TABLE IF NOT EXISTS $tableName (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    host BOOLEAN NOT NULL,
    email VARCHAR(255),
    game_started BOOLEAN NOT NULL DEFAULT 0
)";
$ssdb->query($sql);

// Insert a record of host into the table
$insertSql = "INSERT INTO $tableName (username, host, email ) VALUES ('" . $user['username'] . "', TRUE, '" . $user['email'] . "')";
$ssdb->query($insertSql);
}


else{// if the table exists then make tis guy a participant
	// Insert a record of participant into the table
	// Check if the username already exists in the table
	$checkSql = "SELECT COUNT(*) FROM $tableName WHERE username = '" . $user['username'] . "'";
	
	$result = $ssdb->query($checkSql);
	$rowCount = $result->fetch_assoc()['COUNT(*)'];

	// Insert a record if the username doesn't exist
	if ($rowCount == 0) {
	    $insertSql = "INSERT INTO $tableName (username, host, email ) VALUES ('" . $user['username'] . "', FALSE, '" . $user['email'] . "')";
	    $ssdb->query($insertSql);
	}

}











////////////////////////////////////////////////////////////////////////////////////////////////////////
// Handle form submission to update the "name" column
if ($_SERVER['REQUEST_METHOD'] == 'POST' &&isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $newName = $_POST['new_name'];

    $updateSql = "UPDATE $tableName SET name = '$newName' WHERE id = $userId";
    $ssdb->query($updateSql);
}


































//////////////////////////////////////////////////
$selectSql = "SELECT * FROM $tableName";
$result = $ssdb->query($selectSql);

// make table

echo '<table border="1">';
echo '<tr><th>ID</th><th>Username</th><th>Name</th><th>Host</th><th>Update Name</th></tr>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['username']}</td>";
    echo "<td>{$row['name']}</td>";
    echo "<td>{$row['host']}</td>";
    if ($row['username']==$user['username'] || isHost($ssdb, $tableName, $user['username']) ){
    	echo '<td>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="user_id" value="' . $row['id'] . '">';
        echo '<input type="text" name="new_name" placeholder="Enter new name">';
        echo '<input type="submit" value="Update">';
        echo '</form>';
        echo '</td>';

    }
    echo '</tr>';
}

echo '</table>';




?>

<button onclick="refreshPage()">Refresh Page</button>
<br>


<?php 
// Check if all name fields are filled
$allNamesFilled = true;

$selectSql = "SELECT name FROM $tableName";
$result = $ssdb->query($selectSql);

while ($row = $result->fetch_assoc()) {
    if (empty($row['name'])) {
        $allNamesFilled = false;
        break;
    }
}
// Check if the game has started
$selectGameStateSql = "SELECT game_started FROM $tableName WHERE host=TRUE";
$result = $ssdb->query($selectGameStateSql);
$row= $result->fetch_assoc();
$gameState=$row['game_started'];

// Display the start button if all name fields are filled and the game has not started and the user is the host
if (!$gameState) {
	if($allNamesFilled  && isHost($ssdb, $tableName, $user['username'])){
		echo '<form method=post><button name="start_button">Start Game</button></form>';
	}
	else{
		echo 'please fill all names in order to start the game';
		echo '<br>';
		echo 'Note: only host can start the game.';
	}   
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['start_button'])){
		//set $host_username
		// Retrieve the host's username from the database
		$hostSql = "SELECT username FROM $tableName WHERE host = TRUE LIMIT 1";
		$hostResult = $ssdb->query($hostSql);

		// Check if the query was successful
		if ($hostResult) {
		    // Fetch the host's username
		    $hostRow = $hostResult->fetch_assoc();
		    $host_username = ($hostRow) ? $hostRow['username'] : null;

		    // Free the result set
		    $hostResult->free();
		} else {
		    // Handle the case where the query was not successful
		    echo "Error: " . $ssdb->error;
		}
		
		///////////////////////////////////////////////////////////////
		$emails = array();

		// Fetch all emails from the specified column in the database table
		$sql = "SELECT email FROM $tableName";
		$result = $ssdb->query($sql);

		// Check if the query was successful
		if ($result) {
		    // Fetch each row and store the email in the $emails array
		    while ($row = $result->fetch_assoc()) {
		        $emails[] = $row['email'];
		    }

		    // Free the result set
		    $result->free();
		} else {
		    // Handle the case where the query was not successful
		    echo "Error: " . $ssdb->error;
		}
		shuffle($emails);
		// Now, $emails array contains all the emails from the specified column in the table

			//////////////////////////////////////////////////////////////////////////////////////////////////////
		//make names array
		$names = array();

		// Fetch names from the database for each email
		$sql = "SELECT email, name FROM $tableName WHERE email IN ('" . implode("','", $emails) . "')";
		$result = $ssdb->query($sql);

		// Check if the query was successful
		if ($result) {
		    // Fetch the data and build the $names array
		    
		    while ($row = $result->fetch_assoc()) {
		        $names[$row['email']] = $row['name'];
		      
		    }

		    // Free the result set
		    $result->free();
		} else {
		    // Handle the case where the query was not successful
		    echo "Error: " . $ssdb->error;
		}	

		/////////////////////////////////////////
		// Assuming $names is an associative array with emails as keys and names as values
		for ($i = 0; $i < count($emails); $i++) {
		    $recipientEmail = $emails[$i];
		    $recipientName = $names[$recipientEmail];
		    
		    // Assuming $previousRecipientEmail is the previous email in the shuffled list
		    $previousRecipientEmail = ($i > 0) ? $emails[$i - 1] : end($emails);
		    $previousRecipientName = $names[$previousRecipientEmail];

		    sendEmail($recipientEmail, $recipientName, 'SecretSanta by ' . $host_username, "You are supposed to gift " . $previousRecipientName . ". Make sure not to write your name on the present and to wrap it properly. THE PRESENT MUST CONTAIN THE RECIPIENTS NAME. Happy holidays!!");
		}

		echo '<br> all emails sent <br>';
		$updateSql = "UPDATE $tableName SET game_started = TRUE WHERE host=TRUE";
	    $ssdb->query($updateSql);
	}

}
else{
	echo 'the game has started. click here to create new room or click here to check out ionize.fun';
?>

	<script>

    // Function to disable all buttons
   
       	var buttons = document.getElementsByTagName('button');
	    var inputs = document.getElementsByTagName('input');

	    for (var i = 0; i < buttons.length; i++) {
	        buttons[i].disabled = true;
	    }

	    for (var i = 0; i < inputs.length; i++) {
	        inputs[i].disabled = true;
	    }
    </script>

   	
<?php 

}

?>













<script>
    // JavaScript function to refresh the page
    function refreshPage() {
        location.reload();
    }
</script>

