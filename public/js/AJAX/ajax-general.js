document.addEventListener('DOMContentLoaded', () => {
    const generalForm = document.getElementById('edit-general');

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

                if (!result.success) {
                    handleErrors(result.errors);
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

        function displayResponseMessage(message, type) {
            const responseMessage = document.getElementById('response-message');
            responseMessage.style.display = 'block';
            responseMessage.querySelector('.response-text').textContent = message;
            responseMessage.className = `response-message ${type}`;
        }
    }
});
