<div class="user_created-events">
<div class="saved-events" id="rounded-tab-left">
        <h3>Created Events</h3>
    </div>
    <div class="created-events-container">
        <div class="hearind-create-event">
            <h4>Create your own event:</h4>
        </div>
        <div class="create-event">
            <form class="add-event" action="/" method="POST" enctype="multipart/form-data">
                    <label for="title">Event Title:</label>
                    <input type="text" id="title" name="title" required>

                    <label for="img">Event Image:</label>
                    <input type="file" id="img" name="img" accept="image/*" required>

                    <label for="gallery">Gallery (optional):</label>
                    <input type="text" id="gallery" name="gallery">

                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location">

                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date">

                    <label for="time">Time:</label>
                    <input type="time" id="time" name="time">

                    <label for="description">Description:</label>
                    <textarea id="description" name="description"></textarea>

                    <label for="contact_information">Contact Information:</label>
                    <textarea id="contact_information" name="contact_information"></textarea>

                    <button type="submit" class="cta-button">Create Event</button>
                </form>
            </div>
        </div>
    </div>
<?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>