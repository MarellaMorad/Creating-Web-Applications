/**
* Author: Marella Morad
* Target: apply.html
* Purpose: Add Form Validation to the apply.html file
* Created: 11/04/2023
* Last Updated: 12/04/2023 10:00:00 PM
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
    } else if (regex != "" && !regex.test(inputElement.value)) {
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

function validateJobRefNum(refNumInput, refNumErrSpan, bdaSkillsFieldset, seSkillsFieldset) {
    const errMsg = "Please Select a Job Reference Number from the list.";
    if (!validateInput(refNumInput, refNumErrSpan, errMsg)) {
        return false;
    }
    const refNumValue = refNumInput.value;
    seSkillsFieldset.style.display = (refNumValue === "se") ? "" : "none";
    bdaSkillsFieldset.style.display = (refNumValue === "bda") ? "" : "none";
    return true;
}

function validateName(nameInput, nameErrSpan, nameType) {
    const errMsg = "Please enter your ${nameType}.";
    const regexErrMsg = "You can only use alphabetical characters";
    const nameRegex = !/^[A-Za-z]+$/;
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
        postcodeErrSpan.textContent = "Please enter a valid postcode - ${stateSelect.value.toUpperCase()} postcodes start with ${prefix.join(' or ')}.";
        return false;
    }

    postcodeInput.classList.remove("invalid");
    postcodeErrSpan.textContent = "";
    return true;
}

function validateEmail(emailInput, emailErrSpan) {
    const errMsg = "Please enter your Email Address.";
    return validateInput(emailInput, emailErrSpan, errMsg);
}

function validateMobileNumber(mobileInput, mobileErrSpan) {
    const errMsg = "Please enter your Mobile Phone Number.";
    const mobileRegex = /^[0-9 ]{8,12}$/;
    const regexErrMsg = "8 to 12 digits, or spaces";
    return validateInput(mobileInput, mobileErrSpan, errMsg, mobileRegex, regexErrMsg);
}

function validateOtherSkillsDesc(otherSkillsDesc, otherSkillsDescErrSpan, otherSkills) {
    if (otherSkills && otherSkillsDesc.value === '') {
        otherSkillsDesc.classList.add("invalid");
        otherSkillsDescErrSpan.textContent = "Please enter a short description of your Other Skills.";
        return false;
    }
    otherSkillsDesc.classList.remove("invalid");
    otherSkillsDescErrSpan.textContent = "";
    return true;
}


function runAllValidations(refNumSelect, refNumErrSpan, bdaSkillsFieldset, seSkillsFieldset, firstnameInput, firstnameErrSpan,
    lastnameInput, lastnameErrSpan, dobInput, dobErrSpan, streetAddressInput, streetAddressErrSpan, townInput, townErrSpan,
    stateSelect, stateErrSpan, postcodeInput, postcodeErrSpan, emailInput, emailErrSpan, mobileInput, mobileErrSpan, otherSkillsDesc,
    otherSkillsDescErrSpan, otherSkills) {
    var isValid = validateJobRefNum(refNumSelect, refNumErrSpan, bdaSkillsFieldset, seSkillsFieldset);
    isValid = validateName(firstnameInput, firstnameErrSpan, "First Name") && isValid;
    isValid = validateName(lastnameInput, lastnameErrSpan, "Last Name") && isValid;
    isValid = validateDOB(dobInput, dobErrSpan) && isValid;
    isValid = validateAddress(streetAddressInput, streetAddressErrSpan, "Street Address") && isValid;
    isValid = validateAddress(townInput, townErrSpan, "Suburb/town") && isValid;
    isValid = validateStatePostcode(stateSelect, stateErrSpan, postcodeInput, postcodeErrSpan) && isValid;
    isValid = validateEmail(emailInput, emailErrSpan) && isValid;
    isValid = validateMobileNumber(mobileInput, mobileErrSpan) && isValid;
    isValid = validateOtherSkillsDesc(otherSkillsDesc, otherSkillsDescErrSpan, otherSkills) && isValid;

    if (!isValid) {
        alert("Some Item Require Your Attention!");
    }
    return isValid;
}

function init() {
    const bdaSkillsFieldset = document.getElementById("bda-skills");
    const seSkillsFieldset = document.getElementById("se-skills");

    const refNumField = new FormField("reference-number", "reference-number-err", function () {
        validateJobRefNum(this.input, this.errSpan, bdaSkillsFieldset, seSkillsFieldset);
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
    const otherSkillsDesc = new FormField("other-skills-desc", "other-skills-desc-err", function () {
        validateOtherSkillsDesc(this.input, this.errSpan, otherSkills.checked)
    })

    otherSkills.addEventListener("change", function () {
        validateOtherSkillsDesc(otherSkillsDesc.input, otherSkillsDesc.errSpan, this.checked)
    })

    const applicationForm = document.getElementById("application-form");
    applicationForm.onsubmit = function () {
        return runAllValidations(
            refNumField.input, refNumField.errSpan, bdaSkillsFieldset, seSkillsFieldset,
            firstNameField.input, firstNameField.errSpan, lastNameField.input, lastNameField.errSpan,
            dobField.input, dobField.errSpan, streetField.input, streetField.errSpan,
            townField.input, townField.errSpan, stateField.input, stateField.errSpan,
            postcodeField.input, postcodeField.errSpan, emailField.input, emailField.errSpan,
            mobileField.input, mobileField.errSpan, otherSkillsDesc.input, otherSkillsDesc.errSpan,
            otherSkills.checked
        );
    };
}

window.onload = init;
