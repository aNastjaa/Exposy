document.addEventListener('DOMContentLoaded', () => {
    // Handle file upload preview and submission
    const form = document.getElementById('edit-add-photo');
    const fileInput = document.getElementById('file-input');
    const photoPreview = document.getElementById('photo-preview');
    const responseMessageDiv = document.getElementById('photo-response-message');
    const responseMessageText = responseMessageDiv.querySelector('.response-text');

    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent the default form submission
            
            const formData = new FormData(form);
            
            // Optionally handle file input change event for preview purposes
            const file = fileInput.files[0];
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
                if (contentType && contentType.includes('application/json')) {
                    const result = await response.json();

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
                } else {
                    // Handle non-JSON responses
                    const text = await response.text();
                    console.error('Error response:', text);
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

    // // AJAX for event saving process
    // document.querySelectorAll('.save-event-button').forEach(button => {
    //     button.addEventListener('click', function(event) {
    //         event.preventDefault();
    //         const eventId = this.closest('form').querySelector('input[name="event_id"]').value;
            
    //         console.log('Event ID:', eventId);
            
    //         fetch('/save-event', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //                 'X-Requested-With': 'XMLHttpRequest'
    //             },
    //             body: JSON.stringify({ event_id: eventId })
    //         })
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data.success) {
    //                 alert(data.message);
                    
    //             } else {
    //                 alert(data.message);
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //         });
    //     });
    // });

    // Deleting event logic
    document.querySelectorAll('.delete-event-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); 

            const form = this.closest('form');
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
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    form.closest('.event-cart-big').remove();
                } else {
                    alert(data.message || 'Error deleting event.');
                }
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });
        });
    });
});


//SAVE EVENT 
document.addEventListener('DOMContentLoaded', () => {
    // Handle saving events via AJAX
    document.querySelectorAll('.save-event-button').forEach(button => {
        button.addEventListener('click', async (event) => {
            event.preventDefault(); // Prevent default form submission

            const form = button.closest('form');
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
                if (contentType && contentType.includes('application/json')) {
                    const result = await response.json();

                    if (result.success) {
                        displayMessage('Event saved successfully!', 'success');
                    } else {
                        displayMessage(result.message || 'Failed to save event.', 'error');
                    }
                } else {
                    displayMessage('Unexpected response format.', 'error');
                }
            } catch (error) {
                console.error('Unexpected error:', error);
                displayMessage('Unexpected error occurred. Please try again.', 'error');
            }
        });
    });

    function displayMessage(message, type) {
        const messageContainer = document.getElementById('message-container');
        const messageText = document.getElementById('message-text');

        messageText.textContent = message;
        messageContainer.style.display = 'block';
        messageContainer.className = `message-container ${type}`;

        // Hide the message after 3 seconds
        setTimeout(() => {
            messageContainer.style.display = 'none';
        }, 3000);
    }
});

//COMENTS
document.addEventListener('DOMContentLoaded', () => {
    // Function to display messages
    function displayMessage(message, type) {
        const messageContainer = document.getElementById('message-container');
        const messageText = document.getElementById('message-text');

        if (messageContainer && messageText) {
            messageText.textContent = message;
            messageContainer.style.display = 'block';
            messageContainer.className = `message-container ${type}`;

            // Hide the message after 5 seconds
            setTimeout(() => {
                messageContainer.style.display = 'none';
            }, 3000);
        } else {
            console.error('Message container or text element not found.');
        }
    }

    // Handle form submissions
    document.addEventListener('submit', async (event) => {
        event.preventDefault();
        const form = event.target;

        // Only handle form submissions if it's a form
        if (form.tagName === 'FORM') {
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

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const result = await response.json();
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
            } catch (error) {
                console.error('Error:', error);
                displayMessage('Unexpected error occurred. Please try again.', 'error');
            }
        }
    });
});





