<?php
require_once '../essentialfiles/beforephp.php'; // Sets local/live variables which are protocol, domain, subdomain1, dbname, dbusername, dbpassword. Also checks if the user has logged in; if he has, then retrieves the $user array.
require_once '../essentialfiles/important_functions.php'; // sendEmail($recipientEmail, $recipientName, $subject, $body) - use this function to send emails. generateRandomSentence() - generate a small random sentence. generateRandomString($length) - generates a random string of a specific length.

$step = 'email'; // Set default value for $step
if (isset($user['email'])) {
    header("Location: fp-logged-in.html");
}

switch ($_GET['step']) {
    case 'email':
        $email_invalid = false;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Code to check whether the given email address exists in the database and add the user to the forgot-password database table. Then, redirect to the OTP page.
            $mysqli = require __DIR__."/database.php";
            $sql = "SELECT * FROM user WHERE email = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $_POST["email"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if (!$user) { // User doesn't exist in the database.
                $email_invalid = true;
            } else { // User was found in the database, so add them to the forgot-password table and send the OTP.
                $fp_id = generateRandomString(50);
                $email = $user['email'];
                $username = $user['username'];
                $otp = generateRandomSentence();
                $expirationTime = time() + 120; // Expiration time is 2 minutes.

                // Insert the OTP details into the forgot-password table.
                $sql = "INSERT INTO `forgot-password` (fp_id, email, otp, exp_time) VALUES (?, ?, ?, ?)";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("sssi", $fp_id, $email, $otp, $expirationTime);
                $stmt->execute();
                $stmt->close();

                //////////////////////////////////////////////////////////////////////////// SMTP

                $body = <<<EOT
                    Dear $username,
                    
                    We received a request to reset your password for your Ionize.fun account. To verify your identity, please use the following One-Time Password (OTP):
                    
                    $otp
                    
                    Please enter this OTP on the password reset page within the next 2 minutes.
                    
                    If you did not request a password reset, you can safely ignore this email.
                    
                    Best regards,
                    The Ionize.fun Team
                    EOT;

                sendEmail($email, $username, 'Your One-Time Password (OTP) for Ionize.fun', $body);
                

                ////////////////////////////////////////////////////////////////////////////////
                session_start();
                $_SESSION['fp_id'] = $fp_id;
                $_SESSION['email'] = $email;

                $path = $_SERVER['PHP_SELF']."?step=otp";
                header("Location: ".$path);
                exit();
            }
        }
        require 'fp-email.php';
        break;

    case 'otp':
        session_start();
        $_SESSION['otp_done'] = false;
        $otp_invalid = false;
        $otp_expired = false;
        $fp_id = $_SESSION['fp_id'];

        // Code to retrieve the OTP set in the database.
        $mysqli = require __DIR__."/database.php";
        $sql = "SELECT * FROM `forgot-password` WHERE fp_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $fp_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $fpuser = $result->fetch_assoc();
        $stmt->close();

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['fp_id'])) {
            if ($fpuser['exp_time'] < time()) { // If OTP has expired.
                $otp_expired = true;
                session_destroy();
                $path = $_SERVER['PHP_SELF']."?step=email";
                header("Location: ".$path);
                exit();
            }
            if ($fpuser['otp'] === $_POST['otp'] && $fpuser['exp_time'] > time()) { // If OTP matches the OTP set in the forgot-password table and it hasn't expired, then change $otp_done to true.
                $_SESSION['otp_done'] = true;
                $otp_invalid = false;
                $path = $_SERVER['PHP_SELF']."?step=password";
                header("Location: ".$path);
                exit();
            } else {
                $otp_invalid = true;
                $_SESSION['otp_done'] = false;
            }
        } elseif (!isset($_SESSION['fp_id'])) { // If someone skipped to this page directly.
            session_destroy();
            $path = 'stop-tinkering.html';
            header("Location: $path");
            exit();
        }
        require 'fp-otp.php';
        break;

    case 'password':
        session_start();

        if (!isset($_SESSION['fp_id']) || !isset($_SESSION['otp_done']) || !$_SESSION['otp_done']) { // If someone skipped to this page directly.
            session_destroy();
            $path = 'stop-tinkering.html';
            header("Location: $path");
            exit();
        }

        $is_matched = true;
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['fp_id']) && $_SESSION['otp_done']) {
            if ($_POST['password1'] !== $_POST['password2']) {
                $is_matched = false;
            } else {
                // Code to change password in the user database table.
                $password_hash = password_hash($_POST["password1"], PASSWORD_DEFAULT);
                $email = $_SESSION['email'];

                $sqlQuery = "UPDATE user SET password_hash = ? WHERE email = ?";
                $stmt = $mysqli->prepare($sqlQuery);
                $stmt->bind_param("ss", $password_hash, $email);
                $stmt->execute();
                $stmt->close();

                session_destroy();
                header("Location: forgot-password-success.html");
            }
        }

        require 'fp-password.php';
        break;

    default:
        $path = $_SERVER['PHP_SELF']."?step=email";
        header("Location: ".$path);
        break;
}
?>
