/**
* Author: Marella Morad
* Target: apply.html
* Purpose: Add Form Validation to the apply.html file
* Created: 11/04/2023
* Last Updated: 11/04/2023 5:58:00 AM
* Credits: 
*/

"use strict"; //prevents creation of global variables in functions

var valid = true;

function validateJobRefNum(refNumInput, refNumErrSpan, bdaSkillsFieldset, seSkillsFieldset) {
    const errMsg = "Please Select a Job Reference Number from the list.";
    if (!hasValue(refNumInput, refNumErrSpan, errMsg)) {
        valid = false;
    } else {
        switch (refNumInput.value) {
            case 'bda':
                seSkillsFieldset.style.display = "none";
                bdaSkillsFieldset.style.display = "";
                break;
            case 'se':
                seSkillsFieldset.style.display = "";
                bdaSkillsFieldset.style.display = "none";
                break;
            default:
                seSkillsFieldset.style.display = "";
                bdaSkillsFieldset.style.display = "";
        }
    }
}

function validateName(nameInput, nameErrSpan, nameType) {
    const errMsg = "Please enter your " + nameType + ".";
    if (!hasValue(nameInput, nameErrSpan, errMsg)) {
        valid = false;
    } else if (!isAlpha(nameInput.value)) {
        nameInput.classList.add('invalid');
        nameErrSpan.textContent = "You can only use alphabetical characters";
        valid = false;
    } else if (nameInput.value.length > 20) {
        nameInput.classList.add('invalid');
        nameErrSpan.textContent = "You have reached the maximum number of character - max 20 characters";
        valid = false;
    } else {
        nameInput.classList.remove('invalid');
        nameErrSpan.textContent = '';
    }
}

function validateDOB(dobInput, dobErrSpan) {
    const errMsg = "Please Enter your Date of Birth.";
    if (!hasValue(dobInput, dobErrSpan, errMsg)) {
        valid = false;
    } else if (!isValidDate(dobInput.value)) {
        dobInput.classList.add('invalid');
        dobErrSpan.textContent = "Please Enter a valid Date follow this pattern dd/mm/yyyy";
        valid = false;
    } else {
        var dob = dobInput.value.split("/");
        var dobDate = new Date(dob[2], dob[1] - 1, dob[0]);
        var today = new Date();
        var age = Math.floor((today.getTime() - dobDate.getTime()) / (1000 * 60 * 60 * 24 * 365.25));
        if (age < 15 || age > 80) {
            dobInput.classList.add('invalid');
            dobErrSpan.textContent = "Applicants must be at between 15 and 80 years old at the time they fill in the form";
            valid = false;
        } else {
            dobInput.classList.remove('invalid');
            dobErrSpan.textContent = "";
        }
    }
}

// function validateGender(maleOption, femaleOption, genderErrSpan) {
//     if (!maleOption.checked && !femaleOption.checked) {
//         //style the fieldset
//         genderErrSpan.textContent = "Please select your Gender.";
//         valid = false;
//     } else {
//         //remove styling of the fieldset
//         genderErrSpan.textContent = '';
//     }
// }

function validateAddress(addressInput, addressErrSpan, addressType) {
    const errMsg = "Please enter your " + addressType + ".";
    if (!hasValue(addressInput, addressErrSpan, errMsg)) {
        valid = false;
    } else if (addressInput.value.length > 40) {
        addressInput.classList.add('invalid');
        addressErrSpan.textContent = "You have reached the maximum number of character - max 40 characters";
        valid = false;
    } else {
        addressInput.classList.remove('invalid');
        addressErrSpan.textContent = "";
    }
}

function validateState(stateSelect, stateErrSpan) {
    const errMsg = "Please select your State."
    if (!hasValue(stateSelect, stateErrSpan, errMsg)) {
        return false;
    } else {
        return true;
    }
}

function validatePostcode(postcodeInput, postcodeErrSpan) {
    const errMsg = "Please enter your Postcode.";
    if (!hasValue(postcodeInput, postcodeErrSpan, errMsg)) {
        return false;
    } else if (!isValidPostcode(postcodeInput.value)) {
        postcodeInput.classList.add('invalid');
        postcodeErrSpan.textContent = "The Postcode you entered is invalid - postcodes should be exactly 4 digits."
        return false;
    } else {
        return true;
    }
}

