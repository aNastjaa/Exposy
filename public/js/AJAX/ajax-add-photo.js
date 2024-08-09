document.addEventListener('DOMContentLoaded', () => {
    const photoForm = document.getElementById('edit-add-photo');

    if (photoForm) {
        photoForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent default form submission

            const fileInput = document.getElementById('file-input');
            const altTextInput = document.getElementById('alt_text');

            clearErrors();

            let hasErrors = false;
            if (!fileInput.files.length) {
                showError('file', 'Please select a photo.');
                hasErrors = true;
            }

            if (altTextInput.value.trim() === '') {
                showError('alt_text', 'Alt text is required.');
                hasErrors = true;
            }

            if (hasErrors) {
                displayResponseMessage('Please correct the errors and try again.', 'error');
                return;
            }

            const formData = new FormData(photoForm);
            const url = photoForm.action;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    const photoPreview = document.getElementById('photo-preview');
                    photoPreview.src = result.photoUrl;
                    displayResponseMessage('Photo uploaded successfully!', 'success');
                    clearErrors();
                } else {
                    handleErrors(result.errors);
                    displayResponseMessage('Failed to upload photo. Please try again.', 'error');
                }
            } catch (error) {
                console.error('Unexpected error:', error);
                displayResponseMessage('Unexpected error occurred. Please try again.', 'error');
            }
        });

        function handleErrors(errors) {
            clearErrors(); // Clear previous errors
            
            if (errors) {
                for (const [field, messages] of Object.entries(errors)) {
                    const errorList = document.getElementById(`${field}-errors`);
                    if (errorList) {
                        errorList.innerHTML = messages.map(msg => `<li>${msg}</li>`).join('');
                    }
                }
            }
        }

        function clearErrors() {
            document.querySelectorAll('.error-list').forEach(el => el.innerHTML = '');
            document.getElementById('response-message').style.display = 'none';
        }

        function showError(field, message) {
            const errorList = document.getElementById(`${field}-errors`);
            if (errorList) {
                errorList.innerHTML = `<li>${message}</li>`;
            }
        }

        function displayResponseMessage(message, type) {
            const responseMessage = document.getElementById('response-message');
            responseMessage.style.display = 'block';
            responseMessage.querySelector('.response-text').textContent = message;
            responseMessage.className = `response-message ${type}`;
        }
    }
});
