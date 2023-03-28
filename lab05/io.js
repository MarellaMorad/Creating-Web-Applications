/**
 * Author: Marella Morad
 * Target: clickme.html
 * Purpose: To create a function for when the button on the clickme page is clicked
 * Created: 28/03/2023 
 * Last updated: 28/03/2023
 * Credits: Lecture notes and lab notes
 */

"use strict"; //prevents creation of global variables in functions

//function to prompt the user to enter their name
function promptName() {
    var sName = prompt("Enter your name.\nThis prompt should show up when the\nClick Me button is clicked.", "Your name"); //second parameter is a placeholder

    alert("Hi there " + sName + ". Alert boxes are a quick way to check the state\n of your variables when you are developing code.");

    rewriteParagraph(sName);
}

//function to override the text in the first p tag
function rewriteParagraph(userName) {
    //1. get a reference to the element with id “message” and assign it to a local variable
    var message = document.getElementById("message");
    // 2. write text to the html page using the innerHTML property
    message.innerHTML = "Hi " + userName + ". If you can see this you have successfully overwritten the contents of this paragraph. Congratulations!!";

}

//function to write a message in the span with id=newmessage
function writeNewMessage() {
    var newMessageContainer = document.getElementById("newmessage");
    newMessageContainer.textContent = "You have now finished Task 1";
}

// this function is called when the browser window loads
// it will register functions that will respond to browser events
function init() { 
    var clickMe = document.getElementById("clickme");
    clickMe.onclick = promptName;

    var h1 = document.getElementsByTagName("h1");
    h1[0].onclick = writeNewMessage;
}

window.onload = init;