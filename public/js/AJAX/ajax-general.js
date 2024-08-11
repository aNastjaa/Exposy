document.addEventListener('DOMContentLoaded', () => {
    const generalForm = document.getElementById('edit-general');
    const responseMessageDiv = document.getElementById('general-response-message');

    if (generalForm) {
        generalForm.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(generalForm);
            const url = generalForm.action;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const result = await response.json();
                console.log('Server response:', result); // Debugging output

                // Clear previous errors and messages
                clearErrors();
                displayResponseMessage(result);

            } catch (error) {
                console.error('Unexpected error:', error);
                displayResponseMessage({ success: false, message: 'Unexpected error occurred. Please try again.' });
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
            responseMessageDiv.style.display = 'none';
        }

        function displayResponseMessage(result) {
            const responseText = responseMessageDiv.querySelector('.response-text');

            if (result.success) {
                responseText.textContent = result.message || 'Profile updated successfully!';
                responseMessageDiv.className = 'response-message success';
                responseMessageDiv.style.display = 'block';
            } else {
                handleErrors(result.errors || {});
                responseText.textContent = result.message || 'Please correct the errors and try again.';
                responseMessageDiv.className = 'response-message error';
                responseMessageDiv.style.display = 'block';
            }
        }
    }
});