function validateStatePostcode(postcodeInput, postcodeErrSpan, stateSelect, stateErrSpan) {
    const postcode = postcodeInput.value;
    if (validateState(stateSelect, stateErrSpan) && validatePostcode(postcodeInput, postcodeErrSpan)) {
        var spanErrMsg = '';
        switch (stateSelect.value) {
            case "vic":
                if (!(/^3\d{3}$/.test(postcode) || /^8\d{3}$/.test(postcode))) {
                    spanErrMsg = "Please enter a valid postcode - VIC postcodes start with 3 or 8";
                }
                break;
            case "nsw":
                if (!(/^1\d{3}$/.test(postcode) || /^2\d{3}$/.test(postcode))) {
                    spanErrMsg = "Please enter a valid postcode - NSW postcodes start with 1 or 2";
                }
                break;
            case "qld":
                if (!(/^4\d{3}$/.test(postcode) || /^9\d{3}$/.test(postcode))) {
                    spanErrMsg = "Please enter a valid postcode - QLD postcodes start with 4 or 9";
                }
                break;
            case "nt":
                if (!(/^0\d{3}$/.test(postcode))) {
                    spanErrMsg = "Please enter a valid postcode - NT postcodes start with 0";
                }
                break;
            case "wa":
                if (!(/^6\d{3}$/.test(postcode))) {
                    spanErrMsg = "Please enter a valid postcode - WA postcodes start with 6";
                }
                break;
            case "sa":
                if (!(/^5\d{3}$/.test(postcode))) {
                    spanErrMsg = "Please enter a valid postcode - SA postcodes start with 5";
                }
                break;
            case "tas":
                if (!(/^7\d{3}$/.test(postcode))) {
                    spanErrMsg = "Please enter a valid postcode - TAS postcodes start with 7";
                }
                break;
            case "act":
                if (!(/^0\d{3}$/.test(postcode))) {
                    spanErrMsg = "Please enter a valid postcode - ACT postcodes start with 0";
                }
                break;
        }

        if (spanErrMsg !== '') {
            postcodeInput.classList.add('invalid');
            postcodeErrSpan.textContent = spanErrMsg;
            valid = false;
        } else {
            postcodeInput.classList.remove('invalid');
            postcodeErrSpan.textContent = '';
        }
    } else {
        valid = false;
    }
}

function validateEmail(emailInput, emailErrSpan) {
    const errMsg = "Please enter your Email Address.";
    if (!hasValue(emailInput, emailErrSpan, errMsg)) {
        valid = false;
    }
}

function validateMobileNumber(mobileInput, mobileErrSpan) {
    const errMsg = "Please enter your Mobile Phone Number.";
    if (!hasValue(mobileInput, mobileErrSpan, errMsg)) {
        valid = false;
    } else if (!(/^[0-9 ]{8,12}$/.test(mobileInput.value))) {
        mobileInput.classList.add('invalid');
        mobileErrSpan.textContent = "8 to 12 digits, or spaces";
        valid = false;
    } else {
        mobileInput.classList.remove('invalid');
        mobileErrSpan.textContent = "";
    }
}

function hasValue(formElement, errSpan, errMsg) {
    if (formElement.value === '') {
        formElement.classList.add('invalid');
        errSpan.textContent = errMsg;
        return false;
    } else {
        formElement.classList.remove('invalid');
        errSpan.textContent = '';
        return true;
    }
}

function isAlpha(str) {
    return /^[a-zA-Z]+$/.test(str);
}

function isValidDate(dateString) {
    var dateRegex = /^(0?[1-9]|[1-2][0-9]|3[0-1])\/(0?[1-9]|1[0-2])\/([0-9]{4})$/;
    return dateRegex.test(dateString);
}

function isValidPostcode(str) {
    return /^\d{4}$/.test(str);
}

