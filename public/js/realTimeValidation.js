document.addEventListener('DOMContentLoaded', () => {
    // Define valid values for countries and genders based on your PHP enums
    const validCountries = [
        'Germany', 'Austria', 'Belgium', 'Czech Republic', 'Denmark', 'France', 
        'Hungary', 'Italy', 'Luxembourg', 'Netherlands', 'Poland', 'Slovakia', 
        'Switzerland', 'Liechtenstein', 'Slovenia', 'Croatia'
    ];

    const validGenders = ['Male', 'Female', 'Diverse'];

    // Function to validate a field with the provided rules
    function validateField(field, rules) {
        const value = field.value.trim();
        let isValid = true;

        // Clear previous border color
        field.style.borderColor = '#272727';

        if (rules.required && !value) {
            isValid = false;
        } else if (rules.minLength && value.length < rules.minLength) {
            isValid = false;
        } else if (rules.maxLength && value.length > rules.maxLength) {
            isValid = false;
        } else if (rules.noSpaces && /\s/.test(value)) {
            isValid = false;
        } else if (rules.email && !validateEmail(value)) {
            isValid = false;
        } else if (rules.password && !validatePassword(value)) {
            isValid = false;
        } else if (rules.passwordRepeat && value !== document.querySelector('[name="password"]').value) {
            isValid = false;
        } else if (rules.username && !validateStringField(value, 3, 255)) {
            isValid = false;
        } else if (rules.gender && !validGenders.includes(value)) {
            isValid = false;
        } else if (rules.country && !validCountries.includes(value)) {
            isValid = false;
        } else if (rules.terms && !document.querySelector('[name="terms"]').checked) {
            isValid = false;
        } else if (rules.file && !document.querySelector('[name="file"]').files.length) {
            isValid = false;
        } else if (rules.altText && !value) {
            isValid = false;
        }

        // Set border color based on validity
        field.style.borderColor = isValid ? 'green' : 'red';

        return isValid;
    }

    // Email validation function
    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // Password validation function
    function validatePassword(password) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/.test(password);
    }

    // String field validation function
    function validateStringField(value, minLength, maxLength) {
        return value.length >= minLength && value.length <= maxLength && !/\s/.test(value);
    }

    // Define validation rules for fields
    const rules = {
        firstname: { required: true, minLength: 3, maxLength: 255, noSpaces: true },
        lastname: { required: true, minLength: 3, maxLength: 255, noSpaces: true },
        city: { required: true, minLength: 3, maxLength: 255, noSpaces: true },
        country: { required: true, country: true },
        gender: { required: true, gender: true },
        email: { required: true, email: true },
        password: { required: true, password: true },
        password_repeat: { required: true, passwordRepeat: true },
        username: { required: true, username: true },
        file: { required: true, file: true },
        alt_text: { required: true, altText: true },
        terms: { required: true, terms: true }
    };

    // Handle input events for real-time validation
    document.querySelectorAll('#profile-form input, #profile-form select').forEach(field => {
        field.addEventListener('input', () => {
            if (rules[field.name]) {
                validateField(field, rules[field.name]);
            }
        });
    });

    // Handle form submission
    const form = document.getElementById('profile-form');
    if (form) {
        form.addEventListener('submit', (event) => {
            let allValid = true;

            // Validate all fields
            document.querySelectorAll('#profile-form input, #profile-form select').forEach(field => {
                if (rules[field.name]) {
                    const isValid = validateField(field, rules[field.name]);
                    if (!isValid) {
                        allValid = false;
                    }
                }
            });

            // If not all fields are valid, set border color to red and prevent form submission
            if (!allValid) {
                event.preventDefault();
                document.querySelectorAll('#profile-form input, #profile-form select').forEach(field => {
                    if (rules[field.name]) {
                        validateField(field, rules[field.name]);
                    }
                });
            }
        });
    }
});
