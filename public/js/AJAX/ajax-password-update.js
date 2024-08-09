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
        console.log('Server response:', result); // Debugging output

        // Clear previous error messages
        document.querySelectorAll('.error-list').forEach(el => el.innerHTML = '');

        if (response.ok && result.success) {
            responseText.textContent = result.message || 'Password updated successfully!';
            responseMessageDiv.className = 'response-message success';
            responseMessageDiv.style.display = 'block';
        } else {
            // Handle errors
            if (!result.success) {
                for (const [field, messages] of Object.entries(result)) {
                    // Skip the 'success' field
                    if (field === 'success') continue;

                    // Special handling for input errors
                    if (field === 'username' || field === 'email') {
                        // Specific fields that may not have direct input elements
                        const errorList = document.getElementById(`${field}-errors`);
                        if (errorList) {
                            errorList.innerHTML = messages.map(msg => `<li class="error">${msg}</li>`).join('');
                        } else {
                            console.warn(`Error list for field "${field}" not found.`);
                        }
                    } else {
                        // General handling for other fields
                        const fieldElement = document.querySelector(`[name="${field}"]`);
                        if (fieldElement) {
                            const errorList = fieldElement.closest('.input-section')?.querySelector('.error-list');
                            if (errorList) {
                                errorList.innerHTML = messages.map(msg => `<li class="error">${msg}</li>`).join('');
                            } else {
                                console.warn(`Error list for field "${field}" not found.`);
                            }
                        } else {
                            // Special handling for radio buttons (gender)
                            const radioGroup = document.querySelectorAll(`input[name="${field}"]`);
                            if (radioGroup.length > 0) {
                                const errorList = radioGroup[0].closest('.radio-section')?.querySelector('.error-list');
                                if (errorList) {
                                    errorList.innerHTML = messages.map(msg => `<li class="error">${msg}</li>`).join('');
                                } else {
                                    console.warn(`Error list for field "${field}" not found.`);
                                }
                            } else {
                                console.warn(`Field with name "${field}" not found.`);
                            }
                        }
                    }
                }
            }

            responseText.textContent = 'Please fill in all the fields correctly and try again.';
            responseMessageDiv.className = 'response-message error';
            responseMessageDiv.style.display = 'block';
        }

    } catch (error) {
        console.error('Error during form submission:', error);
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
        handleFormSubmission(passwordForm, passwordResponseMessageDiv);
    });
}
