<?php
$mysqli= require __DIR__."/database.php";
$username = $_POST['username'];
$email = $_POST['email'];

$sql = "SELECT * FROM your_table WHERE username = '$username' OR email = '$email'";
$result = $mysqli->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Check if the username is taken
    if ($row['username'] === $username) {
        echo '<script>document.getElementById("username").innerHTML = "Username already taken";</script>';
    }
    // Check if the email is taken
    if ($row['email'] === $email) {
        echo '<script>document.getElementById("email").innerHTML = "Email already taken";</script>';
    }
} else {
    // Insert the new user into the database
    $insertSql = "INSERT INTO your_table (username, email) VALUES ('$username', '$email')";
    if ($conn->query($insertSql) === TRUE) {
        echo '<script>document.getElementById("availability-message").innerHTML = "Sign Up Successful";</script>';
    } else {
        echo '<script>document.getElementById("availability-message").innerHTML = "Error: ' . $conn->error . '";</script>';
    }
}

// Close the database connection
$conn->close();
?>