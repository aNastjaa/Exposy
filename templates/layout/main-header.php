<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->title() ?></title>

    <?php
        $this->embedStylesheets(['/css/header.css','/css/footer.css','/css/headerAndFooterResponsive.css','/css/global.css', '/css/account.css', '/css/form.css']);
        $this->embedScripts(['/js/burgerMenu.js', '/js/editProfile.js', '/js/password.js']);
    ?>

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
                        <li><a href="/public/events.php">Events</a></li>
                        <li class="underline"><a href="/public/account.php">Account</a></li>
                    </ul>
                </nav>
            </div>
        </header>