document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profile-form');
    const elements = {
        firstname: document.getElementById('firstname'),
        lastname: document.getElementById('lastname'),
        email: document.getElementById('email'),
        city: document.getElementById('city'),
        pwd: document.getElementById('pwd'),
        terms: document.getElementById('terms'),
        country: document.getElementById('country'),
        sex: document.querySelectorAll('input[name="sex"]')
    };

    const regexPatterns = {
        text: /^[a-zA-Z\s]{4,}$/, 
        email: /^[\w-]+(?:\.[\w-]+)*@(?:[\w-]+\.)+[a-zA-Z]{2,}$/, 
        password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+}{":;'?\/\\><.,])(?!.*\s).{8,}$/ // Password requirements
    };

    // Function to validate each input based on regex pattern
    const validateInput = (input, regex) => {
        const isValid = regex.test(input.value.trim());
        input.style.borderColor = isValid ? "green" : "red";
        return isValid;
    };

    // Function to validate radio buttons (sex)
    const validateSex = () => {
        const isValid = [...elements.sex].some(input => input.checked);
        elements.sex.forEach(input => input.parentElement.style.borderColor = isValid ? "green" : "red");
        return isValid;
    };

    // Function to validate terms checkbox
    const validateTerms = () => {
        const isValid = elements.terms.checked;
        elements.terms.parentElement.style.borderColor = isValid ? "green" : "red";
        return isValid;
    };

    // Function to validate country dropdown
    const validateCountry = () => {
        const isValid = elements.country.value !== "none";
        elements.country.style.borderColor = isValid ? "green" : "red";
        return isValid;
    };

    // Attach event listeners for input validation
    elements.firstname.addEventListener('blur', () => validateInput(elements.firstname, regexPatterns.text));
    elements.lastname.addEventListener('blur', () => validateInput(elements.lastname, regexPatterns.text));
    elements.email.addEventListener('blur', () => validateInput(elements.email, regexPatterns.email));
    elements.city.addEventListener('blur', () => validateInput(elements.city, regexPatterns.text));
    elements.pwd.addEventListener('blur', () => validateInput(elements.pwd, regexPatterns.password));
    elements.terms.addEventListener('change', validateTerms);
    elements.country.addEventListener('change', validateCountry);
    elements.sex.forEach(input => input.addEventListener('change', validateSex));

    // Form submission handling
    form.addEventListener('submit', function(event) {
        let isValid = true;

        // Validate all fields
        isValid = validateInput(elements.firstname, regexPatterns.text) && isValid;
        isValid = validateInput(elements.lastname, regexPatterns.text) && isValid;
        isValid = validateInput(elements.email, regexPatterns.email) && isValid;
        isValid = validateInput(elements.city, regexPatterns.text) && isValid;
        isValid = validateInput(elements.pwd, regexPatterns.password) && isValid;
        isValid = validateSex() && isValid;
        isValid = validateCountry() && isValid;
        isValid = validateTerms() && isValid;

        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }
    });
});
