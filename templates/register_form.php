
<div id="additional-info" class="additional-info">
    <form class="profile-form" id="profile-form" method="POST">
        <div class="form-row">
            <div class="input-section">
                <label for="firstname">First name</label>
                    <input type="text" placeholder="Enter your first name" id="firstname" name="firstname">
                    
                    <!-- Error message for firstname -->
                    <?php renderInputError( 'firstname' ); ?>
            </div>
            <div class="input-section">
                    <label for="lastname">Last name</label>
                        <input type="text" placeholder="Enter your last name" id="lastname" name="lastname">
                        
                        <!-- Error message for lastname -->
                        <?php renderInputError( 'lastname' ); ?>
            </div>
        </div>
            <div class="radio-section">
                <input type="radio" id="male" name="sex" value="Male">
                    <label for="male">Male</label>
                <input type="radio" id="female" name="sex" value="Female">
                    <label for="female">Female</label>
                <input type="radio" id="diverse" name="sex" value="Diverse">
                    <label for="diverse">Diverse</label>
                
                    <!-- Error message for sex -->
                    <?php renderInputError( 'sex' ); ?>
            </div>
            <div class="form-row">
                <div class="input-section">
                    <label for="country">Choose your country</label>
                         <select id="country" name="country">
                            <option value="none" selected disabled>--Choose your country--</option>
                            <option value="Germany">Germany</option>
                            <option value="Austria">Austria</option>
                            <option value="Belgium">Belgium</option>
                            <option value="Czech Republic">Czech Republic</option>
                            <option value="Denmark">Denmark</option>
                            <option value="France">France</option>
                            <option value="Hungary">Hungary</option>
                            <option value="Italy">Italy</option>
                            <option value="Luxembourg">Luxembourg</option>
                            <option value="Netherlands">Netherlands</option>
                            <option value="Poland">Poland</option>
                            <option value="Slovakia">Slovakia</option>
                            <option value="Switzerland">Switzerland</option>
                            <option value="Liechtenstein">Liechtenstein</option>
                            <option value="Slovenia">Slovenia</option>
                            <option value="Croatia">Croatia</option>
                        </select>
                        
                        <!-- Error message for country -->
                        <?php renderInputError( 'country' ); ?>
                </div>
                <div class="input-section">
                    <label for="city">City</label>
                        <input type="text" placeholder="Enter your city" id="city" name="city">
                        
                        <!-- Error message for city -->
                        <?php renderInputError( 'city' ); ?>
                </div>
            </div>
            <div class="form-row">
                <div class="input-section full-width">
                    <label for="email">Email</label>
                    <input type="email" placeholder="Enter your email" id="email" name="email">
                    
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
                                            <ul>
                                                <li>- At least 8 characters long</li>
                                                <li>- At least one lowercase letter</li>
                                                <li>- At least one uppercase letter</li>
                                                <li>- At least one number</li>
                                                <li>- At least one special character</li>
                                                <li>- No spaces allowed</li>
                                            </ul>
                                    </div>

                                    <!-- Error message for password -->
                                    <?php renderInputError( 'password' ); ?>
                        </div>
                </div>
            </div>
            <div class="form-row">
                <div class="input-section checkbox-section">
                    <input type="checkbox" id="terms" name="terms" value="Terms">
                    <label class="terms" for="terms">I agree with Exposy's Terms of Service and Privacy Policy.</label>
                                    
                    <!-- Error message for terms -->
                    <?php renderInputError( 'terms' ); ?>
                </div>
            </div>
            <input type="hidden" value="<?= createNonce() ?>" name="nonce">
            <div class="form-row submit-button full-width">
                <button type="submit" id="submit-button">Submit</button>
            </div>

             <!-- Display status message -->
             <?php if (isset($_SESSION['status_message'])): ?>
                <div class="status-message">
                    <?php echo $_SESSION['status_message']; ?>
                </div>
                <?php unset($_SESSION['status_message']);?>
            <?php endif; ?>
    </form>
</div>