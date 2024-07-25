<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="/css/login_signup.css">
</head>
<body>
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
                        <input type="email" placeholder="Enter your email" id="email" name="email" value="<?php echo htmlspecialchars($submitted_data['email'] ?? '', ENT_QUOTES); ?>">
                        <?php if (isset($errors['email'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($errors['email'][0], ENT_QUOTES); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-section full-width">
                        <label for="pwd">Password</label>
                        <input type="password" name="password" placeholder="Enter your password" id="pwd">
                        <?php if (isset($errors['password'])): ?>
                            <div class="error-message"><?php echo htmlspecialchars($errors['password'][0], ENT_QUOTES); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-row submit-button full-width">
                    <button type="submit" id="submit-button">Log in</button>
                </div>
                <div class="signup-form-link">
                    <p>Don’t have an account?</p>
                    <a href="/register">Sign up</a>
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
</body>
</html>
