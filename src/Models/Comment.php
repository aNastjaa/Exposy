<?php

namespace Crmlva\Exposy\Models;

use Crmlva\Exposy\Database;
use PDO;

class Comment
{
    private PDO $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function getCommentsByEventId(int $eventId): array
{
    $query = "SELECT * FROM comments WHERE event_id = :event_id";
    $statement = $this->database->prepare($query);
    $statement->execute(['event_id' => $eventId]);
    return $statement->fetchAll(\PDO::FETCH_ASSOC);
}

    public function addComment(int $eventId, int $userId, string $commentText): bool
    {
        // Replace this with actual database insertion logic
        $query = "INSERT INTO comments (event_id, user_id, comment) VALUES (:event_id, :user_id, :comment)";
        $statement = $this->database->prepare($query);
        return $statement->execute(['event_id' => $eventId, 'user_id' => $userId, 'comment' => $commentText]);
    }

    public function updateComment(int $commentId, string $commentText): bool
    {
        // Replace this with actual database update logic
        $query = "UPDATE comments SET comment = :comment WHERE id = :comment_id";
        $statement = $this->database->prepare($query);
        return $statement->execute(['comment' => $commentText, 'comment_id' => $commentId]);
    }

    public function deleteComment(int $commentId): bool
    {
        // Replace this with actual database deletion logic
        $query = "DELETE FROM comments WHERE id = :comment_id";
        $statement = $this->database->prepare($query);
        return $statement->execute(['comment_id' => $commentId]);
    }


    // New method to get username by user ID
    public function getUsernameById(int $userId): ?string
    {
        $query = "SELECT username FROM users WHERE id = :user_id";
        $statement = $this->database->prepare($query);
        $statement->execute(['user_id' => $userId]);
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        return $user['username'] ?? null;
    }
}

