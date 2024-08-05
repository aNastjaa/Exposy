async function handleFormSubmission(form, responseMessageDiv) {
    const responseText = responseMessageDiv.querySelector('.response-text');
    const formData = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        // Clear previous error messages
        document.querySelectorAll('.input-section .error-list').forEach(el => el.innerHTML = '');

        if (response.ok && result.success) {
            // Display success message
            responseText.textContent = result.message || 'Action completed successfully!';
            responseMessageDiv.className = 'response-message success';
        } else {
            // Display server-side validation errors
            for (const [field, messages] of Object.entries(result)) {
                // Check if the field is an error and has messages
                if (field !== 'success' && messages.length > 0) {
                    const fieldElement = document.querySelector(`[name="${field}"]`);
                    if (fieldElement) {
                        const errorList = fieldElement.closest('.input-section')?.querySelector('.error-list');
                        if (errorList) {
                            errorList.innerHTML = messages.map(msg => `<li class="error">${msg}</li>`).join('');
                        } else {
                            console.warn(`Error list for field "${field}" not found.`);
                        }

                        // Highlight field border in red
                        fieldElement.style.borderColor = 'red';
                    } else {
                        console.warn(`Field with name "${field}" not found.`);
                    }
                }
            }

            responseText.textContent = 'Please correct the highlighted fields and try again.';
            responseMessageDiv.className = 'response-message error';
        }

    } catch (error) {
        console.error('Error during form submission:', error);
        responseText.textContent = 'An error occurred while processing the request.';
        responseMessageDiv.className = 'response-message error';
    }

    // Show the response message
    responseMessageDiv.style.display = 'block';
}

// Event listener for DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    // Handle profile information form submission
    const profileForm = document.getElementById('edit-profile-dsts');
    const profileResponseMessageDiv = document.getElementById('changes-response-message');

    if (profileForm) {
        profileForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent the default form submission
            handleFormSubmission(profileForm, profileResponseMessageDiv);
        });
    }

    // Handle password change form submission
    const passwordForm = document.getElementById('edit-password');
    const passwordResponseMessageDiv = document.getElementById('password-response-message');

    if (passwordForm) {
        passwordForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent the default form submission
            handleFormSubmission(passwordForm, passwordResponseMessageDiv);
        });
    }

    // Handle additional info form submission
    const additionalInfoForm = document.getElementById('profile-form');
    const additionalInfoResponseMessageDiv = document.getElementById('response-message');

    if (additionalInfoForm) {
        additionalInfoForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent the default form submission
            handleFormSubmission(additionalInfoForm, additionalInfoResponseMessageDiv);
        });
    }

    // Confirm logout button handler
    const confirmLogoutButton = document.getElementById('confirm-logout-button');
    
    if (confirmLogoutButton) {
        confirmLogoutButton.addEventListener('click', () => {
            window.location.href = '/index.php?action=logout';
        });
    }
});
