<form class="profile-form" id="edit-profile-dsts" method="POST" action="/account/edit">
    <h3>Edit your profile information:</h3>
    <div class="form-row">    
        <div class="input-section">
            <label for="username">New username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($this->data['username'] ?? ''); ?>" placeholder="Enter your new username">
            <?php $this->renderInputError('username'); ?>
            <ul class="error-list" id="username-errors"></ul>
        </div>
    </div>
    <div class="form-row">  
        <div class="input-section">
            <label for="email">New Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($this->data['email'] ?? ''); ?>" placeholder="Enter your new email">
            <?php $this->renderInputError('email'); ?>
            <ul class="error-list" id="email-errors"></ul>
        </div>
    </div>
    <div class="form-row submit-button full-width">
        <button type="submit" id="save-change-button">Save changes</button>
    </div>
    <!-- Placeholder for response messages -->
    <div id="changes-response-message" class="response-message" style="display: none;">
        <p class="response-text"></p>
    </div>
</form>


<form class="profile-form" id="edit-password" method="POST" action="/account/edit/password">
    <div class="form-row">    
        <div class="input-section full-width">
            <label for="old-password">Old password</label>
            <input type="password" name="password" placeholder="Enter your current password" id="old-password">
            <?php $this->renderInputError('password'); ?>
            <ul class="error-list" id="current_password-errors"></ul>      
        </div>
    </div>
    <div class="form-row">
        <div class="input-section full-width">
            <label for="new-password">New Password</label>
            <div class="input-icon-container">
                <input type="password" name="new-password" placeholder="Enter your new password" id="new-password">
                <img src="../assets/icons/svg/info.svg" alt="Info" class="password-icon">
                <div class="password-requirements">
                    <p>Password Requirements:</p>
                    <small>- At least 8 characters long</small><br>
                    <small>- At least one lowercase letter</small><br>
                    <small>- At least one uppercase letter</small><br>
                    <small>- At least one number</small><br>
                    <small>- At least one special character</small><br>
                    <small>- No spaces allowed</small>
                </div>
                <?php $this->renderInputError('new-password'); ?>
                <ul class="error-list" id="new_password-errors"></ul>
            </div>
        </div>
    </div>
    <div class="form-row submit-button full-width">
        <button type="submit" id="update-password">Update password</button>
    </div>
    <!-- Placeholder for response messages -->
    <div id="password-response-message" class="response-message" style="display: none;">
        <p class="response-text"></p>
    </div>
</form>
