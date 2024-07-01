//Edit profile opener
document.addEventListener('DOMContentLoaded', () => {
    const editProfileButton = document.querySelector('.account-buttons .blind-button:first-of-type');
    const profileEditSection = document.getElementById('profile-edit');
    const closeIcon = document.getElementById('close-profile-edit');

    editProfileButton.addEventListener('click', () => {
        profileEditSection.style.display = 'block';
    });

    closeIcon.addEventListener('click', () => {
        profileEditSection.style.display = 'none';
    });
});


// Info icon opener
document.addEventListener('DOMContentLoaded', function() {
    const passwordIcon = document.querySelector('.password-icon');
    const passwordRequirements = document.querySelector('.password-requirements');

    passwordIcon.addEventListener('click', function(event) {
        event.stopPropagation();
        passwordRequirements.style.display = 'block';
    });

    document.addEventListener('click', function() {
        passwordRequirements.style.display = 'none';
    });

    passwordRequirements.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});
