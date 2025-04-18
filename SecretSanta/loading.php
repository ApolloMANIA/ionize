<?php

require_once 'essentialfiles/beforephp.php';

// Function to check if the current subdomain matches the target subdomain
function isCurrentSubdomain($subdomain) {
    return strpos($_SERVER['HTTP_HOST'], $subdomain) === 0;
}

if($_GET['logout']=='yes'){//code if this page is accessed from the logout page(delete cookies by cycling through all the subdomains)

  $session_id=null;
  $expiration_time = time() -1; //set expiration time to be in past so that cookie is deleted


  setcookie("session_id", $session_id, $expiration_time, '/', $_SERVER['HTTP_HOST'], false, true);
  // Immediately remove the cookie from the $_COOKIE array on the current request
  unset($_COOKIE['session_id']);

  // Optionally, you can also nullify the variable to remove the value from the PHP script
  $session_id = null;


    // Find the current subdomain based on the $_SERVER['HTTP_HOST'] variable
    $current_subdomain = null;
    foreach (get_defined_vars() as $var_name => $var_value) {
        if (strpos($var_name, 'subdomain') === 0 && isCurrentSubdomain($var_value)) {
            $current_subdomain = $var_value;
            
            break;
        }
    }
    

    // Find the next subdomain
    $next_subdomain = null;
    $subdomain_vars = get_defined_vars();
    $subdomain_vars = array_filter($subdomain_vars, function ($key) {
                                                                    return strpos($key, 'subdomain') === 0;
                                                                }, ARRAY_FILTER_USE_KEY);

    
    $current_subdomain_key = array_search($current_subdomain, $subdomain_vars);
    $current_index = intval(substr($current_subdomain_key, 9));

    
    $next_index = $current_index + 1;
    $next_subdomain_var = 'subdomain' . $next_index;
    
    
  

    $next_subdomain_url = ''; // Initialize $next_subdomain_url

    if (isset($subdomain_vars[$next_subdomain_var])) {
        $next_subdomain = $subdomain_vars[$next_subdomain_var];
    }

    if ($next_subdomain && !isCurrentSubdomain($next_subdomain)) {//if next subdomain exists
        // Redirect to the next subdomain
        $next_subdomain_url = $protocol ."://" .$next_subdomain .".".$domain. "/loading.php?logout=yes" ."&mode=".$_GET['mode'];
        header("Location: " . $next_subdomain_url);
        exit();
    } 
    else {
      $mode = $_GET['mode'];
      if ($mode!=='ionize' && $mode!==''){
        $path= $protocol ."://" .$mode .".".$domain;
        header("Location: ".$path);
        exit();
      }
      else{
        $path = $protocol ."://" .$domain;
        header("Location: ".$path);
        exit();
      }
        // If there are no more subdomains or if the next subdomain is the same as the current one,
        // redirect to the main app/dashboard


        $index_of_main= $protocol."://".$domain."/index.php";
        header("Location: $index_of_main");
        exit();
    }
  

}
else{//else show the page which should be accessed from the login page(set cookies on every subdomain)

  if (isset($_GET['session_id'])) {
      
      $session_id = $_GET['session_id']; 

      // Set the cookie to last for 10 years (adjust as needed)
      $expiration_time = time() + (10 * 365 * 24 * 60 * 60); // 10 years in seconds

        // Set the httponly cookie on the subdomain with a long expiration time
      setcookie("session_id", $session_id, $expiration_time, '/', $_SERVER['HTTP_HOST'], false, true);

      // Find the current subdomain based on the $_SERVER['HTTP_HOST'] variable
      $current_subdomain = null;
      foreach (get_defined_vars() as $var_name => $var_value) {
          if (strpos($var_name, 'subdomain') === 0 && isCurrentSubdomain($var_value)) {
              $current_subdomain = $var_value;
              
              break;
          }
      }
      

      // Find the next subdomain
      $next_subdomain = null;
      $subdomain_vars = get_defined_vars();
      $subdomain_vars = array_filter($subdomain_vars, function ($key) {
                                                                      return strpos($key, 'subdomain') === 0;
                                                                  }, ARRAY_FILTER_USE_KEY);

      
      $current_subdomain_key = array_search($current_subdomain, $subdomain_vars);
      $current_index = intval(substr($current_subdomain_key, 9));

      
      $next_index = $current_index + 1;
      $next_subdomain_var = 'subdomain' . $next_index;
      
      
    

      $next_subdomain_url = ''; // Initialize $next_subdomain_url

      if (isset($subdomain_vars[$next_subdomain_var])) {
          $next_subdomain = $subdomain_vars[$next_subdomain_var];
          
          // Construct the URL for debugging
          $next_subdomain_url = $protocol . "://" . $next_subdomain . "." . $domain . "/loading.php?session_id=" . urlencode($session_id) . "&mode=" . $_GET['mode'];
         
      }

      if ($next_subdomain && !isCurrentSubdomain($next_subdomain)) {
          // Redirect to the next subdomain
          $next_subdomain_url = $protocol ."://" .$next_subdomain .".".$domain. "/loading.php?session_id=" . urlencode($session_id)."&mode=".$_GET['mode'];
          header("Location: " . $next_subdomain_url);

          exit();
      } 
      else {
        $mode = $_GET['mode'];
        if ($mode!=='ionize' && $mode!==''){
          $path= $protocol ."://" .$mode .".".$domain;
          header("Location: ".$path);
          exit();
        }
        else{
          $path = $protocol ."://" .$domain;
          header("Location: ".$path);
          exit();
        }
          // If there are no more subdomains or if the next subdomain is the same as the current one,
          // redirect to the main app/dashboard


          $index_of_main= $protocol."://".$domain."/index.php";
          header("Location: $index_of_main");
          exit();
      }
  }
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Loading Page</title>
  <style>
    /* Apply some basic styles to the body to center the content */
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f1f1f1; /* Set a background color for the page */
    }

    /* Translucent background */
    .loading-container {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(8px); /* Glass effect (adjust the blur amount as needed) */
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); /* Add shadow for the glass container */
    }

    /* Big and translucent text with blinking effect */
    .loading-container::before {
      content: "Loading...";
      font-size: 96px; /* Increase the font size */
      font-weight: bold;
      color: rgba(0, 0, 0, 0.8); /* Translucent white text color for the glass effect */
      text-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Add shadow for the glass effect */
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1; /* Set the z-index to bring the text above the image */
      animation: blink 1.5s infinite; /* Add blinking animation */
    }

    /* Center the image */
    .loading-image {
      width: 100%;
      height: 100%;
      object-fit: cover; /* Make the image cover the whole container without distortion */
      position: relative; /* Ensure the image is inside the loading-container */
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); /* Add shadow for the glass image */
    }

    /* Blinking animation */
    @keyframes blink {
      0% {
        opacity: 0.2;
      }
      50% {
        opacity: 1;
      }
      100% {
        opacity: 0.2;
      }
    }
  </style>
</head>
<body>
  <div class="loading-container">
    <img class="loading-image" src="https://c4.wallpaperflare.com/wallpaper/621/158/456/shinomiya-kaguya-archery-women-hd-wallpaper-preview.jpg" alt="Loading Image">
  </div>
</body>
</html>
