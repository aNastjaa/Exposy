<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->title(); ?></title>
    <link rel="stylesheet" href="/css/login_signup.css">
    <script src="/js/password.js" defer></script>
</head>
<body>
<div class="container">   
    <div class="signup-container">
        <div class="container-photo">
            <img src="/assets/img/signup_photo.jpg" alt="Log in photo">
        </div>
    <div class="form-container">
        <h1>Sign up to Exposy</h1>
            <form class="login-form" id="login-form" method="POST">
            <div class="form-row">    
                <div class="input-section full-width">
                    <label for="username">Username</label>
                        <input type="text" placeholder="Enter your user name" id="username" name="username"
                        value="<?php echo $this->getInputValue('username'); ?>">
                        
                        <!-- Error message for firstname -->
                        <?php $this->renderInputError( 'username' ); ?>
                </div>
            </div>
                <div class="form-row">
                    <div class="input-section full-width">
                        <label for="email">Email</label>
                        <input type="email" placeholder="Enter your email" id="email" name="email"
                        value="<?php echo $this->getInputValue('email'); ?>">
                            
                            <!-- Error message for email -->
                            <?php $this->renderInputError( 'email' ); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-section full-width">
                        <label for="pwd">Password</label>
                            <div class="input-icon-container">
                                <input type="password" name="password" placeholder="Enter your password" id="pwd">
                                    <img src="../assets/icons/svg/info.svg" alt="Info" class="password-icon"> 
                                        <div class="password-requirements">
                                            <p>Password Requirements:</p>
                                                <small>- At least 8 characters long</small> <br>
                                                <small>- At least one lowercase letter</small> <br>
                                                <small>- At least one uppercase letter</small> <br>
                                                <small>- At least one number</small> <br>
                                                <small>- At least one special character</small> <br>
                                                <small>- No spaces allowed</small> 
                                        </div>

                                        <!-- Error message for password -->
                                        <?php $this->renderInputError( 'password' ); ?>
                            </div>
                    </div>
                </div>
                <div class="form-row">    
                    <div class="input-section full-width">
                        <label for="pwd_rep">Repeat password</label>
                        <input type="password" name="pwd_rep" placeholder="Repeat your password" id="pwd_rep">
                                 
                            <!-- Error message for password repeat -->
                             <?php $this->renderInputError( 'password_repeat' ); ?>      
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-section checkbox-section">
                        <input type="checkbox" id="terms" name="terms" value="Terms"
                        value="Terms" <?php echo isset($_POST['terms']) ? 'checked' : ''; ?>>
                        <label class="terms" for="terms">I agree with Exposy's Terms of Service and Privacy Policy.</label>
                                        
                        <!-- Error message for terms -->
                        <?php $this->renderInputError( 'terms' ); ?>
                    </div>
                </div>

                <?php if (!empty($errors['general'])): ?>
                    <div class="errors">
                        <div class="error">
                            <strong>General:</strong>
                            <ul>
                                <li><?php echo htmlspecialchars($errors['general']); ?></li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-row submit-button full-width">
                    <button type="submit" id="submit-button">Create account</button>
                </div>
                <div class="signup-form-link">
                    <p>Already have an account?</p>
                    <a href="/login">Log in</a>
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
    </div>

    <div class="close-icon">
    <a href="/index.php">
        <img src="/assets/icons/svg/x_pink.svg" alt="Close" id="close-profile-edit">
    </a>
    </div>
</div>
</body>
</html>