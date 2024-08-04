// Function to show the profile-edit section and the specific subsection
function showSection(sectionId) {
    document.getElementById('profile-edit').style.display = 'block';

    // Hide all subsections
    document.querySelectorAll('#profile-edit .section').forEach(section => {
        section.classList.remove('show');
    });

    // Show the selected subsection
    const sectionToShow = document.getElementById(sectionId);
    if (sectionToShow) {
        sectionToShow.classList.add('show');
    }
}

// Function to hide the profile-edit section
function hideAllSections() {
    document.getElementById('profile-edit').style.display = 'none';
    document.querySelectorAll('#profile-edit .section').forEach(section => {
        section.classList.remove('show');
    });
}

// Function to show the logout confirmation modal
function showLogoutConfirmation() {
    document.getElementById('logout-modal').style.display = 'block';
}

// Function to close the logout confirmation modal
function closeLogoutModal() {
    document.getElementById('logout-modal').style.display = 'none';
}

// Event listener for DOMContentLoaded
document.addEventListener('DOMContentLoaded', () => {
    // Confirm logout button handler
    const confirmLogoutButton = document.getElementById('confirm-logout-button');
    
    if (confirmLogoutButton) {
        confirmLogoutButton.addEventListener('click', () => {
            window.location.href = '/index.php?action=logout';
        });
    }

    // Initially hide the profile-edit section
    document.getElementById('profile-edit').style.display = 'none';

    // Handle form submission with AJAX
    const form = document.getElementById('profile-form');
    const responseMessageDiv = document.getElementById('response-message');
    const responseText = responseMessageDiv.querySelector('.response-text');

    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent the default form submission

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
                    responseText.textContent = result.message || 'Profile updated successfully!';
                    responseMessageDiv.className = 'response-message success';
                } else {
                    // Display server-side validation errors
                    for (const [field, messages] of Object.entries(result.errors || {})) {
                        const fieldElement = document.querySelector(`#${field}`);
                        if (fieldElement) {
                            const errorList = fieldElement.closest('.input-section').querySelector('.error-list');
                            if (errorList) {
                                errorList.innerHTML = messages.map(msg => `<li class="error">${msg}</li>`).join('');
                            }
                        }
                    }

                    responseText.textContent = 'Fill all the fields correctly and try again.';
                    responseMessageDiv.className = 'response-message error';
                }

            } catch (error) {
                responseText.textContent = 'An error occurred while updating the profile.';
                responseMessageDiv.className = 'response-message error';
            }

            // Show the response message
            responseMessageDiv.style.display = 'block'; 
        });
    }
});
