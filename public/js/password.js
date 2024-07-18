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


document.addEventListener('DOMContentLoaded', function() {
    console.log('Inline script running');
});
