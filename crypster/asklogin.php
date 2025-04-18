<?php 
require_once 'essential files/beforephp.php'
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Wanna log in?</title> <!--Add Title of your own accord-->
        <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
    </head>
    <body>
        <style>
            body{
                background-color: black;
            }
            #main{
                display: block;
                color:#BFAC60; /*Change font color acc to Login page*/
                height: 100px;
                font-size: 100px;
                text-align: center;
                font-family: 'Creepster';
                padding-top: 50px;
                padding-bottom: 50px;
            }
            .log-text{
                font-family: 'Courier New', Courier, monospace; /*Change Font Family if needed*/
                font-size: 30px;
                color: #BFAC60;
                text-align: center;
                display: block;
                margin: 50px;
            }
            .page-buttons{  /* Edit All Buttons Here*/
                font-size: 30px;
                color: #BFAC60;
                background: transparent;
                border: solid;
                margin: 0;
                padding: 10px;
                margin-top: 50px;
                margin-left: 50px;
                margin-right: 50px;
            }
            .page-buttons:hover{
                cursor: pointer;
            }
        </style>
        <div id = "main">
            CRYPSTER
        </div>
        <div class = "log-text">
            You have not Logged In. 
        </div>
        <div class = "log-text">
            Log In to save your progress and pick up where you left off.
        </div>
        <div style = "display: block; text-align: center;">
            <?php $path = $protocol."://".$domain."/login/signup.html?mode=crypster" ?>
            <a href = <?php echo $path ?>>                                    <!--Add href here-->
                <button class = "page-buttons">
                    Sign Up
                </button>
            </a >    
            <?php $path = $protocol."://".$domain."/login/login.php?mode=crypster" ?>                               
            <a href = <?php echo $path ?>> 
                <button class = "page-buttons">
                Log In
                </button>
            </a>
        </div>
        <div style = "display: block; text-align: center;">
            <a href = "levelone.htm">                                   <!--Add href here-->
                <button class = "page-buttons">
                    Play without Logging In
                </button>
            </a>
        </div>
    </body>
</html>