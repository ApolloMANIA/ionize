<?php
require_once '../essentialfiles/beforephp.php'; // Sets local/live variables which are protocol, domain, subdomain1, dbname, dbusername, dbpassword. Also checks if the user has logged in; if he has, then retrieves the $user array.
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$mysqli = require __DIR__."/database.php";

$email = $_POST["email"];
$username = $_POST["username"];

// Check if the email or username already exists
$checkQuery = "SELECT * FROM user WHERE email = ? OR username = ?";
$checkStmt = $mysqli->stmt_init();

if (!$checkStmt->prepare($checkQuery)) {
    die("SQL error: " . $mysqli->error);
}

$checkStmt->bind_param("ss", $email, $username);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // Email or username already taken
    $row = $checkResult->fetch_assoc();
    if ($row['email'] == $email) {
        $response = array(
            'message' => 'Email already taken',
            'tooltip' => " <button class='q-info'><i class='fa fa-question'></i></button>
                          <span class='tooltiptext'>If you haven't signed up at Ionize before, then use the <a href='forgot-password.php'>forgot password</a> feature to claim this email.</span>"
        );
        echo json_encode($response);
    } elseif ($row['username'] == $username) {
        echo json_encode(array('message' => 'Username already taken'));
    }
} else {
    // Insert the new user into the database
    $insertQuery = "INSERT INTO user (email, username, password_hash) VALUES (?, ?, ?)";
    $insertStmt = $mysqli->stmt_init();

    if (!$insertStmt->prepare($insertQuery)) {
        die("SQL error: " . $mysqli->error);
    }

    $insertStmt->bind_param("sss", $email, $username, $password_hash);

    if ($insertStmt->execute()) {
        echo json_encode(array('message' => 'success'));
    } else {
        die("Error: " . $mysqli->error);
    }
}
?>
