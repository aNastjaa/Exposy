<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->title() ?></title>

    <?php
        $this->embedStylesheets(['/css/header.css','/css/footer.css','/css/headerAndFooterResponsive.css','/css/global.css', '/css/account.css', '/css/form.css']);
        $this->embedScripts(['/js/burgerMenu.js', '/js/editProfile.js', '/js/popup.js','/js/password.js','/js/realTimeValidation.js']);
    ?>
<style>
        .blind-button {
            padding: 0.3rem 0.9rem;
            border-radius: 30px;
            background-color: #F7F7F7;
            border: none;
            font-family: "Bebas Neue", sans-serif;
            color: #272727;
            font-size: 20px;
            letter-spacing: 1.2px;
            transition: all 0.1s ease-in-out;
        }

        .blind-button:hover {
            cursor: pointer;
            border: #272727 2px solid;
        }

        .cta-button {
            padding: 0.5rem 1.1rem;
            border-radius: 30px;
            background-color: #FE7999;
            border: none;
            font-family: "Bebas Neue", sans-serif;
            color: #F7F7F7;
            font-size: 20px;
            letter-spacing: 1.2px;
            transition: all 0.3s ease-in-out;
        }

        .cta-button:hover {
            cursor: pointer;
            background-color: #DD4A6D;
            transform: scale(1.1);
        }
    </style>
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
                        <li><a href="/public/events.php">Events</a></li>
                        <li class="underline"><a href="/public/account.php">Account</a></li>
                    </ul>
                </nav>
            </div>
        </header>