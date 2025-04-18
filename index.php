<?php 
require_once 'essentialfiles/beforephp.php';//sets local/ live variables which are protocol domain subdomain1 dbname dbusername dbpassword and also checks if the user has logged in, if he has then retrieves the $user array.
include 'essentialfiles/important_functions.php';// sendEmail($recipientEmail, $recipientName, $subject, $body) use this function to send emails. generateRandomSentence() generate a small random sentence. generateRandomString($length) generates a random string of a specific length
?>

 <!DOCTYPE html>
<html lang="en">
<head>
<title>Ionize</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body {font-family: "Lato", sans-serif}
.mySlides {display: none}
</style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="#band" class="w3-bar-item w3-button w3-padding-large w3-hide-small">ABOUT</a>
    <a href="#tour" class="w3-bar-item w3-button w3-padding-large w3-hide-small">PROJECTS</a>
    <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTACT</a>
    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-padding-large w3-button" title="More">MORE <i class="fa fa-caret-down"></i></button>     
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button">Merchandise</a>
        <a href="#" class="w3-bar-item w3-button">Extras</a>
        <a href="#" class="w3-bar-item w3-button">Media</a>
      </div>
    </div>
    <!-- php                                          -->
    <?php

    if(!isset($session_id)){//if not logged in then show this

   echo '<a href="login/login.php" class="w3-padding-large w3-hover-yellow w3-hide-small w3-right">Login </a>
     <a href="login/signup.html" class="w3-padding-large w3-hover-yellow w3-hide-small w3-right">Sign up </a>';
   }
   else{//if logged in then show this 
     
     echo '<a href="login/logout.php" class="w3-padding-large w3-hover-yellow w3-hide-small w3-right">Log out </a>'
     . '<font class="w3-padding-large w3-right">Hello ' . $user['username'] . '</font>';

   }
   ?>
<!-- php                                          -->

    <a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right"><i class="fa fa-search"></i></a>
  </div>
</div>

<!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
  <a href="#band" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">ABOUT</a>
  <a href="#tour" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">PROJECTS</a>
  <a href="#contact" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">CONTACT</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">MERCH</a>
</div>

<!-- Page content -->

