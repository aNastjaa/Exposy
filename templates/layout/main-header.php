<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($this->title()) ?></title>
    
    <?php
        $this->embedStylesheets([
            '/css/header.css',
            '/css/footer.css',
            '/css/headerAndFooterResponsive.css',
            '/css/global.css',
            '/css/account.css',
            '/css/form.css',
            '/css/events.css'
        ]);
        $this->embedScripts([
            '/js/burgerMenu.js',
            '/js/templates.js',
            '/js/AJAX/ajax-general.js',
            '/js/AJAX/ajax-add-photo.js',
            '/js/AJAX/ajax-edit-profile-dsts.js',
            '/js/AJAX/ajax-password-update.js',
            '/js/AJAX/ajax-handler.js',
            '/js/popup.js',
            '/js/password.js',
            '/js/realTimeValidation.js'
        ]);
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
                    <li class="<?= (isset($this->data['currentPage']) && $this->data['currentPage'] === 'events') ? 'underline' : '' ?>">
                        <a href="/events">Events</a>
                    </li>
                    <li class="<?= (isset($this->data['currentPage']) && $this->data['currentPage'] === 'account') ? 'underline' : '' ?>">
                        <a href="/account">Account</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    