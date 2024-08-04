<?php

namespace Crmlva\Exposy;

class Uploader
{
    protected static string $uploadPath = UPLOAD_PATH;

    public static function handleFileUploads(string $path): array
    {
        $media = [];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        $maxSize = 5 * 1024 * 1024; 
        $errors = [];

        foreach ($_FILES as $file) {
            if ($file['name'] && $file['error']) {
                $errors[] = "File " . $file['name'] . " could not be uploaded. (error $file[error])";
                continue;
            }

            if ($file['tmp_name'] && !$file['error']) {
                if (!in_array($file['type'], $allowedTypes)) {
                    $errors[] = "File type not allowed for " . $file['name'];
                    continue;
                }

                if ($file['size'] > $maxSize) {
                    $errors[] = "File " . $file['name'] . " exceeds the maximum allowed size";
                    continue;
                }

                $datePath = date('Y/m/d/');
                $fullPath = self::$uploadPath . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $datePath;

                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0700, true);
                }

                $file['target'] = self::generateUniqueFilename($fullPath);

                $fileDestination = $fullPath . $file['target'];
                if (!file_exists($fileDestination)) {
                    move_uploaded_file($file['tmp_name'], $fileDestination);
                }

                $media[] = [
                    'path' => $path . '/' . $datePath . $file['target'],
                    'type' => $file['type'],
                    'size' => filesize($fileDestination),
                    'original' => $file['name'],
                    'alt' => $_POST['alt_text'] ?? ''
                ];
            }
        }

        if (!empty($errors)) {
            http_response_code(422);
            header('Content-Type: application/json');
            echo json_encode(['errors' => $errors]);
            exit;
        }

        return $media;
    }

    public static function generateUniqueFilename(string $path, string $prefix = ''): string
    {
        $uniqueName = tempnam($path, $prefix);
        unlink($uniqueName);
        return substr($uniqueName, strlen($path));
    }
}
