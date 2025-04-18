<?php
session_start();
$_SESSION['otp_done'] = false;//will be used on the passwords page
$otp_invalid=false;
$otp_expired=false;
if(!isset($_SESSION['otp_hash'])){//if landed on this page without typing in email.
    header("Loation: stop-tinkering.html");
    exit();
}
// Function to redirect to signup.html
function redirectToSignup() {
    header("Location: signup.html");
    exit;
}

// Function to verify the OTP
function verifyOTP($submittedOTP) {
    // Validate the submitted OTP
    $hashedOTP = password_hash($submittedOTP, PASSWORD_DEFAULT);
    if($_SESSION['exp_time']<time()){
        $otp_expired=true;

    }

    if (isset($_SESSION['otp_hash']) && $hashedOTP === $_SESSION['otp_hash']) {
        // OTP is correct, proceed with account creation or other actions
        echo "OTP verified successfully!";
        // Reset the OTP session variables to prevent reuse
        unset($_SESSION['otp_hash']);
        unset($_SESSION['exp_time']);
        $_SESSION['otp_done']=true;
        header("Location: signup-password.php");
    } else {
        // Invalid OTP or expired timer
        $otp_invalid=true;
        session_destroy();
    }
}

// Check if OTP form is submitted
if (isset($_POST['otp'])) {
    verifyOTP($_POST['otp']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Ionize.fun</h1>

    <h2>
        <a href='signup.html'>Start Over?</a>
        <br>OTP verification
    </h2>
    <form method='POST' id='otpForm'>
        <div class="credential-box">
            <div id='otp-div'>
                <label for='otp'>
                    <font class='label-white'>Enter OTP: </font>
                    <?php if ($otp_invalid): ?>
                    <br>
                    <em>
                        <font class='label-red'>Wrong OTP. Starting over again.</font>
                    </em>
                    <script>
                        // JavaScript function to redirect after 2 seconds
                            setTimeout(function() {
                                window.location.href = 'signup.html';
                            }, 4000); // 4000ms = 4 seconds
                        </script>
                    <?php endif; ?>
                    <?php if ($otp_expired): ?>
                    <br>
                    <em>
                        <font class='label-red'>OTP has expired. Starting over again.</font>
                    </em>
                    <script>
                        // JavaScript function to redirect after 4 seconds
                            setTimeout(function() {
                                window.location.href = 'signup.html';
                            }, 4000); // 4000ms = 4 seconds
                        </script>
                    <?php endif; ?>
                </label>
                <input type='text' id='otp' class='one-line-text-input' name='otp' value="<?=$_POST['otp'] ?? ''?>">
            </div>
            <span id="timer" style="font-size:20px;" class='label-red'></span>
            <div class='submit-button-div'>
                <button class='submit-button' id='checkotp'>Check otp</button>
            </div>
        </div>
    </form>
    <script>
    // Get the expiration time from PHP variable
    const expTime = <?php echo $_SESSION['exp_time']; ?>;

    // Function to update the timer
    function updateTimer() {
        const now = Math.floor(Date.now() / 1000); // Get the current timestamp in seconds
        const remainingTime = expTime - now;


        // Format the remaining time as minutes and seconds
        const minutes = Math.floor(remainingTime / 60);
        const seconds = remainingTime % 60;

        // Display the timer in the 'timer' span element
        if (remainingTime > -1) {
            document.getElementById('timer').textContent = `Time remaining: ${minutes} min ${seconds} sec`;
        } else {
            document.getElementById('timer').textContent = `OTP has expired. Redirecting...`;
            setTimeout(function() {
                window.location.href = 'signup.html';
            }, 4000); // 4000ms = 4 seconds

        }

    }

    // Call the updateTimer function initially to show the remaining time
    updateTimer();

    // Call the updateTimer function every second to update the timer dynamically
    setInterval(updateTimer, 1000);
    </script>
</body>

</html>