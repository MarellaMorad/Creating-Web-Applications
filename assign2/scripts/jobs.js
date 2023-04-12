/**
* Author: Marella Morad
* Target: jobs.html
* Purpose: Add Form Validation to the apply.html file
* Created: 11/04/2023
* Last Updated: 13/04/2023 1:30:00 AM
* Credits: 
*/

function init() {
    //use functions from menu.js
    // Add a listener for window resize events
    window.addEventListener("resize", adjustMenu);

    // Call the adjustMenu function to set the initial state of the navigation items
    adjustMenu();
    setActivePage();

    const bdaApply = document.getElementById("bda-apply");
    bdaApply.onclick = function () {
        window.localStorage.setItem('positionRef', "bdatw");
    }

    const sweApply = document.getElementById("swe-apply");
    sweApply.onclick = function () {
        window.localStorage.setItem('positionRef', "swetw");
    }
}

window.onload = init;