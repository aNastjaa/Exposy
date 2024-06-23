<?php
session_start();
include('../includes/validate_form.php'); // Ensure correct relative path here
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
    <script src="../js/editProfile.js" defer></script>
    <script src="../js/burgerMenu.js" defer></script>
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
                    <div id="additional-info" class="additional-info">
                        <form id="profile-form" action="../includes/validate_form.php" method="POST">
                            <div class="form-row">
                                <div class="input-section">
                                    <label for="firstname">First name</label>
                                    <input type="text" placeholder="Enter your first name" id="firstname" name="firstname" required>
                                    <p id="error-firstname" class="error-message hide">Invalid first name.</p>
                                    <p id="empty-firstname" class="error-message hide">First name cannot be empty.</p>
                                </div>
                                <div class="input-section">
                                    <label for="lastname">Last name</label>
                                    <input type="text" placeholder="Enter your last name" id="lastname" name="lastname" required>
                                    <p id="error-lastname" class="error-message hide">Invalid last name.</p>
                                    <p id="empty-lastname" class="error-message hide">Last name cannot be empty.</p>
                                </div>
                            </div>
                            <div class="radio-section">
                                <input type="radio" id="male" name="sex" value="Male">
                                <label for="male">Male</label>
                                <input type="radio" id="female" name="sex" value="Female">
                                <label for="female">Female</label>
                                <input type="radio" id="diverse" name="sex" value="Diverse">
                                <label for="diverse">Diverse</label>
                                <p id="error-sex" class="error-message hide">Please select a sex.</p>
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
                                    <p id="error-country" class="error-message hide">Please select a country.</p>
                                </div>
                                <div class="input-section">
                                    <label for="city">City</label>
                                    <input type="text" placeholder="Enter your city" id="city" name="city" required>
                                    <p id="error-city" class="error-message hide">Invalid city.</p>
                                    <p id="empty-city" class="error-message hide">City cannot be empty.</p>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="input-section full-width">
                                    <label for="email">Email</label>
                                    <div class="input-icon-container">
                                        <input type="email" placeholder="Enter your email" id="email" name="email" required>
                                        <p id="error-email" class="error-message hide">Invalid email format.</p>
                                        <p id="empty-email" class="error-message hide">Email cannot be empty.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="input-section full-width">
                                    <label for="pwd">Password</label>
                                    <div class="input-icon-container">
                                        <input type="password" name="pwd" placeholder="Enter your password" id="pwd" required>
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
                                        <p id="error-pwd" class="error-message hide">Invalid password format.</p>
                                        <p id="empty-pwd" class="error-message hide">Password cannot be empty.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="input-section checkbox-section">
                                    <input type="checkbox" id="terms" name="terms" value="Terms">
                                    <label for="terms">I agree with Exposy's Terms of Service and Privacy Policy.</label>
                                    <p id="error-terms" class="error-message hide">You must agree to the terms.</p>
                                </div>
                            </div>
                            <div class="form-row submit-button full-width">
                                <button type="submit" id="submit-button">Submit</button>
                            </div>
                        </form>
                        <!-- Display validation errors or success message here -->
                        <div id="form-message"></div>
                    </div>
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