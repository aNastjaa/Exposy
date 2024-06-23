//Edit profile opener
document.addEventListener('DOMContentLoaded', () => {
    const editProfileButton = document.querySelector('.account-buttons .blind-button:first-of-type');
    const profileEditSection = document.getElementById('profile-edit');
    const closeIcon = document.getElementById('close-profile-edit');

    editProfileButton.addEventListener('click', () => {
        profileEditSection.style.display = 'block';
    });

    closeIcon.addEventListener('click', () => {
        profileEditSection.style.display = 'none';
    });
});


// Info icon opener
document.addEventListener('DOMContentLoaded', function() {
    const passwordIcon = document.querySelector('.password-icon');
    const passwordRequirements = document.querySelector('.password-requirements');

    passwordIcon.addEventListener('click', function(event) {
        event.stopPropagation();
        passwordRequirements.style.display = 'block';
    });

    document.addEventListener('click', function() {
        passwordRequirements.style.display = 'none';
    });

    passwordRequirements.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});


//FORM VALIDATION

document.addEventListener('DOMContentLoaded', function() {
    // DOM elements
    const elements = {
        firstname: document.getElementById("firstname"),
        firstnameError: document.getElementById("error-firstname"),
        emptyFirstnameError: document.getElementById("empty-firstname"),
        lastname: document.getElementById("lastname"),
        lastnameError: document.getElementById("error-lastname"),
        emptyLastnameError: document.getElementById("empty-lastname"),
        email: document.getElementById("email"),
        emailError: document.getElementById("error-email"),
        emptyEmailError: document.getElementById("empty-email"),
        sex: document.querySelectorAll('input[name="sex"]'),
        sexError: document.getElementById("error-sex"),
        country: document.getElementById("country"),
        countryError: document.getElementById("error-country"),
        city: document.getElementById("city"),
        cityError: document.getElementById("error-city"),
        emptyCityError: document.getElementById("empty-city"),
        password: document.getElementById("pwd"),
        passwordError: document.getElementById("error-pwd"),
        emptyPasswordError: document.getElementById("empty-pwd"),
        terms: document.getElementById("terms"),
        termsError: document.getElementById("error-terms"),
        submitButton: document.getElementById("submit-button"),
        formMessage: document.getElementById("form-error-message")
    };

    // Regular expressions
    const regexPatterns = {
        text: /^[a-zA-Z]{4,}$/,
        email: /^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,}$/,
        password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,}$/
    };

    // Validation functions
    const validateInput = (input, regex, errorElement, emptyErrorElement, minLength = 0) => {
        const value = input.value.trim();
        const isValid = value.length >= minLength && regex.test(value);

        if (isValid) {
            errorElement.classList.add("hide");
            emptyErrorElement.classList.add("hide");
            input.classList.remove("error");
            input.classList.add("valid");
            input.style.borderColor = "green";
        } else {
            if (value.length === 0) {
                emptyErrorElement.classList.remove("hide");
                errorElement.classList.add("hide");
            } else {
                emptyErrorElement.classList.add("hide");
                errorElement.classList.remove("hide");
            }
            input.classList.remove("valid");
            input.classList.add("error");
            input.style.borderColor = "red";
        }

        return isValid;
    };

    // Attach input event listener and validate input
    const attachValidation = (inputElement, regex, errorElement, emptyErrorElement, minLength = 0) => {
        inputElement.addEventListener("input", () => {
            validateInput(inputElement, regex, errorElement, emptyErrorElement, minLength);
        });
    };

    // Event listeners for inputs
    attachValidation(elements.firstname, regexPatterns.text, elements.firstnameError, elements.emptyFirstnameError, 4);
    attachValidation(elements.lastname, regexPatterns.text, elements.lastnameError, elements.emptyLastnameError, 4);
    attachValidation(elements.city, regexPatterns.text, elements.cityError, elements.emptyCityError, 4);
    attachValidation(elements.email, regexPatterns.email, elements.emailError, elements.emptyEmailError);
    attachValidation(elements.password, regexPatterns.password, elements.passwordError, elements.emptyPasswordError);

    // Sex input validation
    const validateSex = () => {
        const isValid = [...elements.sex].some(input => input.checked);
        elements.sexError.classList.toggle("hide", isValid);
        if (isValid) {
            elements.sex.forEach(input => input.parentElement.style.borderColor = "green");
        } else {
            elements.sex.forEach(input => input.parentElement.style.borderColor = "red");
        }
        return isValid;
    };

    elements.sex.forEach(input => input.addEventListener('change', validateSex));

    // Country input validation
    const validateCountry = () => {
        const isValid = elements.country.value !== "none";
        elements.countryError.classList.toggle("hide", isValid);
        elements.country.style.borderColor = isValid ? "green" : "red";
        return isValid;
    };

    elements.country.addEventListener('change', validateCountry);

    // Terms input validation
    const validateTerms = () => {
        const isValid = elements.terms.checked;
        elements.termsError.classList.toggle("hide", isValid);
        elements.terms.style.borderColor = isValid ? "green" : "red";
        return isValid;
    };

    elements.terms.addEventListener('change', validateTerms);

    // Form submit event listener
    elements.submitButton.addEventListener('click', (event) => {
        event.preventDefault();

        const isFirstNameValid = validateInput(elements.firstname, regexPatterns.text, elements.firstnameError, elements.emptyFirstnameError, 4);
        const isLastNameValid = validateInput(elements.lastname, regexPatterns.text, elements.lastnameError, elements.emptyLastnameError, 4);
        const isEmailValid = validateInput(elements.email, regexPatterns.email, elements.emailError, elements.emptyEmailError);
        const isPasswordValid = validateInput(elements.password, regexPatterns.password, elements.passwordError, elements.emptyPasswordError);
        const isSexValid = validateSex();
        const isCountryValid = validateCountry();
        const isCityValid = validateInput(elements.city, regexPatterns.text, elements.cityError, elements.emptyCityError, 4);
        const isTermsValid = validateTerms();

        if (isFirstNameValid && isLastNameValid && isEmailValid && isPasswordValid && isSexValid && isCountryValid && isCityValid && isTermsValid) {
            document.getElementById("profile-form").submit();
        } else {
            elements.formMessage.textContent = "Please, fill all the fields correctly and try again.";
        }
    });
});
