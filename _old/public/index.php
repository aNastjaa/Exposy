<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exposy</title>
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/headerAndFooterResponsive.css">
    <script src="./js/herosectionSlider.js" defer></script>
    <!-- <script src="./js/burgerMenu.js" defer></script> -->
</head>
<body>
    <header>
        <div class="header-wrapper">
            <nav class="nav-bar">
                <div class="header-logo">
                    <img src="/assets/icons/Logo L.svg" alt="Logo">
                </div>
                <!-- <div class="burger-menu">
                    <span class="burger-icon"><img src="/assets/icons/svg/menu.svg" alt="Menu"></span>
                    <span class="close-icon"><img src="/assets/icons/svg/x (1).svg" alt="Close"></span>
                </div> -->
                <!-- <ul class="nav-links">
                    <li class="underline"><a href="#">Home</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="./pages/account.php">Account</a></li>
                </ul> -->
                <div class="auth-buttons">
                    <button type="button" class="blind-button" onclick="window.location.href='/login.php'" >Log in</button>
                    <button type="button" class="cta-button" onclick="window.location.href='/signup.php'" >Sign up</button>
                </div>
            </nav>
        </div>
    </header>

    <main>

        <div class="hero-section">
            <h1>Welcome to Exposy – Your Gateway to Art Events </h1>
            <h3>Discover, Explore, save, and create <br> 
                Free  Exhibitions in Germany</h3>
            <button type="button" class="cta-button" onclick="window.location.href='/signup.php'" >Get started</button>
        </div>
        <div class="event-scroller">
            <button class="scroll-button left-scroll-button"><img src="/assets/icons/svg/arrow-left.svg" alt="Scroll left"></button> 
            <div id="event-cards-container" class="event-cards-container">
                <!-- Event cards will be dynamically added here -->
            </div>
            <button class="scroll-button right-scroll-button"><img src="/assets/icons/svg/arrow-right.svg" alt="Scrol right"></button>
        </div>
        <div class="about-project">
            <h2>About project</h2>
            <div class="first-section">
                <p>   Welcome to Exposy, your ultimate destination for discovering and experiencing free art exhibitions across Germany. 
                    Our mission is to connect art enthusiasts with the vibrant and diverse art scene, promoting accessibility and appreciation for all forms of art. 
                    We believe art should be accessible to everyone. Whether you're an avid art lover or looking to explore new cultural experiences,
                     our platform helps you find and enjoy free exhibitions happening around Germany. From traditional galleries to contemporary art spaces, we cover a wide range of events to cater to every taste.
                </p>
            </div>
            <h4>What we offer:</h4>
            <div class="second-section">
                <div class="part">
                    <p>
                        <span>Explore and Save Events:</span> Browse our extensive list of upcoming art exhibitions. 
                        Use filters to sort by location, date, and type to find events that interest you. 
                        Save your favorite events to your personal list and never miss an opportunity to 
                        immerse yourself in art. Please note that registration is required to save events.
                    </p>
                </div>
                <div class="part">
                    <p>
                        <span>Add Your Own Event:</span> Do you have a free art event to promote? 
                        Create an account to add your event to our growing list.
                        We'll help you reach a wider audience by promoting your event alongside other exciting exhibitions. 
                        Registration is required to create events.
                    </p>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-wrapper">
            <div class="top-content">
                <div class="footer-logo">
                    <img src="/assets/icons/Logo L.svg" alt="Logo">
                </div>
                <div class="footer-nav">
                    <ul class="nav-links">
                        <li class="underline"><a href="/index.php">Home</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="/account.php">Account</a></li>
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