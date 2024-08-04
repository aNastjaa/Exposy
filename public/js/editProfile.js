// Show the profile-edit section and the specific subsection
function showSection(sectionId) {
    // Show the profile-edit section
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

// Hide the profile-edit section
function hideAllSections() {
    document.getElementById('profile-edit').style.display = 'none';
    document.querySelectorAll('#profile-edit .section').forEach(section => {
        section.classList.remove('show');
    });
}

// Show the log out confirmation modal
function showLogoutConfirmation() {
    document.getElementById('logout-modal').style.display = 'block';
}

// Close the log out confirmation modal
function closeLogoutModal() {
    document.getElementById('logout-modal').style.display = 'none';
}

// Confirm log out
document.addEventListener('DOMContentLoaded', () => {
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

            if (response.ok) {
                responseText.textContent = result.message || 'Profile updated successfully!';
                responseMessageDiv.className = 'response-message success';
            } else {
                const errorMessages = Object.values(result.errors).flat();
                responseText.textContent = errorMessages.join(', ');
                responseMessageDiv.className = 'response-message error';
            }

        } catch (error) {
            responseText.textContent = 'An error occurred while updating the profile.';
            responseMessageDiv.className = 'response-message error';
        }

        responseMessageDiv.style.display = 'block'; // Show the response message
    });
});