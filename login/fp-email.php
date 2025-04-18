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
    <form method='POST'>
        <div class="credential-box">
            <font class='label-black'>Forgot password?</font>
            <div id='email-div'>
                <label for='email'>
                    <font class='label-white'>Email: </font>
                    <?php if ($email_invalid): ?>
                        <br>
                        <em><font class ='label-red'>No email found</font></em>
                    <?php endif; ?>
                </label>
                <input type='email' id='email' class='one-line-text-input' name='email' value="<?=$_POST['email'] ?? ''?>">
            </div>
            <div id="emailSuggestions"></div><!--  email suggestions -->
            <script src='script.js'></script> <!-- javascript to suggest emails -->
            <div class='submit-button-div'>
                <button class='submit-button'>Send otp</button>
            </div>
        </div>
    </form>
</body>
</html>
