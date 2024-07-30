<div class="account">
    <div class="account-info">
        <div class="user-photo">
            <img src="/assets/icons/User photo.svg" alt="User photo">
        </div>
        <div class="user-data">
            <h2>
                <?php echo htmlspecialchars($this->data['username'] ?? ''); ?>
            </h2>
            <p>
                <?php echo htmlspecialchars($this->data['city'] ?? ''); ?>,
                <?php echo htmlspecialchars($this->data['country'] ?? ''); ?>
            </p>
        </div>
    </div>
    <div class="account-buttons">
        <button type="button" class="blind-button">Edit profile</button>
        <button type="button" class="blind-button" onclick="window.location.href='/index.php?action=logout'">Log Out</button>
    </div>
</div>

<section id="profile-edit">
    <div class="edit-container">
        <div class="heading-content">
            <div class="photo-username">
                <!-- <img src="/assets/icons/User photo.svg" alt="User photo"> -->
                <div class="username-category">
                    <span><?php echo htmlspecialchars($this->data['username'] ?? ''); ?></span>
                    <p class="edit-category gray">/General</p>
                </div>
            </div>
            <div class="close-icon">
                <img src="/assets/icons/svg/x_pink.svg" alt="Close" id="close-profile-edit">
            </div>
        </div>
        <div class="categories-and-Form">
            <div class="category-list">
                <ul class="edit-category">
                    <li class="selected"><a href="#">General</a></li>
                    <li class="gray"><a href="#">Edit profile</a></li>
                    <div class="slice"></div>
                    <li class="delete-account"><a href="#">Delete account</a></li>
                </ul>
            </div>
   
            <!-- Include the user profile form -->
            <?php
                include __DIR__ . '/user-profile-form.php';
            ?>
        </div>
        

        <?php if (!empty($errors)): ?>
            <?php foreach ($errors as $field => $errorList): ?>
                <?php foreach ($errorList as $error): ?>
                    <div class="error-message">
                        <p><?php echo htmlspecialchars($error, ENT_QUOTES); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
           
        <!-- Check for success message in the session -->
        <?php if (!empty($success)): ?>
            <div id="success-popup" class="popup">
                <p><?php echo htmlspecialchars($success, ENT_QUOTES); ?></p>
                <button id="close-popup-button">Close</button>
            </div>
        <?php endif; ?>


    </div>
</section>
