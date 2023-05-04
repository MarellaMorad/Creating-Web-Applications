/**
* Author: Marella Morad
* Target: apply.html
* Purpose: Add Form Validation to the apply.html file
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
    constructor(inputId, errId, validateFn) {
        this.input = document.getElementById(inputId);
        this.errSpan = document.getElementById(errId);
        this.validate = validateFn.bind(this);
        this.input.addEventListener("input", this.validate);
    }
}

/**
 * This is a helper function called in almost all other validation functions.
 * It is used to validate that a required input field has a value
 * It also has the ability to check a regex expression if needed
 *  The regex and regexErrMsg are used as default parameters, so that this function can be called without passing them.
 */
function validateInput(inputElement, errorElement, errorMessage, regex = "", regexErrMsg = "") {
    if (inputElement.value === "") {
        inputElement.classList.add("invalid");
        errorElement.textContent = errorMessage;
        return false;
    } else if (regex != "" && !(regex.test(inputElement.value))) {
        inputElement.classList.add("invalid");
        errorElement.textContent = regexErrMsg;
        return false;
    }
    else {
        inputElement.classList.remove("invalid");
        errorElement.textContent = "";
        return true;
    }
}

/**
 * To validate the Job Reference Number
 * Note: I changed the job reference number to a dropdown, for usability reasons, to allow the users to select the relevant job instead of having to memorize and enter the reference number
 * Also, to have better form inputs 
 */
