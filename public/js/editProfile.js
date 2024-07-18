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

