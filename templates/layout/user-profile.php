<div class="account">
        <div class="account-info">
            <div class="user-photo">
                <img src="/uploads/<?php echo htmlspecialchars($this->data['photo'], ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($this->data['alt_text'] ?? 'User photo', ENT_QUOTES); ?>" />
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
            <button type="button" class="blind-button" onclick="showLogoutConfirmation()">Log Out</button>
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
        </div>
    </section>

    <!-- Log Out Confirmation Modal -->
    <div id="logout-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeLogoutModal()">&times;</span>
            <p>Are you sure you want to log out?</p>
            <button id="confirm-logout-button" class="modal-blind-button">Confirm</button>
            <button class="modal-cta-button" onclick="closeLogoutModal()">Decline</button>
        </div>
    </div>

    <!-- Account Deletion Confirmation Modal -->
    <div id="delete-account-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteAccountModal()">&times;</span>
            <p>Are you sure you want to delete your account? This action cannot be undone.</p>
            <button id="confirm-delete-button" class="modal-blind-button">Confirm</button>
            <button class="modal-cta-button" onclick="closeDeleteAccountModal()">Cancel</button>
        </div>
    </div>

    <div id="response-message" class="response-message" style="display: none;">
        <p class="response-text"></p>
    </div>