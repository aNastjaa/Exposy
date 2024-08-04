<!-- edit-profile.php -->
<form class="profile-form" id="edit-profile-dsts" method="POST">
    <h3>Edit your profile information:</h3>
    <div class="form-row">    
        <div class="input-section">
            <label for="username">New username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your new username">
            <?php $this->renderInputError('username'); ?>
        </div>
    </div>
    <div class="form-row">  
        <div class="input-section">
            <label for="email">New Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your new email">
            <?php $this->renderInputError('email'); ?>
        </div>
    </div>
    <div class="form-row submit-button full-width">
        <button type="submit" id="save-change-button">Save changes</button>
    </div>
</form>
<form class="profile-form" id="edit-password" method="POST">
    <div class="form-row">    
        <div class="input-section full-width">
            <label for="pwd_rep">Old password</label>
            <input type="password" name="password" placeholder="Enter your old password" id="pwd_rep">
            <?php $this->renderInputError('password'); ?>      
        </div>
    </div>
    <div class="form-row">
        <div class="input-section full-width">
            <label for="pwd">New Password</label>
            <div class="input-icon-container">
                <input type="password" name="new-password" placeholder="Enter your new password" id="pwd">
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
                <?php $this->renderInputError('password'); ?>
            </div>
        </div>
    </div>
    
    <div class="form-row submit-button full-width">
        <button type="submit" id="save-change-button">Save changes</button>
    </div>
</form>
