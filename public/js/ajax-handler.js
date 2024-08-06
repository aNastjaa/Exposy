// Function to handle AJAX form submission
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
        document.querySelectorAll('.error-list').forEach(el => el.innerHTML = '');

        if (response.ok && result.success) {
            // Display success message
            responseText.textContent = result.message || 'Action completed successfully!';
            responseMessageDiv.className = 'response-message success';
            responseMessageDiv.style.display = 'block';
        } else {
            // Log the result to debug what is coming from the server
            console.log('Server response:', result);

            // Display server-side validation errors
            for (const [field, messages] of Object.entries(result)) {
                if (field === 'success') continue; // Skip the 'success' field

                const fieldElement = document.querySelector(`[name="${field}"]`);
                if (fieldElement) {
                    const errorList = fieldElement.closest('.input-section, .radio-section')?.querySelector('.error-list');
                    if (errorList) {
                        errorList.innerHTML = messages.map(msg => `<li class="error">${msg}</li>`).join('');
                    } else {
                        console.warn(`Error list for field "${field}" not found.`);
                    }

                    // Highlight field border in red
                    fieldElement.style.borderColor = 'red';
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
                        radioGroup.forEach(radio => {
                            radio.style.outline = '2px solid red';
                        });
                    } else {
                        console.warn(`Field with name "${field}" not found.`);
                    }
                }
            }

            responseText.textContent = 'Please correct the highlighted fields and try again.';
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

// Event listener for DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    // Handle profile information form submission
    const profileForm = document.getElementById('edit-profile-dsts');
    const profileResponseMessageDiv = document.getElementById('changes-response-message');

    if (profileForm) {
        profileForm.addEventListener('submit', (event) => {
            event.preventDefault(); 
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


//---------- DELTE ACCOUNT -----------------

document.addEventListener('DOMContentLoaded', () => {
    // Define the deleteAccount function
    const deleteAccount = async () => {
        try {
            const response = await fetch('/account/delete', { 
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'delete_account' }) 
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                window.location.href = '/register'; 
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting your account.');
        }
    };

    // Attach event listener to confirm delete button
    const confirmDeleteButton = document.getElementById('confirm-delete-button');
    if (confirmDeleteButton) {
        confirmDeleteButton.addEventListener('click', () => {
            deleteAccount();
        });
    } else {
        console.error('Confirm delete button not found.');
    }
});

// AJAX FOR EVENT SAVING PROCESS

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.save-event-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const eventId = this.dataset.eventId;
            fetch('/account', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ event_id: eventId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            });
        });
    });
});
