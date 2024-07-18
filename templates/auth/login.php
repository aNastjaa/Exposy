<link rel="stylesheet" href="/css/login_signup.css">

<div class="container">   
    <div class="login-container">
    <div class="container-photo">
        <img src="/assets/img/login_photo.jpg" alt="Log in photo">
    </div>
    <div class="form-container">
        <h1>Log in to Exposy</h1>
            <form class="login-form" id="login-form" method="POST">
                <div class="form-row">
                    <div class="input-section full-width">
                        <label for="email">Email</label>
                        <input type="email" placeholder="Enter your email" id="email" name="email"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>">
                            
                            <!-- Error message for email -->
                            <?php $this->renderInputError( 'email' ); ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-section full-width">
                        <label for="pwd">Password</label>
                        <input type="password" name="pwd" placeholder="Enter your password" id="pwd">
                                 
                            <!-- Error message for password -->
                             <?php $this->renderInputError( 'password' ); ?>      
                    </div>
                </div>
                <div class="form-row submit-button full-width">
                    <button type="submit" id="submit-button">Log in</button>
                </div>
                <div class="signup-form-link">
                    <p>Don’t have an account?</p>
                    <a href="/signup.php">Sign up</a>
                </div>
                
            </form>
        </div>    
    </div>

    <div class="close-icon">
    <a href="/index.php">
        <img src="/assets/icons/svg/x_pink.svg" alt="Close" id="close-profile-edit">
    </a>
    </div>
</div>