<?php

namespace Crmlva\Exposy;

class Uploader
{
    protected static string $uploadPath = UPLOAD_PATH;

    public static function handleFileUploads(string $path): array
    {
        $media = [];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        $maxSize = 5 * 1024 * 1024; // 5MB
        $errors = [];

        // Remove leading/trailing slashes for consistency
        $path = trim($path, '/');
        $datePath = date('Y/m/d/');
        $fullPath = self::$uploadPath . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $datePath;

        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        foreach ($_FILES as $file) {
            if ($file['error'] == UPLOAD_ERR_NO_FILE) {
                // Specific error message for no file uploaded
                $errors[] = "No file was added. Please choose a photo and try again.";
                continue;
            }

            if ($file['error']) {
                // Other file upload errors
                $errors[] = "An error occurred while uploading the file " . $file['name'] . ". (error $file[error])";
                continue;
            }

            if ($file['tmp_name']) {
                if (!in_array($file['type'], $allowedTypes)) {
                    $errors[] = "File type not allowed for " . $file['name'];
                    continue;
                }

                if ($file['size'] > $maxSize) {
                    $errors[] = "File " . $file['name'] . " exceeds the maximum allowed size";
                    continue;
                }

                $file['target'] = self::generateUniqueFilename($fullPath);
                $fileDestination = $fullPath . DIRECTORY_SEPARATOR . $file['target'];

                if (move_uploaded_file($file['tmp_name'], $fileDestination)) {
                    $media[] = [
                        'path' => $path . '/' . $datePath . $file['target'],
                        'type' => $file['type'],
                        'size' => filesize($fileDestination),
                        'original' => $file['name'],
                        'alt' => $_POST['alt_text'] ?? ''
                    ];
                } else {
                    $errors[] = "Failed to move uploaded file " . $file['name'];
                }
            }
        }

        // Check if alt text is empty
        if (empty($_POST['alt_text'])) {
            $errors[] = "The alternative text cannot be empty. Please provide a description for your photo.";
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
        return basename($uniqueName);
    }
}
