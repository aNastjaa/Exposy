<?php

namespace Crmlva\Exposy;

abstract class Session 
{
    public function createNonce() : string 
    {
        $nonce = bin2hex( random_bytes( 16 ) );
        $_SESSION['nonce'] = $nonce;
        return $nonce;
    }

    public static function get(string $key, $default = null) : mixed
    {
        return self::has($key) ? $_SESSION[$key] : null;
    }
    
    public function getNonce() : string 
    {
        return $_SESSION['nonce'] ?? '';
    }

    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]) ? true : false;
    }

    public static function set( string $name, mixed $value) : void
    {
        $_SESSION[$name] = $value;
    }

    public static function start() : void
    {
        session_start();
    }
}