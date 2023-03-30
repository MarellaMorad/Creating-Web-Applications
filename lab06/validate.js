/**
 * Author: Marella Morad
 * Target: register.html
 * Purpose: To create validate the form on register.html page
 * Created: 29/03/2023 
 * Last updated: 29/03/2023
 * Credits: Lecture notes and lab notes
 */

"use strict"; //prevents creation of global variables in functions

//get regform inputs and validate them
function validate() {
    //initialise local variables
    var errMsg = ""; // stores the error message
    var result = true; // assumes no errors

    //get the values of the form from each of the respective elements
    var firstName = document.getElementById("firstname").value;
    var lastName = document.getElementById("lastname").value;
    var age = document.getElementById("age").value;
    var partySize = document.getElementById("partySize").value;
    var food = document.getElementById("food").value;
    //trip options
    var is1day = document.getElementById("1day").checked;
    var is4day = document.getElementById("4day").checked;
    var is10day = document.getElementById("10day").checked;

    if (!firstName.match(/^[a-zA-Z]+$/)) { //regex for not empty and contains only alpha characters.
        errMsg += "Your firstname must not be empty and must only contain alpha characters\n";
        result = false;
    }

    if (!lastName.match(/^[a-zA-Z-]+$/)) { //regex for not empty and contains onlyalpha characters or a hyphen
        errMsg += "Your lastname must not be empty and must only contain alpha characters or a hyphen\n";
        result = false;
    }

    /* at least one species selected */
    if(getSpecies() == "Unknown") {
        errMsg += "Please select at least one species.\n";
        result = false;
    }

    if(isNaN(age)) { //if age is not a number
        errMsg += "Your age must be a number\n";
        result = false;
    }
    else if (age < 18) {
        errMsg += "Your age must be 18 or older\n";
        result = false;
    }
    else if (age > 10000) {
        errMsg += "Your age must be less than 10,000\n";
        result = false;
    }
    else {
        var tempMsg = checkSpeciesAge(age);
        if (tempMsg != "") {
            errMsg += tempMsg;
            result = false;
        }
    }

    var beardLengthMsg = checkBeardLength(age);
    if (beardLengthMsg != "") {
        errMsg += beardLengthMsg;
        result = false
    }

    /* at least one trip selected */
    if(!(is1day || is4day || is10day)) {
        errMsg += "Please select at least one trip.\n";
        result = false;
    }

    if(food == "none") {
        errMsg += "You must select a food preference\n";
        result = false;
    }

    if(isNaN(partySize)) {
        errMsg += "The number of travellers must be a number\n";
        result = false;
    }
    else if(partySize < 1 || partySize > 100) {
        errMsg += "The number of travellers should be between 1 and 100\n";
        result = false;
    }

    if (errMsg != "") { //only display message box if there is sorEthing to show
        alert(errMsg);
    }

    return result; // if false the information will not be sent to the server
}

/* return the species selected as a string */
function getSpecies() {
    // initialise variable in case does not get reinitialised properly
    var speciesName = "Unknown";

    //get an array of all input elements inside the fieldset element with id="species"
    var speciesArray = document.getElementById("species").getElementsByTagName("input");
    for (var i = 0; i < speciesArray.length; i++) {
        if (speciesArray[i].checked) { // test if radio button is selected
            speciesName = speciesArray[i].value; // assign the value attribute
        }
    }
    return speciesName ;
}

/*if rule violated return error message*/
function checkSpeciesAge(age) {
    //assume the paramter age has been checked for general constraints e.g > 18
    var errMsg = "";
    var species = getSpecies();

    switch(species) {
        case "Human":
            if (age > 120) {
                errMsg = "You cannot be a Human and over 120.\n";
            }
            break;
        case "Dwarf":
        case "Hobbit":
            if (age > 150) {
                errMsg = "You cannot be a " + species + " and over 150.\n";
            }
            break;
        case "Elf":
            break;
        default:
            errMsg = "We don't allow your kind on our tours.\n";
    }
    return errMsg;
}

function checkBeardLength(age) {
    var beardLength = document.getElementById("beard").value;

    var errMsg = "";
    var species = getSpecies();

    switch(species) {
        case "Human":
        case "Dwarf":
            if (age < 30 && beardLength > 12) {
                errMsg = "You cannot be a " + species + " less than 30 years old and have a beard longer than 12 inches.\n";
            }
            break;
        case "Hobbit":
            if (beardLength > 0) {
                errMsg = "You cannot be a " + species + " and have a beard.\n";
            }
            break;
        case "Elf":
            if (beardLength > 0) {
                errMsg = "You cannot be an " + species + " and have a beard.\n";
            }
            break;
        default:
            errMsg = "We don't allow your kind on our tours.\n";
    }
    return errMsg;
}

// this function is called when the browser window loads
// it will register functions that will respond to browser events
function init() { 
    var regForm = document.getElementById("regform");
    regForm.onsubmit = validate;
}

window.onload = init;