<?php
namespace Crmlva\Exposy;

function require_autoloader(): void {
    $autoload_file = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

    if (!file_exists($autoload_file)) {
        trigger_error(
            sprintf(
                'The autoload file (%1$s) doesn\'t exist. Please run \'composer update\'.',
                $autoload_file
            ),
            E_USER_ERROR
        );
    }

    require_once $autoload_file;
}

function require_configuration(): void {
    $config_file = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php';

    if (!file_exists($config_file)) {
        trigger_error(
            sprintf(
                'The configuration file (%1$s) doesn\'t exist.',
                $config_file
            ),
            E_USER_ERROR
        );
    }

    require_once $config_file;
}

// Call these functions to ensure configuration is loaded
require_configuration();
require_autoloader();

// Initialize and bootstrap the application
(new App())->bootstrap();
