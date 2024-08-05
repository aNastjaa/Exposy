<?php

namespace Crmlva\Exposy;

abstract class Util
{
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verifyPassword(string $password, string $hashedPassword): bool
    {
        return password_verify($password, $hashedPassword);
    }

    public static function getUserPhotoUrl(string $photo = null): string
    {
        $defaultPhoto = '/assets/icons/User photo.svg';
        $uploadsPath = '/uploads/';
        
        if ($photo && is_file($_SERVER['DOCUMENT_ROOT'] . $uploadsPath . $photo)) {
            return $uploadsPath . $photo;
        }
  
        return $defaultPhoto;
    }
}
