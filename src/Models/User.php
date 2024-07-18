<?php

namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Model;
use Crmlva\Exposy\Util;
use PDOStatement;

class User extends Model
{

    public function create( string $username, string $email, string $password ) : bool|string
    {
        /** @var string */
        $hashed_password = Util::hashPassword( $password );
        /** @var string */
        $query = "INSERT INTO users (username, email, password, created_at) VALUES (:username, :email, :password, NOW())";
        /** @var PDOStatement */
        $stmt = $this->database->prepare($query);

        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashed_password
        ]);

        return $this->database->lastInsertId();
    }

}