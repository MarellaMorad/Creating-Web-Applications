/**
* Author: Marella Morad
* Target: apply.php
* Purpose: Add Form Validation to the apply.php file
* Created: 11/04/2023
* Last Updated: 21/04/2023 8:00:00 PM
* Credits: 
*/

"use strict"; //prevents creation of global variables in functions

/* 
 FormField class to group all relevant fields + functions into one variable: 
 i.e. the input field, the error span, and the validation function as well as adding the input event listener
*/
class FormField {
    constructor(inputId) {
        this.input = document.getElementById(inputId);
    }
}

/**
 * This function is part of my enhancements, it filters the skills checkboxes based on the selected job reference number:
 * swetw, bdatw, and an empty string
 */
function filterSkillsList(refNumValue, bdaSkillsFieldset, sweSkillsFieldset) {
    sweSkillsFieldset.style.display = (refNumValue === "swetw" || refNumValue === "" || refNumValue === null) ? "" : "none";
    bdaSkillsFieldset.style.display = (refNumValue === "bdatw" || refNumValue === "" || refNumValue === null) ? "" : "none";
}

/**
 * Returns either a checkbox object (if a gender has been selected), or null (if nothing is selected)
 */
function getSelectedGender(genderRadioButtons) {
    const selectedGenderButton = genderRadioButtons.find(button => button.checked);
    return selectedGenderButton ? selectedGenderButton.value : null;
}

/**
 * Store the entered details in sessionStorage to allow prefill while the user is in the same browser session
 */
function storePersonInfo(refNum, firstName, lastName, dob, genderRadioButtons, street, suburb, state, postcode, email,
    mobile, otherSkillsDesc) {
    sessionStorage.refNum = refNum;
    sessionStorage.firstName = firstName;
    sessionStorage.lastName = lastName;
    sessionStorage.dob = dob;
    //store selected gender
    sessionStorage.gender = getSelectedGender(genderRadioButtons);
    sessionStorage.street = street;
    sessionStorage.suburb = suburb;
    sessionStorage.state = state;
    sessionStorage.postcode = postcode;
    sessionStorage.email = email;
    sessionStorage.mobile = mobile;
    //store selected skills
    const checkboxes = document.getElementsByName("skills[]");
    const checkedSkills = [];

    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checkedSkills.push(checkboxes[i].value);
        }
    }

    const combinedSkills = checkedSkills.join(", ");
    sessionStorage.skills = combinedSkills;

    sessionStorage.otherSkillsDesc = otherSkillsDesc;
}

/**
 * Prefill the job reference number based on the user selection from the jobs.php page (stored in localStorage)
 */
function prefill_refNum(refNumInput, bdaSkillsFieldset, sweSkillsFieldset) {
    const bdaCheckboxes = bdaSkillsFieldset.getElementsByTagName("input");
    const sweCheckboxes = sweSkillsFieldset.getElementsByTagName("input");
    const storedRefNum = localStorage.getItem("storedRefNum");

    if (storedRefNum != undefined) {
        refNumInput.value = storedRefNum; //display the stored value
        refNumInput.disabled = true; //make the field readonly
        sessionStorage.skills = "";

        // clears the checkboxes if the job reference number changes
        if (storedRefNum == "bdatw") {
            Array.from(sweCheckboxes).forEach((checkbox) => {
                if (checkbox.type === 'checkbox') {
                    checkbox.checked = false; // uncheck the checkbox
                }
            });
        } else if (storedRefNum == "swetw") {
            Array.from(bdaCheckboxes).forEach((checkbox) => {
                if (checkbox.type === 'checkbox') {
                    checkbox.checked = false; // uncheck the checkbox
                }
            });
        }
    } else {
        refNumInput.value = sessionStorage.refNum != undefined ? sessionStorage.refNum : "";
        refNumInput.disabled = false;
    }

    filterSkillsList(storedRefNum, bdaSkillsFieldset, sweSkillsFieldset);
}

/**
 * Check if session data on user exists and if so prefills the form
 */
function prefill_form(firstNameField, lastNameField, dobField, genderRadioButtons, streetField, suburbField, stateField, postcodeField,
    emailField, mobileField, otherSkillsDescField) {
    if (sessionStorage.refNum != undefined) {
        //prefill the form
        firstNameField.input.value = sessionStorage.firstName;
        lastNameField.input.value = sessionStorage.lastName;
        dobField.input.value = sessionStorage.dob;
        switch (sessionStorage.gender) {
            case "female":
                genderRadioButtons.forEach((radioButton) => {
                    radioButton.checked = (radioButton.id === "female");
                });
                break;
            case "male":
                genderRadioButtons.forEach((radioButton) => {
                    radioButton.checked = (radioButton.id === "male");
                });
                break;
            default:
                genderRadioButtons.forEach((radioButton) => {
                    radioButton.checked = false;
                });
                break;
        }
        streetField.input.value = sessionStorage.street;
        suburbField.input.value = sessionStorage.suburb;
        stateField.input.value = sessionStorage.state;
        postcodeField.input.value = sessionStorage.postcode;
        emailField.input.value = sessionStorage.email;
        mobileField.input.value = sessionStorage.mobile;
        // Get the string of skills from sessionStorage
        const skillsString = sessionStorage.getItem('skills');

        // Convert the string into an array using the split() method
        const skillsArray = skillsString.split(', ');

        // Loop through the checkboxes and tick the ones that have been stored
        const checkboxes = document.getElementsByName("skills[]");
        checkboxes.forEach((checkbox) => {
            if (skillsArray.includes(checkbox.value)) {
                checkbox.checked = true;
            }
        });
        otherSkillsDescField.input.value = sessionStorage.otherSkillsDesc;
    }
}

