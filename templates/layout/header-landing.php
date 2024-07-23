<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->title() ?></title>

    <?php
           $this->embedStylesheets(['/css/header.css','/css/footer.css','/css/headerAndFooterResponsive.css','/css/global.css','/css/main-landing.css','/css/fonts.css']);
           $this->embedScripts(['/js/heroSectionSlider.js']);
        ?>
</head>
<body>
<header>
        <div class="header-wrapper">
            <nav class="nav-bar">
                <div class="header-logo">
                    <img src="/assets/icons/Logo L.svg" alt="Logo">
                </div>
                <div class="auth-buttons">
                    <button type="button" class="blind-button" onclick="window.location.href='/login'">Log in</button>
                    <button type="button" class="cta-button" onclick="window.location.href='/register'">Sign up</button>
                </div>


            </nav>
        </div>
    </header>

  