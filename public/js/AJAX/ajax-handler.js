document.addEventListener('DOMContentLoaded', () => {
    // Function to display messages
    function displayMessage(message, type) {
        const messageContainer = document.getElementById('message-container');
        const messageText = document.getElementById('message-text');

        if (messageContainer && messageText) {
            messageText.textContent = message;
            messageContainer.style.display = 'block';
            messageContainer.className = `message-container ${type}`; // Corrected class assignment

            // Hide the message after 3 seconds
            setTimeout(() => {
                messageContainer.style.display = 'none';
            }, 3000);
        } else {
            console.error('Message container or text element not found.');
        }
    }

    // Handle file upload preview and submission
    const form = document.getElementById('edit-add-photo');
    const fileInput = document.getElementById('file-input');
    const photoPreview = document.getElementById('photo-preview');
    const responseMessageDiv = document.getElementById('photo-response-message');
    const responseMessageText = responseMessageDiv?.querySelector('.response-text');

    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent the default form submission
            
            const formData = new FormData(form);
            
            // Optionally handle file input change event for preview purposes
            const file = fileInput?.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }

            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                // Check if response is JSON
                const contentType = response.headers.get('Content-Type');
                const text = await response.text(); // Read the response as text first

                if (contentType && contentType.includes('application/json')) {
                    try {
                        const result = JSON.parse(text); // Parse JSON here

                        if (response.ok && result.success) {
                            // Check if photoUrl is in the response
                            if (result.photoUrl) {
                                photoPreview.src = result.photoUrl; // Update the preview with the new photo URL
                            }
                            responseMessageText.textContent = 'Photo uploaded successfully!';
                            responseMessageDiv.className = 'response-message success';
                            responseMessageDiv.style.display = 'block';
                        } else {
                            // Log the entire result for debugging
                            console.log('Server response:', result);
                            responseMessageText.textContent = result.errors?.join(' ') || 'Failed to upload photo.';
                            responseMessageDiv.className = 'response-message error';
                            responseMessageDiv.style.display = 'block';
                        }
                    } catch (jsonError) {
                        console.error('Error parsing JSON:', jsonError);
                        console.error('Response text:', text);
                        responseMessageText.textContent = 'Invalid JSON response from the server.';
                        responseMessageDiv.className = 'response-message error';
                        responseMessageDiv.style.display = 'block';
                    }
                } else {
                    console.error('Unexpected content type:', contentType);
                    console.error('Response text:', text);
                    responseMessageText.textContent = 'An error occurred during file upload.';
                    responseMessageDiv.className = 'response-message error';
                    responseMessageDiv.style.display = 'block';
                }
            } catch (error) {
                console.error('Error during file upload:', error);
                responseMessageText.textContent = 'An error occurred during file upload.';
                responseMessageDiv.className = 'response-message error';
                responseMessageDiv.style.display = 'block';
            }
        });
    }

    // Confirm logout button handler
    const confirmLogoutButton = document.getElementById('confirm-logout-button');
    
    if (confirmLogoutButton) {
        confirmLogoutButton.addEventListener('click', () => {
            window.location.href = '/index.php?action=logout';
        });
    }

    // Define the deleteAccount function
    const deleteAccount = async () => {
        try {
            const response = await fetch('/account/delete', { 
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ action: 'delete_account' }) 
            });

            const data = await response.json();

            if (data.success) {
                alert(data.message);
                window.location.href = '/register'; 
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred while deleting your account.');
        }
    };

    // Attach event listener to confirm delete button
    const confirmDeleteButton = document.getElementById('confirm-delete-button');
    if (confirmDeleteButton) {
        confirmDeleteButton.addEventListener('click', () => {
            deleteAccount();
        });
    }

    // Handle AJAX for saving events
    document.querySelectorAll('.save-event-button').forEach(button => {
        button.addEventListener('click', async (event) => {
            event.preventDefault(); // Prevent default form submission

            const form = button.closest('form');
            if (!form || form.id === 'filter-form') return; // Skip filter form

            const formData = new FormData(form);
            const url = form.action;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                // Check if the response is JSON
                const contentType = response.headers.get('Content-Type');
                const text = await response.text(); // Read the response as text first

                if (contentType && contentType.includes('application/json')) {
                    try {
                        const result = JSON.parse(text); // Parse JSON here

                        if (result.success) {
                            displayMessage('Event saved successfully!', 'success');
                        } else {
                            displayMessage(result.message || 'Failed to save event.', 'error');
                        }
                    } catch (jsonError) {
                        console.error('Error parsing JSON:', jsonError);
                        console.error('Response text:', text);
                        displayMessage('Invalid JSON response from the server.', 'error');
                    }
                } else {
                    console.error('Unexpected content type:', contentType);
                    console.error('Response text:', text);
                    displayMessage('Unexpected response format.', 'error');
                }
            } catch (error) {
                console.error('Unexpected error:', error);
                displayMessage('Unexpected error occurred. Please try again.', 'error');
            }
        });
    });

    // Handle deletion of events
    document.querySelectorAll('.delete-event-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 

            const form = this.closest('form');
            if (!form || form.id === 'filter-form') return; // Skip filter form

            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }
                return response.text(); // Read as text first
            })
            .then(text => {
                try {
                    const data = JSON.parse(text); // Parse JSON here
                    if (data.success) {
                        form.closest('.event-cart-big').remove();
                    } else {
                        alert(data.message || 'Error deleting event.');
                    }
                } catch (jsonError) {
                    console.error('Error parsing JSON:', jsonError);
                    console.error('Response text:', text);
                }
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
        });
    });

    // Ensure the filter form is not processed by AJAX
    const filterForm = document.getElementById('filter-form');
    if (filterForm) {
        filterForm.addEventListener('submit', (event) => {
            // Allow the form to submit normally
        });
    }

    // Handle form submissions for comments and other AJAX forms
    document.querySelectorAll('form').forEach(form => {
        if (form.id === 'filter-form') {
            // Skip the filter form
            return;
        }

        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const formData = new FormData(form);
            const url = form.action;

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                // Read response as text first
                const contentType = response.headers.get('Content-Type');
                const text = await response.text();

                if (contentType && contentType.includes('application/json')) {
                    try {
                        const result = JSON.parse(text); // Parse JSON here
                        console.log('Server response:', result); // Log server response for debugging

                        if (result.success) {
                            if (form.classList.contains('add-comment-form')) {
                                displayMessage(result.message || 'Comment added successfully!', 'success');
                                // Force a page reload after successful add
                                setTimeout(() => {
                                    window.location.reload(true); // Force reload from server
                                }, 1000); // Adjust timing as needed
                            } else if (form.classList.contains('edit-comment-form')) {
                                displayMessage(result.message || 'Comment updated successfully!', 'success');
                            } else if (form.classList.contains('delete-comment-form')) {
                                displayMessage(result.message || 'Comment deleted successfully!', 'success');
                                // Remove the comment from the DOM
                                const commentElement = form.closest('.comment');
                                if (commentElement) {
                                    commentElement.remove();
                                }
                            }
                        } else {
                            displayMessage(result.message || 'An error occurred.', 'error');
                        }
                    } catch (jsonError) {
                        console.error('Error parsing JSON:', jsonError);
                        console.error('Response text:', text);
                        displayMessage('Invalid JSON response from the server.', 'error');
                    }
                } else {
                    console.error('Unexpected content type:', contentType);
                    console.error('Response text:', text);
                    displayMessage('Unexpected response format.', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                displayMessage('Unexpected error occurred. Please try again.', 'error');
            }
        });
    });
});
