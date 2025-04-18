// Predefined list of common email domains
const commonEmailDomains = [
  
  'gmail.com',
  'yahoo.com',
  'hotmail.com',
  'outlook.com',
  'icloud.com',
];


// Function to suggest common email domains
function suggestEmailDomains(inputElement, suggestionsElement) {
  const userInput = inputElement.value.toLowerCase();
  const atPosition = userInput.indexOf('@');

  if (atPosition !== -1) {
    const userDomain = userInput.substring(atPosition + 1);
    const matchedDomains = commonEmailDomains.filter(
      domain => domain.startsWith(userDomain)
    );

    if (matchedDomains.length > 0) {
      const suggestionList = matchedDomains
        .map(domain => `<div class="suggestion">${domain}</div>`)
        .join('');
      suggestionsElement.innerHTML = suggestionList;
      suggestionsElement.style.display = 'block'; // Show the suggestions box
    } else {
      suggestionsElement.innerHTML = ''; // No matches, so clear the suggestions
      suggestionsElement.style.display = 'none'; // Hide the suggestions box
    }
  } else {
    suggestionsElement.innerHTML = ''; // No "@" symbol, so clear the suggestions
    suggestionsElement.style.display = 'none'; // Hide the suggestions box
  }
}


// Function to fill the input box with the clicked domain
function selectDomain(domain, inputElement, suggestionsElement) {
  inputElement.value = inputElement.value.replace(/[^@]+$/, '') + domain;
  suggestionsElement.innerHTML = '';
}

// Get references to the input box and suggestions container
const emailInput = document.getElementById('email');
const emailSuggestions = document.getElementById('emailSuggestions');

// Listen for input events on the email input box
emailInput.addEventListener('input', function() {
  suggestEmailDomains(emailInput, emailSuggestions);
});

// Listen for click events on the suggestions container
emailSuggestions.addEventListener('click', function(event) {
  if (event.target.classList.contains('suggestion')) {
    selectDomain(event.target.textContent, emailInput, emailSuggestions);
  }
});

// Function to fill the input box with the clicked domain
function selectDomain(domain, inputElement, suggestionsElement) {
  inputElement.value = inputElement.value.replace(/[^@]+$/, '') + domain;
  suggestionsElement.innerHTML = '';
  suggestionsElement.style.display = 'none'; // Hide the suggestions box after selection
}