function init() {
    // RUN functions from enhancements.js
    // Add a listener for window resize events
    window.addEventListener("resize", adjustMenu);

    // Call the adjustMenu function to set the initial state of the navigation items
    adjustMenu();
    // Call the setActivePage function to apply styling to the active page
    setActivePage();

    //activate the back to top button
    const backToTopButton = document.getElementsByClassName("back-to-top");
    window.addEventListener("scroll", () => {
        if (window.scrollY > 100) {
            backToTopButton[0].classList.remove("hidden");
        } else {
            backToTopButton[0].classList.add("hidden");
        }
    });

    backToTopButton[0].addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

    //stores the reference number from jobs.php
    if (document.title == "Available Positions") {
        document.getElementById("bda-apply").onclick = function () {
            window.localStorage.setItem("storedRefNum", "bdatw");
        };
        document.getElementById("swe-apply").onclick = function () {
            window.localStorage.setItem("storedRefNum", "swetw");
        };
    }

    // loads the reference number, and applies validation in apply.php 
    else if (document.title == "Application of Interest") {
        // register input listeners to make validation responsive to user input (not only on submit)

        // create variables to store all form fields
        const bdaSkillsFieldset = document.getElementById("bda-skills");
        const sweSkillsFieldset = document.getElementById("swe-skills");
        const refNumField = new FormField("reference-number");
        refNumField.input.addEventListener("input", function () {
            filterSkillsList(this.value, bdaSkillsFieldset, sweSkillsFieldset);
        });
        const firstNameField = new FormField("first-name");
        const lastNameField = new FormField("last-name");
        const dobField = new FormField("dob");
        const genderRadioButtons = Array.from(document.getElementsByName("gender"));
        const streetField = new FormField("street");
        const suburbField = new FormField("suburb");
        const stateField = new FormField("state");
        const postcodeField = new FormField("postcode");
        const emailField = new FormField("email");
        const mobileField = new FormField("mobile");
        const otherSkillsDescField = new FormField("other-skills-desc");

        // prefill the reference number - if exists in localStorage
        prefill_refNum(refNumField.input, bdaSkillsFieldset, sweSkillsFieldset);

        // prefill the rest of the form - from sessionStorage
        prefill_form(firstNameField, lastNameField, dobField, genderRadioButtons, streetField, suburbField, stateField, postcodeField,
            emailField, mobileField, otherSkillsDescField);

        //register the event listener to the form submission
        const applicationForm = document.getElementById("application-form");
        applicationForm.onsubmit = function (event) {
            event.preventDefault(); // prevent the form from being submitted to the server by default

            // if all validations pass
            // store the person prefill info in session storage by calling the storePersonInfo function
            storePersonInfo(refNumField.input.value, firstNameField.input.value, lastNameField.input.value, dobField.input.value,
                genderRadioButtons, streetField.input.value, suburbField.input.value, stateField.input.value, postcodeField.input.value, emailField.input.value,
                mobileField.input.value, otherSkillsDescField.input.value);

            //save ref number to hidden element if the reference number select is read-only so that we pass the right value to the server
            const hiddenRefNumField = document.getElementById("job-reference-number");

            //if the job reference number was set from jobs.php (localStorage)
            if (refNumField.input.disabled) {
                hiddenRefNumField.value = refNumField.input.value;
            } else {
                //only pass the value of the hidden input, if the other input is readonly, otherwise, disabled it
                hiddenRefNumField.disabled = true;
            }

            //after completing all the steps successfully, submit the form to the server
            applicationForm.submit();
        };

        // When the Reset button is clicked
        applicationForm.onreset = function () {
            filterSkillsList(refNumField.value, bdaSkillsFieldset, sweSkillsFieldset); // filter the skills list - to show everything
            //Note: I chose to clear both the sessionStorage and localStorage on clear for better user experience, as it will not make sense 
            //to keep showing values after the user clicks on reset
            sessionStorage.clear(); // clear the sessionStorage
            localStorage.clear();// clear the localStorage
            prefill_refNum(refNumField.input, bdaSkillsFieldset, sweSkillsFieldset); //refill the reference number - or reset it to Please Select
        };
    }
}

window.onload = init;
