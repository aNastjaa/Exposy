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

// Confirm logout button handler
document.addEventListener('DOMContentLoaded', () => {
    const confirmLogoutButton = document.getElementById('confirm-logout-button');
    
    if (confirmLogoutButton) {
        confirmLogoutButton.addEventListener('click', () => {
            window.location.href = '/index.php?action=logout';
        });
    }
});

//____________ Delete account______________

document.addEventListener('DOMContentLoaded', () => {
    const deleteProfileForm = document.getElementById('delete-profile'); // Div, not a form
    const modal = document.getElementById('delete-account-modal');
    const confirmDeleteButton = document.getElementById('confirm-delete-button');
    const declineDeleteButton = document.querySelector('#delete-account-modal .modal-cta-button');
    const closeModalButton = document.querySelector('#delete-account-modal .close');

    if (!modal || !deleteProfileForm || !confirmDeleteButton || !declineDeleteButton || !closeModalButton) {
        console.error('Required modal elements not found.');
        return;
    }

    const openDeleteModal = () => {
        modal.style.display = 'block';
    };

    const closeDeleteModal = () => {
        modal.style.display = 'none';
    };

    deleteProfileForm.addEventListener('click', (event) => {
        event.preventDefault();
        openDeleteModal();
    });

    confirmDeleteButton.addEventListener('click', () => {
        if (typeof deleteAccount === 'function') {
            deleteAccount(); 
        } else {
            console.error('deleteAccount function is not defined.');
        }
        closeDeleteModal();
    });

    declineDeleteButton.addEventListener('click', closeDeleteModal);
    closeModalButton.addEventListener('click', closeDeleteModal);

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeDeleteModal();
        }
    });
});

// EVENT CARDS

document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById('event-cards-container');
    const leftArrow = document.getElementById('left-arrow');
    const rightArrow = document.getElementById('right-arrow');

    const scrollAmount = 350; 

    leftArrow.addEventListener('click', function () {
        container.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth' 
        });
    });

    rightArrow.addEventListener('click', function () {
        container.scrollBy({
            left: scrollAmount, 
            behavior: 'smooth' 
        });
    });
});

// SAVE EVENTS BUTTON

function saveEvent(eventId) {
    fetch(`/save-event.php?event_id=${eventId}`, {
        method: 'GET',
        credentials: 'same-origin'
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            alert('Event saved successfully!');
        } else {
            alert('Failed to save event.');
        }
    });
}

//PHOTO PREVIW
document.getElementById('file-input').addEventListener('change', function(event) {
    const fileInput = event.target;
    const preview = document.getElementById('photo-preview');
    
    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        
        reader.readAsDataURL(fileInput.files[0]);
    }
});