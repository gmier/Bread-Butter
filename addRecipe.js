// Giovanina Mier
// CS 304 Final Project
// Bread & Butter
//
// JQuery/JS function to dynamically add and delete text 
// inputs on the recipebox Add Recipe form.
// Code adapted from: 
// http://www.sanwebe.com/2013/03/addremove-input-fields-dynamically-with-jquery

// FOR INGREDIENTS INPUT FIELDS
$(document).ready(function() {
    var max_fields = 20; //maximum input boxes allowed
    var wrapper = $(".ingredient-fields-wrap"); //Fields wrapper
    var add_button = $(".add-ingredient-button"); //Add button ID
    var name = "ingredients[]";

    var init_fields = 1; //initial text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(init_fields < max_fields){ //max input box allowed
            init_fields++; //text box increment
            $(wrapper).append('<div><input type="text" name="'+name+'"/>'
		+ '<a href="#" class="remove_field">X</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); init_fields--;
    })
});

// FOR EQUIPMENT INPUT FIELDS
$(document).ready(function() {
    var max_fields = 20; //maximum input boxes allowed
    var wrapper = $(".equipment-fields-wrap"); //Fields wrapper
    var add_button = $(".add-equipment-button"); //Add button ID
    var name = "equipment[]";

    var init_fields = 1; //initial text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(init_fields < max_fields){ //max input box allowed
            init_fields++; //text box increment
            $(wrapper).append('<div><input type="text" name="'+name+'"/>'
        + '<a href="#" class="remove_field">X</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); init_fields--;
    })
});