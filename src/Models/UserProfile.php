<?php

namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use Crmlva\Exposy\Database;

class UserProfile extends Model
{
    protected $database;

    public function __construct()
    {
        // Initialize the database connection from the Database class
        $this->database = Database::getInstance();
    }

    public function getProfileByUserId(int $userId): array
    {
        $query = "SELECT firstname, lastname, gender, city, country, photo, alt_text FROM user_profiles WHERE user_id = :user_id";
        $result = $this->fetchOne($query, ['user_id' => $userId]);

        // Return an empty array if no profile is found
        return $result ?? [];
    }

    public function updateProfile(int $userId, array $data): bool
    {
        $query = "INSERT INTO user_profiles (user_id, firstname, lastname, gender, city, country, photo, alt_text)
                  VALUES (:user_id, :firstname, :lastname, :gender, :city, :country, :photo, :alt_text)
                  ON DUPLICATE KEY UPDATE firstname = :firstname, lastname = :lastname, gender = :gender, city = :city, country = :country, photo = :photo, alt_text = :alt_text";
        return $this->execute($query, [
            ':user_id' => $userId,
            ':firstname' => $data['firstname'] ?? '',
            ':lastname' => $data['lastname'] ?? '',
            ':gender' => $data['gender'] ?? '',
            ':city' => $data['city'] ?? '',
            ':country' => $data['country'] ?? '',
            ':photo' => $data['photo'] ?? null,
            ':alt_text' => $data['alt_text'] ?? null
        ]);
    }

    public function updatePhoto(int $userId, string $photoUrl): bool
    {
        $query = "UPDATE user_profiles SET photo = :photo WHERE user_id = :user_id";
        return $this->execute($query, [
            ':photo' => $photoUrl,
            ':user_id' => $userId,
        ]);
    }

    public function deleteProfile(int $userId): bool
    {
        $query = "DELETE FROM user_profiles WHERE user_id = :user_id";
        return $this->execute($query, [':user_id' => $userId]);
    }
}
