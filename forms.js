// CS 304 Final Project
// Bread & Butter
// Giovanina Mier
// FILENAME: forms.js

// Sets the responses to clicks to open/close the description pop-up.
function setUpRegistration() {
    //when you click add recipe button, the abstract will appear
    $('#clickbutton').click(showRegistration); 
    //when you click the abstract, it will disappear 
    $('#instruction').click(function() { $('#registration').hide(); })
}

// Uses displayText method to fill description with appropriate text.
function showRegistration() {
	//text comes from abstract element
    var text = $('#registration').html();  
    displayText(text);
}

// Displays text from abstract class, with fade in.
function displayText(text) {
    $('#registration').html(text).fadeIn(100);
}
