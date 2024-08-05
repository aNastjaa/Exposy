<?php

namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use PDO;

class UserProfile extends Model
{
    public function getProfileByUserId(int $userId): array
    {
        $query = "SELECT firstname, lastname, gender, city, country, photo, alt_text FROM user_profiles WHERE user_id = :user_id";
        return $this->fetchOne($query, ['user_id' => $userId]);
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

    // Generic method to fetch a single result
    private function fetchOne(string $query, array $params): array
    {
        $stmt = $this->database->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // Generic method to execute queries
    private function execute(string $query, array $params): bool
    {
        $stmt = $this->database->prepare($query);
        return $stmt->execute($params);
    }
}