<div class="w3-content" style="max-width:2000px;margin-top:4px">
 
  

  <!-- The About Section -->
  <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px" id="band">
    <img src='ionizelogo-whitebg.jpg' style="display: block; margin-left: auto; margin-right: auto; width: 40%;">
    <p class="w3-opacity"><i>Demand and supply ftw</i></p>
    <p>We make and let independent creators make web applications and host their work on our website. If you want to help us with our projects or have a project of your own that you want on the web, contact us on our email or use the contact us form.</p>
   
    
  </div>

  <!-- Our projects -->
  <div class="w3-black" id="tour">
    <br><br>
  <header id="portfolio">
    
    <div class="w3-container">
    <h1><b>Our projects</b></h1>
    <div class="w3-section w3-bottombar w3-padding-16">
      <span class="w3-margin-right">Filter:</span> 
      <button class="w3-button w3-black">ALL</button>
      <button class="w3-button w3-white"><i class="fa fa-diamond w3-margin-right"></i>Games</button>
      <button class="w3-button w3-white w3-hide-small"><i class="fa fa-photo w3-margin-right"></i>VNs pls</button>
      <button class="w3-button w3-white w3-hide-small"><i class="fa fa-map-pin w3-margin-right"></i>QOL websites</button>
    </div>
    </div>
  </header>
  
 <!-- Projects -->
 <div class="w3-row-padding">
    <div class="w3-third w3-container w3-margin-bottom">
      <a href=<?php echo($protocol. "://". $subdomain1.".".$domain);?>>
      <img src="crypster.jpg" alt="crypster" style="width:100%" class="w3-hover-opacity" >
    </a>
      <div class="w3-container w3-white">
        <p><b>Crypster</b></p>
        <p>A puzzle game which will make your brain's gears spin.</p>
      </div>
    </div>
    <div class="w3-third w3-container w3-margin-bottom">
      <a href=<?php echo($protocol. "://". $domain."/JEE-Marks-Checker");?>><!--change this to relative later-->
      <img src="jeemarkschecker.jpg" alt="jee marks checker" style="width:100%; height:175px" class="w3-hover-opacity">
      <a>
      <div class="w3-container w3-white">
        <p><b>Jee mains 2023 session 2 marks checker</b></p>
        <p>Helps to calculate JEE Main marks which is otherwise a pain.</p>
      </div>
    </div>
    <div class="w3-third w3-container w3-margin-bottom">
      <a href=<?php echo($protocol. "://". $subdomain2.".".$domain);?>><!--change this to relative later-->
      <img src="secretsanta.png" alt="secretsanta" style="width:100%; height:175px" class="w3-hover-opacity">
      <a>
      <div class="w3-container w3-white">
        <p><b>SecretSanta</b></p>
        <p>Holiday time? SecretSanta!!</p>
      </div>
    </div>
    <br>
 <br>

  <br><br><br><br>

  <br><br><br><br><br><br><br><!-- Pagination -->
  <div class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a href="#" class="w3-bar-item w3-button w3-hover-black">«</a>
      <a href="#" class="w3-bar-item w3-black w3-button">1</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">2</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">3</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">4</a>
      <a href="#" class="w3-bar-item w3-button w3-hover-black">»</a>
    </div>
  </div>

 

  <!-- The Contact Section -->
  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="contact">
    <h2 class="w3-wide w3-center">CONTACT</h2>
    <p class="w3-opacity w3-center"><i>Dm on socials to work with us</i></p>
    <div class="w3-row w3-padding-32">
      <div class="w3-col m6 w3-large w3-margin-bottom">
        <!--<i class="fa fa-map-marker" style="width:30px"></i> your closet<br>-->
        <!--<i class="fa fa-phone" style="width:30px"></i> 7304756938<br>-->
        <i class="fa fa-envelope" style="width:30px"> </i> Email:ionize2023@gmail.com<br>
              Or write a message here:

      </div>

      <div class="w3-col m6">
       <!--chinar make php for this--> 
        <form method="post">
          <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
            <div class="w3-half">
              <input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
            </div>
            <div class="w3-half">
              <input class="w3-input w3-border" type="email" placeholder="Email" required name="Email">
            </div>
          </div>
          <input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
          <button class="w3-button w3-black w3-section w3-right" type="submit">SEND</button>
        </form>

        <?php
          if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Extract form data
            $name = $_POST['Name'];
            $email = $_POST['Email'];
            $message = $_POST['Message'];

            // Set email recipient details
            $recipientEmail = "ionize2023@gmail.com"; 
            $recipientName = "Ionize";
            $subject = "Contact us Form Submission"; 

            // Compose the email body
            $body = "Name: $name\n";
            $body .= "Email: $email\n";
            $body .= "Message: $message\n";


            // Call the sendEmail() function to send the email
            if (sendEmail($recipientEmail, $recipientName, $subject, $body)) {
                // Email sent successfully
                $alertMessage = "Email submitted successfully!";
            } else {
                // Email sending failed
                $alertMessage = "Error: Failed to submit email.";
            } 
          }
        ?>
        <script>
          var alertMessage = "<?php echo $alertMessage; ?>";
          if (alertMessage !== "") {
              alert(alertMessage);
          }
        </script>
      </div>
    </div>
  </div>
  
<!-- End Page Content -->
</div>

<!-- Image of location/map -->
<img src="https://pbs.twimg.com/media/DlX5eMMXsAIQF8O.jpg" class="w3-image w3-greyscale-min" style="width:100%">

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
  <i class="fa fa-facebook-official w3-hover-opacity"></i>
  <i class="fa fa-instagram w3-hover-opacity"></i>
  <i class="fa fa-snapchat w3-hover-opacity"></i>
  <i class="fa fa-pinterest-p w3-hover-opacity"></i>
  <i class="fa fa-twitter w3-hover-opacity"></i>
  <i class="fa fa-linkedin w3-hover-opacity"></i>
  <p class="w3-medium">Powered by <a href="https://www.youtube.com/watch?v=xvFZjo5PgG0" target="_blank">your mom</a></p>
</footer>

<script>


// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}


</script>

</body>
</html>
