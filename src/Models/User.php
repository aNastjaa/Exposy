<?php

namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use PDOStatement;
use Crmlva\Exposy\Util;
class User extends Model
{
    public function getByEmail(string $email): ?array
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->database->prepare($query);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create(string $username, string $email, string $password): bool|string
    {
        $hashed_password = Util::hashPassword($password);
        $query = "INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, NOW())";
        $stmt = $this->database->prepare($query);

        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashed_password
        ]);

        return $this->database->lastInsertId();
    }
}


