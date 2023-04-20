/**
* Author: Marella Morad
* Target: apply.html
* Purpose: Add Form Validation to the apply.html file
* Created: 11/04/2023
* Last Updated: 17/04/2023 11:15:00 PM
* Credits: 
*/

"use strict";

class FormField {
    constructor(inputId, errId, validateFn) {
        this.input = document.getElementById(inputId);
        this.errSpan = document.getElementById(errId);
        this.validate = validateFn.bind(this);
        this.input.addEventListener("input", this.validate);
    }
}

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

function validateJobRefNum(refNumInput, refNumErrSpan, bdaSkillsFieldset, sweSkillsFieldset) {
    const errMsg = "Please Select a Job Reference Number from the list.";
    if (!validateInput(refNumInput, refNumErrSpan, errMsg)) {
        return false;
    }
    const refNumValue = refNumInput.value;

    filterSkillsList(refNumValue, bdaSkillsFieldset, sweSkillsFieldset);

    return true;
}

function filterSkillsList(refNumValue, bdaSkillsFieldset, sweSkillsFieldset) {
    sweSkillsFieldset.style.display = (refNumValue === "swetw") ? "" : "none";
    bdaSkillsFieldset.style.display = (refNumValue === "bdatw") ? "" : "none";
}

function validateName(nameInput, nameErrSpan, nameType) {
    const errMsg = `Please enter your ${nameType}.`;
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

function validateDOB(dobInput, dobErrSpan) {
    const errMsg = "Please Enter your Date of Birth.";
    const dateRegex = /^(0?[1-9]|[1-2][0-9]|3[0-1])\/(0?[1-9]|1[0-2])\/([0-9]{4})$/;
    const regexErrMsg = "Please Enter a valid Date follow this pattern dd/mm/yyyy";
    if (!validateInput(dobInput, dobErrSpan, errMsg, dateRegex, regexErrMsg)) {
        return false;
    } else {
        var dob = dobInput.value.split("/");
        var dobDate = new Date(dob[2], dob[1] - 1, dob[0]);
        var today = new Date();
        var age = Math.floor((today.getTime() - dobDate.getTime()) / (1000 * 60 * 60 * 24 * 365.25));
        if (age < 15 || age > 80) {
            dobInput.classList.add("invalid");
            dobErrSpan.textContent = "Applicants must be at between 15 and 80 years old at the time they fill in the form";
            return false;
        } else {
            dobInput.classList.remove("invalid");
            dobErrSpan.textContent = "";
            return true
        }
    }
}

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

function getSelectedGender(genderRadioButtons) {
    const selectedGenderButton = genderRadioButtons.find(button => button.checked);
    return selectedGenderButton ? selectedGenderButton.value : null;
}

function validateAddress(addressInput, addressErrSpan, addressType) {
    const errMsg = "Please enter your " + addressType + ".";
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

function validateState(stateSelect, stateErrSpan) {
    const errMsg = "Please select your State.";
    return validateInput(stateSelect, stateErrSpan, errMsg);
}

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
    if (!prefix.some(p => postcode.startsWith(p))) {
        postcodeInput.classList.add("invalid");
        postcodeErrSpan.textContent = `Please enter a valid postcode - ${stateSelect.value.toUpperCase()} postcodes start with ${prefix.join(' or ')}.`;
        return false;
    }

    postcodeInput.classList.remove("invalid");
    postcodeErrSpan.textContent = "";
    return true;
}

function validateEmail(emailInput, emailErrSpan) {
    const errMsg = "Please enter your Email Address.";
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const regexErrMsg = "Please enter a valid Email Address - for example: JohnSmith@gmail.com"
    return validateInput(emailInput, emailErrSpan, errMsg, emailRegex, regexErrMsg);
}

function validateMobileNumber(mobileInput, mobileErrSpan) {
    const errMsg = "Please enter your Mobile Phone Number.";
    const mobileRegex = /^[0-9 ]{8,12}$/;
    const regexErrMsg = "8 to 12 digits, or spaces";
    return validateInput(mobileInput, mobileErrSpan, errMsg, mobileRegex, regexErrMsg);
}

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

function prefill_refNum(refNumInput, bdaSkillsFieldset, sweSkillsFieldset) {
    const bdaCheckboxes = bdaSkillsFieldset.getElementsByTagName("input");
    const sweCheckboxes = sweSkillsFieldset.getElementsByTagName("input");
    const storedRefNum = localStorage.getItem("storedRefNum");

    if (storedRefNum != undefined) {
        //hidden input to submit details
        filterSkillsList(storedRefNum, bdaSkillsFieldset, sweSkillsFieldset);

        if (refNumInput.value != storedRefNum) {
            refNumInput.value = storedRefNum;
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
        }
        refNumInput.disabled = true;
    } else {
        refNumInput.disabled = false;
    }
}
// check if session data on user exists and if so prefill the form
function prefill_form(refNumField, firstNameField, lastNameField, dobField, genderRadioButtons, streetField, townField, stateField, postcodeField,
    emailField, mobileField, otherSkillsDescField) {
    if (sessionStorage.refNum != undefined) {
        //save ref number to hidden element
        const hiddenRefNumField = document.getElementById("job-reference-number");
        hiddenRefNumField.value = sessionStorage.refNum;
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
    //use functions from menu.js
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
        }
        document.getElementById("swe-apply").onclick = function () {
            window.localStorage.setItem("storedRefNum", "swetw");
        }
    }
    // loads the reference number, and applies validation in apply.html 
    else if (document.title == "Application of Interest") {
        //register input listeners to make validation responsive to user input (not only on submit)
        //start validating form fields
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
            validateOtherSkillsDesc(this.input, this.errSpan, otherSkills.checked)
        });

        otherSkills.addEventListener("change", function () {
            validateOtherSkillsDesc(otherSkillsDescField.input, otherSkillsDescField.errSpan, this.checked)
        });

        prefill_refNum(refNumField.input, bdaSkillsFieldset, sweSkillsFieldset);
        prefill_form(refNumField, firstNameField, lastNameField, dobField, genderRadioButtons, streetField, townField, stateField, postcodeField,
            emailField, mobileField, otherSkillsDescField);
        //register the event listener to the form
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

            const warningBox = document.getElementById("warning");
            const warningContent = document.getElementById("warning-content");

            if (!isValid) {
                window.scrollTo(0, 0);
                warningContent.textContent = "Some Items Require Your Attention!";
                warningBox.style.display = "flex";

                const closeButton = document.getElementById("close-warning");
                closeButton.addEventListener('click', function () {
                    warningBox.style.display = 'none';
                });
            } else {
                storePersonInfo(refNumField.input.value, firstNameField.input.value, lastNameField.input.value, dobField.input.value,
                    genderRadioButtons, streetField.input.value, townField.input.value, stateField.input.value, postcodeField.input.value, emailField.input.value,
                    mobileField.input.value, otherSkillsDescField.input.value);
                applicationForm.submit();
                applicationForm.reset();
            }
        }

        applicationForm.onreset = function () {
            sessionStorage.clear();
            localStorage.clear();
            prefill_refNum(refNumField.input, bdaSkillsFieldset, sweSkillsFieldset);
        }
    }
}

window.onload = init;
