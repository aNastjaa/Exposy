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

    /**
     * Get the profile of a user by their user ID.
     *
     * @param int $userId The ID of the user.
     * @return array The profile data of the user.
     */
    public function getProfileByUserId(int $userId): array
    {
        $query = "SELECT firstname, lastname, gender, city, country, photo, alt_text FROM user_profiles WHERE user_id = :user_id";
        return $this->fetchOne($query, ['user_id' => $userId]);
    }

    /**
     * Update or insert a user profile.
     *
     * @param int $userId The ID of the user.
     * @param array $data The profile data to update or insert.
     * @return bool True on success, false on failure.
     */
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

    /**
     * Update the profile photo for a user.
     *
     * @param int $userId The ID of the user.
     * @param string $photoUrl The URL of the new photo.
     * @return bool True on success, false on failure.
     */
    public function updatePhoto(int $userId, string $photoUrl): bool
    {
        $query = "UPDATE user_profiles SET photo = :photo WHERE user_id = :user_id";
        return $this->execute($query, [
            ':photo' => $photoUrl,
            ':user_id' => $userId,
        ]);
    }

    /**
     * Delete a user profile.
     *
     * @param int $userId The ID of the user.
     * @return bool True on success, false on failure.
     */
    public function deleteProfile(int $userId): bool
    {
        $query = "DELETE FROM user_profiles WHERE user_id = :user_id";
        return $this->execute($query, [':user_id' => $userId]);
    }
}
