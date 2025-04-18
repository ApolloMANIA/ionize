<!DOCTYPE html>
<html>

<head>
    <title>forgot-password</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
</head>

<body>
    <h1>Ionize.fun</h1>
    <h2><a href="login.php">Log in</a></h2>
    <h2 id="orLogin">OR <a href="signup.html"> Sign up</a></h2>
    <form method='POST' id='otpForm'>
        <div class="credential-box">
            <font class='label-black'>Forgot password?</font>
            <div id='email-div'>
                <label for='email'>
                    <font class='label-white'>OTP: </font>
                    <?php if ($otp_invalid): ?>
                    <br>
                    <em>
                        <font class='label-red'>Wrong OTP. Starting over again.</font>
                    </em>
                    <script>
                        // JavaScript function to redirect after 2 seconds
                            setTimeout(function() {
                                window.location.href = '<?php echo $_SERVER['PHP_SELF'] . "?step=email"; ?>';
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
                                window.location.href = '<?php echo $_SERVER['PHP_SELF'] . "?step=email"; ?>';
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
    const expTime = <?php echo $fpuser['exp_time']; ?>;

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
                window.location.href = '<?php echo $_SERVER['PHP_SELF'] . "?step=email"; ?>';
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