<?php
include "beforephp.php";//sets local/ live variables which are protocol domain subdomain1 dbname dbusername dbpassword and also checks if the user has logged in, if he has then retrieves the $user array.


// passphrasing
if (!isset($_POST["passphrase"]) && $user['crypster_level']<$level){//if passphrase hasn't been given yet and crypster level is less than the current level(provided in the code of that level) then ask for the password
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <title>Enter Passphrase</title>
    </head>
    <body>
      <script>
        
        var passphrase = prompt('Enter Passphrase'+"\n<?php echo $hint; ?>");//remember to add option to add hint over here

        if (passphrase) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>';
            form.autocomplete="off";

            
            var passphraseInput = document.createElement('input');
            passphraseInput.type = 'text';
            passphraseInput.name = 'passphrase';
            passphraseInput.value = passphrase;

            
            form.appendChild(passphraseInput);
            document.body.appendChild(form);
            form.submit();
        } else {
            alert("Please enter a passphrase that isn't empty.");
            window.history.back();
            window.stop();


        }
    </script>
    </body>
    </html>
    <?php
    exit();
}
else if(isset($_POST['passphrase'])){
    $enteredPassphrase=$_POST["passphrase"];
    if($enteredPassphrase!=$expectedPassphrase){ 
        ?>
        <script>
            window.alert('Incorrect passphrase. Please try again.');
            window.history.back();
            window.stop();
        </script>

       <!--  <html>
        <head>
        <title> Restricted content </title>
        </head>
        <body>
        <h1>The content is restricted</h1><hr>
        Please enter the correct password to access this page.<br>
        Press the back button till you reach the previous levels page(usually twice)<br>

        </body>
 -->
        <?php
         unset($_POST['passphrase']);

        exit;
    }
    else{//else let them play
                // update level and then show code
        if(isset($user['email'])){
            
            $email = $user['email'];

            $sqlQuery = "UPDATE user SET crypster_level = $level WHERE email = '$email'";

            if ($user['crypster_level']< $level){
                $mysqli->query($sqlQuery);
            }
                
        }
        
    }
    
}
?>