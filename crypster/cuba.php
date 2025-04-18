<?php 
$expectedPassphrase = 'havana';
$hint ="";//write in the form of "Hint: asdfdsalfn"
$level = 12;
include "essential files/beforehtml.php";
    ?>
<!DOCTYPE html>
<html>
<head>
    <audio src="audio/Nicki Minaj - Anaconda.mp3" autoplay loop></audio>
  <title>Yes the game</title>
  <style>
    
    .dice {
      width: 100px;
      height: 100px;
      background-color: #f7f7f7;
      border: 1px solid #ccc;
      display: inline-block;
      margin: 10px;
      text-align: center;
      font-size: 72px;
      line-height: 100px;
    }
    
    
    .hidden {
      display: none;
    }
  </style>
</head>
<body bgcolor='black' style="text-align: center;">
  <img src = 'images/bored_games.jpg' alt = 'image not found'><br><br><br>
  <div class="dice" id="dice1"></div>
  <div class="dice" id="dice2"></div>
  <button onclick="rollDice()">Roll Dice</button>
  <button class="hidden" id="redirectButton" onclick="redirectToNewPage()">Continue</button>

  <script>function rollDice() {
    
    var diceFaces = ["\u2680", "\u2681", "\u2682", "\u2683", "\u2684", "\u2685"];
  
    
    var dice1Value = Math.floor(Math.random() * 6) + 1;
    var dice2Value = Math.floor(Math.random() * 6) + 1;
  
    
    document.getElementById('dice1').innerHTML = diceFaces[dice1Value - 1];
    document.getElementById('dice2').innerHTML = diceFaces[dice2Value - 1];
  
    
    if (dice1Value === 6 && dice2Value === 6) {
      
      document.getElementById('redirectButton').classList.remove('hidden');
    } else {
      
      document.getElementById('redirectButton').classList.add('hidden');
    }
  }
  
  function redirectToNewPage() {
    
    window.location.href = "googlemaps.php"; 
  }
  </script>
</body>
</html>


