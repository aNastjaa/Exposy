<?php

namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use Crmlva\Exposy\Util;
use PDO;

class User extends Model
{
    public int $id;
    public string $username;
    public string $email;
    public string $password;
    public string $created_at;

    public function getByEmail(string $email): ?array
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->database->prepare($query);
        $stmt->execute([':email' => $email]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getByUsername(string $username): ?array
    {
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->database->prepare($query);
        $stmt->execute([':username' => $username]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getById(int $id): array
    {
        $query = "SELECT username,email FROM users WHERE id = :id";
        $stmt = $this->database->prepare($query);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(string $username, string $email, string $password): bool|string
    {
        // Check for existing username
        if ($this->getByUsername($username)) {
            return 'Username already exists';
        }

        // Check for existing email
        if ($this->getByEmail($email)) {
            return 'Email already exists';
        }

        $hashed_password = Util::hashPassword($password);
        $query = "INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, NOW())";
        $stmt = $this->database->prepare($query);

        try {
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed_password
            ]);

            return $this->database->lastInsertId();
        } catch (\PDOException $e) {
            // Handle other SQL errors (e.g., connection issues)
            return 'Database error: ' . $e->getMessage();
        }
    }

    public static function findByEmail(string $email): ?self
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = self::getDatabaseInstance()->prepare($query);
        $stmt->execute([':email' => $email]);

        $result = $stmt->fetchObject(self::class);
        return $result ?: null;
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}
