<div class="account">
    <div class="account-info">
        <div class="user-photo">
            <img src="/assets/icons/User photo.svg" alt="User photo">
        </div>
        <div class="user-data">
            <h2><?php echo htmlspecialchars($this->data['username'] ?? ''); ?></h2>
            <p><?php echo htmlspecialchars($this->data['city'] ?? ''); ?>, <?php echo htmlspecialchars($this->data['country'] ?? ''); ?></p>
        </div>
    </div>
    <div class="account-buttons">
        <button type="button" class="blind-button" onclick="showSection('general')">General</button>
        <button type="button" class="blind-button" onclick="showSection('edit-profile')">Edit Profile</button>
        <button type="button" class="blind-button" onclick="showSection('delete-profile')">Delete Account</button>
        <button type="button" class="blind-button" onclick="window.location.href='/index.php?action=logout'">Log Out</button>
    </div>
</div>

<section id="profile-edit">
    <div class="edit-container">
        <div class="heading-content">
            <div class="photo-username">
                <div class="username-category">
                    <span><?php echo htmlspecialchars($this->data['username'] ?? ''); ?></span>
                    <p class="edit-category gray">/Profile</p>
                </div>
            </div>
            <div class="close-icon">
                <img src="/assets/icons/svg/x_pink.svg" alt="Close" onclick="hideAllSections()">
            </div>
        </div>
        
        <div class="categories-and-form">
            <div id="general" class="section">
                <?php include __DIR__ . '/user-profile-form.php'; ?>
            </div>
            <div id="edit-profile" class="section">
                <?php include __DIR__ . '/edit-profile.php'; ?>
            </div>
            <div id="delete-profile" class="section">
                <?php include __DIR__ . '/delete-profile.php'; ?>
            </div>
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

        <?php if (!empty($success)): ?>
            <div id="success-popup" class="popup">
                <p><?php echo htmlspecialchars($success, ENT_QUOTES); ?></p>
                <button id="close-popup-button">Close</button>
            </div>
        <?php endif; ?>
    </div>
</section>
