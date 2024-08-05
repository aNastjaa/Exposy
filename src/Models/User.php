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

    public function __construct()
    {
        $this->database = \Crmlva\Exposy\Database::getInstance();
    }

    public function getByEmail(string $email): ?array
    {
        $query = "SELECT * FROM users WHERE email = :email";
        return $this->fetchOne($query, ['email' => $email]);
    }

    public function getByUsername(string $username): ?array
    {
        $query = "SELECT * FROM users WHERE username = :username";
        return $this->fetchOne($query, ['username' => $username]);
    }

    public function getById(int $id): ?array
    {
        $query = "SELECT * FROM users WHERE id = :id";
        return $this->fetchOne($query, ['id' => $id]);
    }

    public function create(string $username, string $email, string $password): bool|string
    {
        if ($this->getByUsername($username)) {
            return 'Username already exists';
        }

        if ($this->getByEmail($email)) {
            return 'Email already exists';
        }

        $hashedPassword = Util::hashPassword($password);
        $query = "INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, NOW())";
        
        return $this->execute($query, [
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]) ? $this->database->lastInsertId() : 'Database error';
    }

    public function updateUserProfile(int $userId, string $username, string $email): bool
    {
        $query = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        return $this->execute($query, [
            ':username' => $username,
            ':email' => $email,
            ':id' => $userId
        ]);
    }

    public function updateUserPassword(int $userId, string $hashedPassword): bool
    {
        $query = "UPDATE users SET password = :password WHERE id = :id";
        return $this->execute($query, [
            ':password' => $hashedPassword,
            ':id' => $userId
        ]);
    }

    public function verifyPassword(string $password): bool
    {
        return Util::verifyPassword($password, $this->password);
    }

    public function deleteUser(int $userId): bool
    {
        $query = "DELETE FROM users WHERE id = :id";
        return $this->execute($query, [':id' => $userId]);
    }

    private function fetchOne(string $query, array $params): ?array
    {
        $stmt = $this->database->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function execute(string $query, array $params): bool
    {
        $stmt = $this->database->prepare($query);
        return $stmt->execute($params);
    }
}
