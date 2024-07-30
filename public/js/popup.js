document.addEventListener('DOMContentLoaded', function() {
    var closeButton = document.getElementById('close-popup-button');
    var popup = document.getElementById('success-popup');

    if (closeButton && popup) {
        closeButton.addEventListener('click', function() {
            popup.style.display = 'none';
        });
    }
});