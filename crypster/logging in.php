<?php  //no need to inclue the beforephp.php file because this page is only accessed through transition.php which includes beforephp.php
$session_id= $_COOKIE['session_id']; //sets the variable 
//code to get the $user array
$mysqli= require "essential files/database.php";
    $sql = sprintf("SELECT * FROM user 
            WHERE session_id ='%s'",
            $mysqli->real_escape_string($session_id));
$result = $mysqli->query($sql);
$user = $result ->fetch_assoc();

////////////////////////////////////////////////////


$level = $user['crypster_level'];
$username = $user['username'];
$levelhref = "levelone.htm"; // Set a default value for $levelhref

require '../vendor/autoload.php';

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//code to read the plan.xlsx file

use PhpOffice\PhpSpreadsheet\IOFactory;

$path = __DIR__ . '/plan.xlsx';


try {
    if (file_exists($path)) {
        $spreadsheet = IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();

        $levelhref = $worksheet->getCell('F' . ($level + 1))->getValue();
    } else {
        echo "File not found: " . $path;
    }
} catch (Exception $e) {
    echo 'Error reading the Excel file: ' . $e->getMessage();
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>

<!-- Rest of your HTML code -->

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>logging in</title>
        <link href="https://fonts.googleapis.com/css2?family=Creepster&display=swap" rel="stylesheet">
    </head>
    <body style = "background-color: black;">
        <style>
            #main{
                display: block;
                color:#BFAC60;/*Change font color acc to Login page*/
                height: 100px;
                font-size: 100px;
                text-align: center;
                font-family: 'Creepster';
                padding-top: 50px;
                padding-bottom: 60px;
            }
            .buttons{
                margin: 70px;
                padding:10px;
                color: #BFAC60;
                border: solid;
                background:transparent;
                font-size: 30px;
            }
            #Some-anime-zombie-girl-1{
                flex: 1;
            }
            #Some-anime-zombie-girl-2{
                flex: 1;
            }
        </style>
        <div id = "main">
            CRYPSTER
        </div>
        <div style = "display: flex; flex-direction: row;">
            <div id = "Some-anime-zombie-girl-1">
                <img src = ""> <!--Add one of the zombie girls here-->
            </div>
            <div style = "flex: 2;">
                <div style = "text-align: center;">
                   
                        <a href = "<?php echo $levelhref;?>" target ='_blank' >                             
                            <button class = "buttons" style = "margin-bottom: 3px;">
                                Start from Save
                            </button>
                        </a>

                    

                <div style = "text-align: center; color: #BFAC60;">
                    *<?php echo $user['username']?> can start from level <?php echo $user['crypster_level'];?>
                </div>
                </div>
                <div style = "text-align: center; " >
                    <a href = "levelone.htm">                             
                        <button class = "buttons" style = "margin-bottom: 3px;">
                            Start from Beginning
                        </button>
                    </a>

                 <div style = "text-align: center; color: #BFAC60;">
                    *Don't worry your progress won't reset. You can start from the highest level you have played at anytime by clicking the start from save button.
                </div>
                </div>

                <div style = "text-align: center;">
                        <?php $path = $protocol."://".$domain."/login/logout.php" ?> <!-- redirect to logout page -->
                        <a href = <?php echo $path ?> >                             
                            <button class = "buttons" style = "margin-bottom: 3px;">
                                Logout
                            </button>
                        </a>
                </div>

            </div>
            <div id = "Some-anime-zombie-girl-2">
                <img src = ""> <!--Add one of the zombie girls here-->
            </div>
        </div>
    </body>
</html>