function runAllValidations(refNumSelect, refNumErrSpan,
    bdaSkillsFieldset, seSkillsFieldset,
    firstnameInput, firstnameErrSpan,
    lastnameInput, lastnameErrSpan,
    dobInput, dobErrSpan,
    streetAddressInput, streetAddressErrSpan,
    townInput, townErrSpan,
    stateSelect, stateErrSpan,
    postcodeInput, postcodeErrSpan,
    emailInput, emailErrSpan,
    mobileInput, mobileErrSpan) {
    validateJobRefNum(refNumSelect, refNumErrSpan, bdaSkillsFieldset, seSkillsFieldset);
    validateName(firstnameInput, firstnameErrSpan, 'First Name');
    validateName(lastnameInput, lastnameErrSpan, 'Last Name');
    validateDOB(dobInput, dobErrSpan);
    validateAddress(streetAddressInput, streetAddressErrSpan, 'Street Address');
    validateAddress(townInput, townErrSpan, 'Suburb/town');
    validateStatePostcode(postcodeInput, postcodeErrSpan, stateSelect, stateErrSpan);
    validateEmail(emailInput, emailErrSpan);
    validateMobileNumber(mobileInput, mobileErrSpan);

    if (!valid) {
        alert('Some Item Require Your Attention!');
    }

    return valid;
}

function init() {
    var bdaSkillsFieldset = document.getElementById('bda-skills');
    var seSkillsFieldset = document.getElementById('se-skills');

    var refNumSelect = document.getElementById('reference-number');
    var refNumErrSpan = document.getElementById('reference-number-err');

    //run validations as the input elements change
    refNumSelect.addEventListener('input', function () {
        validateJobRefNum(this, refNumErrSpan, bdaSkillsFieldset, seSkillsFieldset);
    });

    var firstnameInput = document.getElementById('first-name');
    var firstnameErrSpan = document.getElementById('first-name-err');

    firstnameInput.addEventListener('input', function () {
        validateName(this, firstnameErrSpan, 'First Name');
    })

    var lastnameInput = document.getElementById('last-name');
    var lastnameErrSpan = document.getElementById('last-name-err');

    lastnameInput.addEventListener('input', function () {
        validateName(this, lastnameErrSpan, 'Last Name');
    })

    var dobInput = document.getElementById('dob');
    var dobErrSpan = document.getElementById('dob-err');

    dobInput.addEventListener('input', function () {
        validateDOB(this, dobErrSpan);
    })

    // var male = document.getElementById('male');
    // var female = document.getElementById('female');
    // var genderErrSpan = document.getElementById('gender-err');

    // male.addEventListener('change', function () {
    //     validateGender(this, female, genderErrSpan);
    // })
    // female.addEventListener('change', function () {
    //     validateGender(male, this, genderErrSpan);
    // })

    var streetAddressInput = document.getElementById('street');
    var streetAddressErrSpan = document.getElementById('street-err');

    streetAddressInput.addEventListener('input', function () {
        validateAddress(this, streetAddressErrSpan, 'Street Address');
    })

    var townInput = document.getElementById('town');
    var townErrSpan = document.getElementById('town-err');

    townInput.addEventListener('input', function () {
        validateAddress(this, townErrSpan, 'Suburb/town');
    })

    var stateSelect = document.getElementById('state');
    var stateErrSpan = document.getElementById('state-err');
    var postcodeInput = document.getElementById('postcode');
    var postcodeErrSpan = document.getElementById('postcode-err');

    stateSelect.addEventListener('input', function () {
        validateStatePostcode(postcodeInput, postcodeErrSpan, this, stateErrSpan);
    })

    postcodeInput.addEventListener('input', function () {
        validateStatePostcode(this, postcodeErrSpan, stateSelect, stateErrSpan);
    })

    var emailInput = document.getElementById('email');
    var emailErrSpan = document.getElementById('email-err');

    emailInput.addEventListener('input', function () {
        validateEmail(emailInput, emailErrSpan);
    })

    var mobileInput = document.getElementById('mobile');
    var mobileErrSpan = document.getElementById('mobile-err');

    mobileInput.addEventListener('input', function () {
        validateMobileNumber(mobileInput, mobileErrSpan);
    })

    //run validation on form submission
    var applicationForm = document.getElementById("application-form");
    applicationForm.onsubmit = function () {
        runAllValidations(refNumSelect, refNumErrSpan,
            bdaSkillsFieldset, seSkillsFieldset,
            firstnameInput, firstnameErrSpan,
            lastnameInput, lastnameErrSpan,
            dobInput, dobErrSpan,
            streetAddressInput, streetAddressErrSpan,
            townInput, townErrSpan,
            stateSelect, stateErrSpan,
            postcodeInput, postcodeErrSpan,
            emailInput, emailErrSpan,
            mobileInput, mobileErrSpan);
    };
}

// Call the init function when the page is loaded
window.onload = init;
