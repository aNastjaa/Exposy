<?php
session_start();
include __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../scripts/validate_form.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exposy</title>
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/account.css">
    <link rel="stylesheet" href="/css/headerAndFooterResponsive.css">
    <link rel="stylesheet" href="/css/form.css">
    <script src="/js/editProfile.js" defer></script>
    <script src="/js/burgerMenu.js" defer></script>
    <!-- <script src="../js/formValidation.js" defer></script> -->
</head>
<body>    
    <header>
        <div class="header-wrapper">
            <nav class="nav-bar">
                <div class="header-logo">
                    <img src="/assets/icons/Logo L.svg" alt="Logo">
                </div>
                <div class="burger-menu">
                    <span class="burger-icon"><img src="/assets/icons/svg/menu.svg" alt="Menu"></span>
                    <span class="close-icon"><img src="/assets/icons/svg/x (1).svg" alt="Close"></span>
                </div>
                <ul class="nav-links">
                    <li ><a href="/index.php">Home</a></li>
                    <li><a href="#">Events</a></li>
                    <li class="underline"><a href="#">Account</a></li>
                </ul>
                <!-- <div class="auth-buttons">
                    <button type="button" class="blind-button">Log in</button>
                    <button type="button" class="cta-button">Sign up</button>
                </div> -->
            </nav>
        </div>
    </header>
    <main>
        <div class="account">
            <div class="account-info">
                <div class="user-photo">
                    <img src="/assets/icons/User photo.svg" alt="User photo">

                </div>
                <div class="user-data">
                    <h2>@Username</h2>
                    <p>City, Country</p>
                </div>
            </div>
            <div class="account-buttons">
                <button type="button" class="blind-button">Edit profile</button>
                <button type="button" class="blind-button">Log Out</button>
            </div> 
        </div>
        <section id="profile-edit">
            <div class="edit-container">
                <div class="heading-content">
                    <div class="photo-username">
                        <img src="/assets/icons/User photo.svg" alt="User photo">
                        <div class="username-category">
                            <span>Username</span> 
                            <span class="edit-category">/General</span>
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
                    <?php 
                    include __DIR__ . '/../templates/register_form.php'; 
                
                    // Clear errors after displaying
                    if (isset($_SESSION['errors'])) {
                        unset($_SESSION['errors']);
                    }
                    ?>
                </div>
            </div>
            
        </section>
    </main>

    <footer>
        <div class="footer-wrapper">
            <div class="top-content">
                <div class="footer-logo">
                    <img src="/assets/icons/Logo L.svg" alt="Logo">
                </div>
                <div class="footer-nav">
                    <ul class="nav-links">
                        <li ><a href="/index.php">Home</a></li>
                        <li><a href="#">Events</a></li>
                        <li class="underline"><a href="/pages/account.php">Account</a></li>
                    </ul>
                </div>
                <div class="footer-soc-icons">
                    <img src="/assets/icons/svg/instagram.svg" alt="instagram">
                    <img src="/assets/icons/svg/facebook.svg" alt="facebook" >
                    <img src="/assets/icons/svg/twitter.svg" alt="twitter">
                </div>
            </div>
            <div class="bottom-content">
                <span class="copyright">&copy; Exposy 2024 </span>
                <div class="footer-terms">
                    <ul class="nav-terms">
                        <li ><a href="#">Terms</a></li>
                        <li><a href="#">Privacy</a></li>
                        <li><a href="#">Cookies</a></li>
                    </ul>
                </div>
                <span class="footer-email">exposy@gmail.com </span>
            </div>
        </div>
    </footer>
</body>
</html>