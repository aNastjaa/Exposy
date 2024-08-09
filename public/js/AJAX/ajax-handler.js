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

    // AJAX for event saving process
    document.querySelectorAll('.save-event-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const eventId = this.closest('form').querySelector('input[name="event_id"]').value;
            
            console.log('Event ID:', eventId);
            
            fetch('/save-event', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ event_id: eventId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

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
