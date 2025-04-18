



<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body bgcolor = 'yellow'>
     <p id="message"></p>
     <script>

function getURLParameter(name) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(name);
}

const variable = getURLParameter('variable');
const messageElement = document.getElementById("message");
if(variable!== null){
    localStorage.setItem('variable',variable);
    
  messageElement.textContent = "variable is found";


}
else{
    messageElement.textContent = "variable not found";

}

</script>

</body>
</html>