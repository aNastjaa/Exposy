<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exposy</title>
    <link rel="stylesheet" href="/css/fonts.css">
    <link rel="stylesheet" href="/css/homepage.css">
    <link rel="stylesheet" href="/css/homepageResponsive.css">
    <script src="./js/herosectionSlider.js" defer></script>
    <script src="./js/burgerMenu.js" defer></script>
</head>
<body>
    <header>
        <div class="header-wrapper">
            <nav class="nav-bar">
                <div class="header-logo">
                    <img src="/assets/icons/Logo L.svg" alt="Logo">
                </div>
                <ul class="nav-links">
                    <li class="underline"><a href="#">Home</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Account</a></li>
                </ul>
                <div class="auth-buttons">
                    <button type="button" class="blind-button">Log in</button>
                    <button type="button" class="cta-button">Sign up</button>
                </div>
                <div class="burger-menu">
                    <span class="burger-icon">&#9776;</span> <!-- Icon for the burger menu -->
                    <span class="close-icon">&times;</span> <!-- Icon for the close menu -->
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="hero-section">
            <h1>Welcome to Exposy – Your Gateway to Art Events </h1>
            <h3>Discover, Explore, save, and create <br> 
                Free  Exhibitions in Germany</h3>
            <button type="button" class="cta-button">Get started</button>
        </div>
        <div class="event-scroller">
        <div id="event-cards-container" class="event-cards-container">
            <!-- Event cards will be dynamically added here -->
        </div>
        </div>
    </main>
</body>
</html>