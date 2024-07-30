<?php

namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use PDO;

class UserProfile extends Model
{
    // Fetch profile data based on user_id
    public function getProfileByUserId(int $userId): array
    {
        $query = "SELECT firstname, lastname, gender, city, country FROM user_profiles WHERE user_id = :user_id";
        $stmt = $this->database->prepare($query);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // Update or create profile data
    public function updateProfile(int $userId, array $data): bool
    {
        $query = "INSERT INTO user_profiles (user_id, firstname, lastname, gender, city, country)
                  VALUES (:user_id, :firstname, :lastname, :gender, :city, :country)
                  ON DUPLICATE KEY UPDATE firstname = :firstname, lastname = :lastname, gender = :gender, city = :city, country = :country";
        $stmt = $this->database->prepare($query);

        return $stmt->execute([
            ':user_id' => $userId,
            ':firstname' => $data['firstname'] ?? '',
            ':lastname' => $data['lastname'] ?? '',
            ':gender' => $data['gender'] ?? '',
            ':city' => $data['city'] ?? '',
            ':country' => $data['country'] ?? ''
        ]);
    }
}
