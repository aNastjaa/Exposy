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
        document.querySelectorAll('.input-section input').forEach(el => el.style.borderColor = '');

        if (response.ok && result.success) {
            responseText.textContent = result.message || 'Action completed successfully!';
            responseMessageDiv.className = 'response-message success';
            responseMessageDiv.style.display = 'block';
        } else {
            // Handle errors
            if (!result.success) {
                for (const [field, messages] of Object.entries(result)) {
                    // Skip the 'success' field
                    if (field === 'success') continue;

                    // Select error list by ID
                    const errorList = document.getElementById(`${field}-errors`);
                    if (errorList) {
                        errorList.innerHTML = messages.map(msg => `<li class="error">${msg}</li>`).join('');
                    } else {
                        console.warn(`Error list for field "${field}" not found.`);
                    }

                    // Highlight the field with errors
                    const fieldElement = document.querySelector(`[name="${field}"]`);
                    if (fieldElement) {
                        fieldElement.style.borderColor = 'red';
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

// Handle profile information form submission
const profileForm = document.getElementById('edit-profile-dsts');
const profileResponseMessageDiv = document.getElementById('changes-response-message');

if (profileForm) {
    profileForm.addEventListener('submit', (event) => {
        event.preventDefault();
        handleFormSubmission(profileForm, profileResponseMessageDiv);
    });
}
