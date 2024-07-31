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

// Optional: Initial state setup
document.addEventListener('DOMContentLoaded', () => {
    // Initially hide the profile-edit section
    document.getElementById('profile-edit').style.display = 'none';
});

