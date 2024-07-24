<?php

namespace Crmlva\Exposy;

class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, $default = null)
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function delete(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function clear(string $key): void
    {
        self::start();
        self::delete($key);
    }

    public static function clearAll(): void
    {
        self::start();
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
    }
}
