async function handlePasswordFormSubmission(form, responseMessageDiv) {
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
        console.log('Server response for password:', result); // Debugging output

        // Clear previous error messages
        document.querySelectorAll('.error-list').forEach(el => el.innerHTML = '');
        document.querySelectorAll('.input-section input').forEach(el => el.style.borderColor = '');

        if (response.ok && result.success) {
            responseText.textContent = result.message || 'Password updated successfully!';
            responseMessageDiv.className = 'response-message success';
            responseMessageDiv.style.display = 'block';
        } else {
            // Handle errors
            if (!result.success) {
                for (const [field, messages] of Object.entries(result)) {
                    if (field === 'success') continue;

                    // Determine the appropriate error list ID
                    let errorListId;
                    if (field === 'password') {
                        errorListId = 'current_password-errors';
                    } else if (field === 'new-password') {
                        errorListId = 'new_password-errors';
                    } else {
                        // If error field is not directly associated with any input, skip
                        continue;
                    }

                    // Get the error list element
                    const errorList = document.getElementById(errorListId);
                    if (errorList) {
                        // Populate the error list with messages
                        errorList.innerHTML = messages.map(msg => `<li class="error">${msg}</li>`).join('');
                    } else {
                        console.warn(`Error list for field "${field}" not found.`);
                    }

                    // Highlight the field with errors
                    const fieldElement = document.querySelector(`[id="${errorListId.replace('-errors', '')}"]`);
                    if (fieldElement) {
                        fieldElement.style.borderColor = 'red';
                    }
                }
            }

            responseText.textContent = 'Please correct the errors and try again.';
            responseMessageDiv.className = 'response-message error';
            responseMessageDiv.style.display = 'block';
        }

    } catch (error) {
        console.error('Error during password form submission:', error);
        responseText.textContent = 'An error occurred while processing the request.';
        responseMessageDiv.className = 'response-message error';
        responseMessageDiv.style.display = 'block';
    }
}

// Handle password change form submission
const passwordForm = document.getElementById('edit-password');
const passwordResponseMessageDiv = document.getElementById('password-response-message');

if (passwordForm) {
    passwordForm.addEventListener('submit', (event) => {
        event.preventDefault();
        handlePasswordFormSubmission(passwordForm, passwordResponseMessageDiv);
    });
}
