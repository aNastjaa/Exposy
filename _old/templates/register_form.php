
<div id="additional-info" class="additional-info">
    <form class="profile-form" id="profile-form" method="POST">
        <div class="form-row">
            <div class="input-section">
                <label for="firstname">First name</label>
                    <input type="text" placeholder="Enter your first name" id="firstname" name="firstname"
                    value="<?php echo htmlspecialchars($_POST['firstname'] ?? '', ENT_QUOTES); ?>">
                    
                    <!-- Error message for firstname -->
                    <?php renderInputError( 'firstname' ); ?>
            </div>
            <div class="input-section">
                    <label for="lastname">Last name</label>
                        <input type="text" placeholder="Enter your last name" id="lastname" name="lastname"
                        value="<?php echo htmlspecialchars($_POST['lastname'] ?? '', ENT_QUOTES); ?>">
                        
                        <!-- Error message for lastname -->
                        <?php renderInputError( 'lastname' ); ?>
            </div>
        </div>
            <div class="radio-section">
                <input type="radio" id="male" name="sex" value="Male" <?php echo (isset($_POST['sex']) && $_POST['sex'] === 'Male') ? 'checked' : ''; ?>>
                    <label for="male">Male</label>
                <input type="radio" id="female" name="sex" value="Female" <?php echo (isset($_POST['sex']) && $_POST['sex'] === 'Female') ? 'checked' : ''; ?>>
                    <label for="female">Female</label>
                <input type="radio" id="diverse" name="sex" value="Diverse" <?php echo (isset($_POST['sex']) && $_POST['sex'] === 'Diverse') ? 'checked' : ''; ?>>
                    <label for="diverse">Diverse</label>
                
                    <!-- Error message for sex -->
                    <?php renderInputError( 'sex' ); ?>
            </div>
            <div class="form-row">
    <div class="input-section">
        <label for="country">Choose your country</label>
        <select id="country" name="country">
            <option value="none" selected disabled>--Choose your country--</option>
            <option value="Germany" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Germany') ? 'selected' : ''; ?>>Germany</option>
            <option value="Austria" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Austria') ? 'selected' : ''; ?>>Austria</option>
            <option value="Belgium" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Belgium') ? 'selected' : ''; ?>>Belgium</option>
            <option value="Czech Republic" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Czech Republic') ? 'selected' : ''; ?>>Czech Republic</option>
            <option value="Denmark" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Denmark') ? 'selected' : ''; ?>>Denmark</option>
            <option value="France" <?php echo (isset($_POST['country']) && $_POST['country'] === 'France') ? 'selected' : ''; ?>>France</option>
            <option value="Hungary" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Hungary') ? 'selected' : ''; ?>>Hungary</option>
            <option value="Italy" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Italy') ? 'selected' : ''; ?>>Italy</option>
            <option value="Luxembourg" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Luxembourg') ? 'selected' : ''; ?>>Luxembourg</option>
            <option value="Netherlands" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Netherlands') ? 'selected' : ''; ?>>Netherlands</option>
            <option value="Poland" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Poland') ? 'selected' : ''; ?>>Poland</option>
            <option value="Slovakia" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Slovakia') ? 'selected' : ''; ?>>Slovakia</option>
            <option value="Switzerland" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Switzerland') ? 'selected' : ''; ?>>Switzerland</option>
            <option value="Liechtenstein" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Liechtenstein') ? 'selected' : ''; ?>>Liechtenstein</option>
            <option value="Slovenia" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Slovenia') ? 'selected' : ''; ?>>Slovenia</option>
            <option value="Croatia" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Croatia') ? 'selected' : ''; ?>>Croatia</option>
        </select>
                        
                        <!-- Error message for country -->
                        <?php renderInputError( 'country' ); ?>
                </div>
                <div class="input-section">
                    <label for="city">City</label>
                        <input type="text" placeholder="Enter your city" id="city" name="city"
                        value="<?php echo htmlspecialchars($_POST['city'] ?? '', ENT_QUOTES); ?>">
                        
                        <!-- Error message for city -->
                        <?php renderInputError( 'city' ); ?>
                </div>
            </div>
            <div class="form-row">
                <div class="input-section full-width">
                    <label for="email">Email</label>
                    <input type="email" placeholder="Enter your email" id="email" name="email"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
                    
                    <!-- Error message for email -->
                    <?php renderInputError( 'email' ); ?>
                </div>
            </div>
            <div class="form-row">
                <div class="input-section full-width">
                    <label for="pwd">Password</label>
                        <div class="input-icon-container">
                            <input type="password" name="pwd" placeholder="Enter your password" id="pwd">
                                <img src="../assets/icons/svg/info.svg" alt="Info" class="password-icon"> 
                                    <div class="password-requirements">
                                        <p>Password Requirements:</p>
                                            <small>- At least 8 characters long</small> <br>
                                            <small>- At least one lowercase letter</small> <br>
                                            <small>- At least one uppercase letter</small> <br>
                                            <small>- At least one number</small> <br>
                                            <small>- At least one special character</small> <br>
                                            <small- No spaces allowed></small> 
                                    </div>

                                    <!-- Error message for password -->
                                    <?php renderInputError( 'password' ); ?>
                        </div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-section checkbox-section">
                    <input type="checkbox" id="terms" name="terms" value="Terms" <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>>
                    <label class="terms" for="terms">I agree with Exposy's Terms of Service and Privacy Policy.</label>
                                    
                    <!-- Error message for terms -->
                    <?php renderInputError( 'terms' ); ?>
                </div>
            </div>
            <input type="hidden" value="<?= createNonce() ?>" name="nonce">
            
              <!-- Display status message -->
            <?php if (isset($_SESSION['status_message'])): ?>
                <div class="status-message">
                    <?php echo $_SESSION['status_message']; ?>
                </div>
                <?php unset($_SESSION['status_message']);?>
            <?php endif; ?>
            
            <div class="form-row submit-button full-width">
                <button type="submit" id="submit-button">Submit</button>
            </div>

           
    </form>
</div>