function validateJobRefNum(refNumInput, refNumErrSpan, bdaSkillsFieldset, sweSkillsFieldset) {
    const errMsg = "Please Select a Job Reference Number from the list.";
    if (!validateInput(refNumInput, refNumErrSpan, errMsg)) {
        return false;
    }
    filterSkillsList(refNumInput.value, bdaSkillsFieldset, sweSkillsFieldset);
    return true;
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
 * To validate a name input (called on both First name and Last name inputs)
 *  Checks for alphabetical characters only and max 20 characters
 */
function validateName(nameInput, nameErrSpan, nameType) {
    const errMsg = `Please enter your ${nameType}.`; //using template literals to customize the error message
    const regexErrMsg = "You can only use alphabetical characters";
    const nameRegex = /^[A-Za-z]+$/;
    if (!validateInput(nameInput, nameErrSpan, errMsg, nameRegex, regexErrMsg)) {
        return false;
    } else {
        const name = nameInput.value;

        if (name.length > 20) {
            nameInput.classList.add("invalid");
            nameErrSpan.textContent = "You have reached the maximum number of characters - max 20 characters";
            return false;
        } else {
            nameInput.classList.remove("invalid");
            nameErrSpan.textContent = "";
            return true;
        }
    }
}

/**
 * To validate the date of birth
 *  Checks for valid date format dd/mm/yyyy and age between 15 and 80
 */
function validateDOB(dobInput, dobErrSpan) {
    const errMsg = "Please Enter your Date of Birth.";
    const dateRegex = /^(0?[1-9]|[1-2][0-9]|3[0-1])\/(0?[1-9]|1[0-2])\/([0-9]{4})$/;
    const regexErrMsg = "Please Enter a valid Date follow this pattern dd/mm/yyyy";
    if (!validateInput(dobInput, dobErrSpan, errMsg, dateRegex, regexErrMsg)) {
        return false;
    } else {
        // Split the date of birth input value by the forward slash delimiter to create an array of day, month, and year.
        var dob = dobInput.value.split("/");
        // Create a new Date object using the year, month, and day from the input value. 
        // Subtract 1 from the month value to account for JavaScript's zero-indexed months.
        var dobDate = new Date(dob[2], dob[1] - 1, dob[0]);
        // Create a new Date object with the current date and time.
        var today = new Date();
        // Calculate the age by subtracting the input date from the current date in milliseconds. 
        // Divide by the number of milliseconds in a year to get the age in years, rounded down to the nearest integer.
        var age = Math.floor((today.getTime() - dobDate.getTime()) / (1000 * 60 * 60 * 24 * 365.25));

        // Validate if the age is between 15 and 80
        if (age < 15 || age > 80) {
            dobInput.classList.add("invalid");
            dobErrSpan.textContent = "Applicants must be at between 15 and 80 years old at the time they fill in the form";
            return false;
        } else {
            dobInput.classList.remove("invalid");
            dobErrSpan.textContent = "";
            return true;
        }
    }
}

/**
 * To validate the gender field
 *  Checks if one of the gender radio buttons have been selected
 */
function validateGender(genderRadioButtons, genderFieldSet, genderErrSpan) {
    var selectedGender = getSelectedGender(genderRadioButtons);

    if (selectedGender === null) {
        genderFieldSet.classList.add("invalid");
        genderErrSpan.textContent = "Please select your Gender.";
        return false;
    } else {
        genderFieldSet.classList.remove("invalid");
        genderErrSpan.textContent = "";
        return true;
    }
}

/**
 * Returns either a checkbox object (if a gender has been selected), or null (if nothing is selected)
 * Used in the validateGender function to help with the validation process.
 */
function getSelectedGender(genderRadioButtons) {
    const selectedGenderButton = genderRadioButtons.find(button => button.checked);
    return selectedGenderButton ? selectedGenderButton.value : null;
}

/**
 * To validate the address inputs (called on both the Street Address and Suburb/Town fields)
 */
function validateAddress(addressInput, addressErrSpan, addressType) {
    const errMsg = `Please enter your ${addressType}.`;
    if (!validateInput(addressInput, addressErrSpan, errMsg)) {
        return false;
    } else if (addressInput.value.length > 40) {
        addressInput.classList.add("invalid");
        addressErrSpan.textContent = "You have reached the maximum number of character - max 40 characters";
        return false;
    } else {
        addressInput.classList.remove("invalid");
        addressErrSpan.textContent = "";
        return true;
    }
}

/**
 * To validate the State input
 */
function validateState(stateSelect, stateErrSpan) {
    const errMsg = "Please select your State.";
    return validateInput(stateSelect, stateErrSpan, errMsg);
}

/**
 * To validate the Postcode input
 *  Checks if the input is exactly 4 digits long
 */
function validatePostcode(postcodeInput, postcodeErrSpan) {
    const errMsg = "Please enter your Postcode.";
    const regexErrMsg = "The Postcode you entered is invalid - postcodes should be exactly 4 digits.";
    const postcodeRegex = /^\d{4}$/;
    if (!validateInput(postcodeInput, postcodeErrSpan, errMsg, postcodeRegex, regexErrMsg)) {
        return false;
    }
    postcodeInput.classList.remove("invalid");
    postcodeErrSpan.textContent = "";
    return true;
}

/**
 * Runs the validation that links Postcode to State
 *  Initially checks that both inputs are valid before running the extra check on whether they are correct
 */
function validateStatePostcode(stateSelect, stateErrSpan, postcodeInput, postcodeErrSpan) {
    const validState = validateState(stateSelect, stateErrSpan);
    const validPostcode = validatePostcode(postcodeInput, postcodeErrSpan);

    if (!validState || !validPostcode) {
        return false;
    }
    const postcode = postcodeInput.value;
    const statePrefix = {
        "vic": [3, 8],
        "nsw": [1, 2],
        "qld": [4, 9],
        "nt": [0],
        "wa": [6],
        "sa": [5],
        "tas": [7],
        "act": [0]
    };
    const prefix = statePrefix[stateSelect.value];

    // Check if the postcode starts with a valid prefix for the selected state
    if (!prefix.some(p => postcode.startsWith(p))) {
        // If the postcode is invalid, mark the postcode input as invalid and display an error message, and return false to indicate validation failure.
        postcodeInput.classList.add("invalid");
        postcodeErrSpan.textContent = `Please enter a valid postcode - ${stateSelect.value.toUpperCase()} postcodes start with ${prefix.join(' or ')}.`;
        return false;
    }

    postcodeInput.classList.remove("invalid");
    postcodeErrSpan.textContent = "";
    return true;
}

/**
 * To validate the email address existence and format
 */
function validateEmail(emailInput, emailErrSpan) {
    const errMsg = "Please enter your Email Address.";
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const regexErrMsg = "Please enter a valid Email Address - for example: JohnSmith@gmail.com";
    return validateInput(emailInput, emailErrSpan, errMsg, emailRegex, regexErrMsg);
}

/**
 * To validate the mobile number
 *  Checks if the phone number is 8 - 12 digits or spaces
 */
function validateMobileNumber(mobileInput, mobileErrSpan) {
    const errMsg = "Please enter your Mobile Phone Number.";
    const mobileRegex = /^[0-9 ]{8,12}$/;
    const regexErrMsg = "8 to 12 digits, or spaces";
    return validateInput(mobileInput, mobileErrSpan, errMsg, mobileRegex, regexErrMsg);
}

/**
 * To validate the Other Skills description field
 *  Only validates if the other skills checkbox is ticked
 */
function validateOtherSkillsDesc(otherSkillsDescField, otherSkillsDescErrSpan, otherSkills) {
    if (otherSkills && otherSkillsDescField.value === '') {
        otherSkillsDescField.classList.add("invalid");
        otherSkillsDescErrSpan.textContent = "Please enter a short description of your Other Skills.";
        return false;
    }
    otherSkillsDescField.classList.remove("invalid");
    otherSkillsDescErrSpan.textContent = "";
    return true;
}

/**
 * Calls all the validations
 * This function will run on form submit
 */
function runAllValidations(refNumSelect, refNumErrSpan, bdaSkillsFieldset, sweSkillsFieldset, firstNameInput, firstNameErrSpan,
    lastNameInput, lastNameErrSpan, dobInput, dobErrSpan, genderRadioButtons, genderFieldSet, genderErrSpan, streetAddressInput,
    streetAddressErrSpan, townInput, townErrSpan, stateSelect, stateErrSpan, postcodeInput, postcodeErrSpan, emailInput,
    emailErrSpan, mobileInput, mobileErrSpan, otherSkillsDescField, otherSkillsDescErrSpan, otherSkills) {

    var isValid = validateJobRefNum(refNumSelect, refNumErrSpan, bdaSkillsFieldset, sweSkillsFieldset);
    isValid = validateName(firstNameInput, firstNameErrSpan, "First Name") && isValid;
    isValid = validateName(lastNameInput, lastNameErrSpan, "Last Name") && isValid;
    isValid = validateDOB(dobInput, dobErrSpan) && isValid;
    isValid = validateGender(genderRadioButtons, genderFieldSet, genderErrSpan) && isValid;
    isValid = validateAddress(streetAddressInput, streetAddressErrSpan, "Street Address") && isValid;
    isValid = validateAddress(townInput, townErrSpan, "Suburb/town") && isValid;
    isValid = validateStatePostcode(stateSelect, stateErrSpan, postcodeInput, postcodeErrSpan) && isValid;
    isValid = validateEmail(emailInput, emailErrSpan) && isValid;
    isValid = validateMobileNumber(mobileInput, mobileErrSpan) && isValid;
    isValid = validateOtherSkillsDesc(otherSkillsDescField, otherSkillsDescErrSpan, otherSkills) && isValid;

    return isValid;
}

/**
 * Store the entered details in sessionStorage to allow prefill while the user is in the same browser session
 */
function storePersonInfo(refNum, firstName, lastName, dob, genderRadioButtons, street, town, state, postcode, email,
    mobile, otherSkillsDesc) {
    sessionStorage.refNum = refNum;
    sessionStorage.firstName = firstName;
    sessionStorage.lastName = lastName;
    sessionStorage.dob = dob;
    //store selected gender
    sessionStorage.gender = getSelectedGender(genderRadioButtons);
    sessionStorage.street = street;
    sessionStorage.town = town;
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
 * Prefill the job reference number based on the user selection from the jobs.html page (stored in localStorage)
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
function prefill_form(firstNameField, lastNameField, dobField, genderRadioButtons, streetField, townField, stateField, postcodeField,
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
        townField.input.value = sessionStorage.town;
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

    //stores the reference number from jobs.html
    if (document.title == "Available Positions") {
        document.getElementById("bda-apply").onclick = function () {
            window.localStorage.setItem("storedRefNum", "bdatw");
        };
        document.getElementById("swe-apply").onclick = function () {
            window.localStorage.setItem("storedRefNum", "swetw");
        };
    }

    // loads the reference number, and applies validation in apply.html 
    else if (document.title == "Application of Interest") {
        // register input listeners to make validation responsive to user input (not only on submit)

        // create variables to store all form fields
        // As part of creating the variables, we add the validate function which is called by the addEventListener on the "input" event
        const bdaSkillsFieldset = document.getElementById("bda-skills");
        const sweSkillsFieldset = document.getElementById("swe-skills");
        const refNumField = new FormField("reference-number", "reference-number-err", function () {
            validateJobRefNum(this.input, this.errSpan, bdaSkillsFieldset, sweSkillsFieldset);
        });
        const firstNameField = new FormField("first-name", "first-name-err", function () {
            validateName(this.input, this.errSpan, "First Name");
        });
        const lastNameField = new FormField("last-name", "last-name-err", function () {
            validateName(this.input, this.errSpan, "Last Name");
        });
        const dobField = new FormField("dob", "dob-err", function () {
            validateDOB(this.input, this.errSpan);
        });
        const genderRadioButtons = Array.from(document.getElementsByName("gender"));
        const genderFieldSet = document.getElementById("gender");
        const genderErrSpan = document.getElementById("gender-err");
        genderRadioButtons.forEach((radioButton) => {
            radioButton.addEventListener('change', function () {
                validateGender(genderRadioButtons, genderFieldSet, genderErrSpan);
            });
        });
        const streetField = new FormField("street", "street-err", function () {
            validateAddress(this.input, this.errSpan, "Street Address");
        });
        const townField = new FormField("town", "town-err", function () {
            validateAddress(this.input, this.errSpan, "Suburb/town");
        });
        const stateField = new FormField("state", "state-err", function () {
            validateStatePostcode(this.input, this.errSpan, postcodeField.input, postcodeField.errSpan);
        });
        const postcodeField = new FormField("postcode", "postcode-err", function () {
            validateStatePostcode(stateField.input, stateField.errSpan, this.input, this.errSpan);
        });
        const emailField = new FormField("email", "email-err", function () {
            validateEmail(this.input, this.errSpan);
        });
        const mobileField = new FormField("mobile", "mobile-err", function () {
            validateMobileNumber(this.input, this.errSpan);
        });
        const otherSkills = document.getElementById("other-skills");
        const otherSkillsDescField = new FormField("other-skills-desc", "other-skills-desc-err", function () {
            validateOtherSkillsDesc(this.input, this.errSpan, otherSkills.checked);
        });
        otherSkills.addEventListener("change", function () {
            validateOtherSkillsDesc(otherSkillsDescField.input, otherSkillsDescField.errSpan, this.checked);
        });

        // prefill the reference number - if exists in localStorage
        prefill_refNum(refNumField.input, bdaSkillsFieldset, sweSkillsFieldset);

        // prefill the rest of the form - from sessionStorage
        prefill_form(firstNameField, lastNameField, dobField, genderRadioButtons, streetField, townField, stateField, postcodeField,
            emailField, mobileField, otherSkillsDescField);

        //register the event listener to the form submission
        const applicationForm = document.getElementById("application-form");
        applicationForm.onsubmit = function (event) {
            event.preventDefault(); // prevent the form from being submitted to the server by default

            const isValid = runAllValidations(
                refNumField.input, refNumField.errSpan, bdaSkillsFieldset, sweSkillsFieldset,
                firstNameField.input, firstNameField.errSpan, lastNameField.input, lastNameField.errSpan,
                dobField.input, dobField.errSpan, genderRadioButtons, genderFieldSet, genderErrSpan,
                streetField.input, streetField.errSpan, townField.input, townField.errSpan, stateField.input,
                stateField.errSpan, postcodeField.input, postcodeField.errSpan, emailField.input, emailField.errSpan,
                mobileField.input, mobileField.errSpan, otherSkillsDescField.input, otherSkillsDescField.errSpan,
                otherSkills.checked
            );

            // show a warning box if the runAllValidations function returns false
            const warningBox = document.getElementById("warning");
            const warningContent = document.getElementById("warning-content");

            if (!isValid) {
                // if not valid scroll to the top of the screen and display the warning box
                window.scrollTo(0, 0);
                warningContent.textContent = "Some Items Require Your Attention!";
                warningBox.style.display = "flex";

                const closeButton = document.getElementById("close-warning");
                closeButton.addEventListener('click', function () {
                    warningBox.style.display = 'none';
                });
            } else {
                // if all validations pass
                // store the person prefill info in session storage by calling the storePersonInfo function
                storePersonInfo(refNumField.input.value, firstNameField.input.value, lastNameField.input.value, dobField.input.value,
                    genderRadioButtons, streetField.input.value, townField.input.value, stateField.input.value, postcodeField.input.value, emailField.input.value,
                    mobileField.input.value, otherSkillsDescField.input.value);

                //save ref number to hidden element if the reference number select is read-only so that we pass the right value to the server
                const hiddenRefNumField = document.getElementById("job-reference-number");

                //if the job reference number was set from jobs.html (localStorage)
                if (refNumField.input.disabled) {
                    hiddenRefNumField.value = refNumField.input.value;
                } else {
                    //only pass the value of the hidden input, if the other input is readonly, otherwise, disabled it
                    hiddenRefNumField.disabled = true;
                }

                //after completing all the steps successfully, submit the form to the server
                applicationForm.submit();
            }
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
