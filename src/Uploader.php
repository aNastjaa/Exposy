<?php

namespace Crmlva\Exposy;

use Exception;

class Uploader {
    protected static String $uploadPath = '/Users/crmlva/Documents/Exposy/public/uploads/user_photos/';

    public function handleFileUploads($subdirectory): array {
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];

        $media = [];
        foreach ($_FILES as $file) {
            if ($file['name'] && $file['error']) {
                throw new Exception("File " . $file['name'] . " could not be uploaded. (error $file[error])", 422);
            }
            if ($file['tmp_name'] && !$file['error']) {
                // Validate file type
                if (!in_array($file['type'], $allowedMimeTypes)) {
                    throw new Exception("File type not allowed: " . $file['type'], 422);
                }

                $fullPath = self::$uploadPath . $subdirectory;

                // Create Directory if it does not exist
                if (!file_exists($fullPath)) {
                    mkdir($fullPath, 0755, true);
                }

                // Generate unique filename
                $file['target'] = $this->generateUniqueFilename($fullPath);

                // Move temporary file to final destination
                $fileDestination = $fullPath . $file['target'];
                if (!file_exists($fileDestination)) {
                    move_uploaded_file($file['tmp_name'], $fileDestination);
                }

                // Create and append entry to $media array
                $media[] = [
                    'path' => $subdirectory . $file['target'],
                    'type' => $file['type'],
                    'size' => filesize($fileDestination),
                    'original' => $file['name']
                ];
            }
        }
        return $media;
    }

    public function generateUniqueFilename($path, $prefix = '') {
        $uniqueName = tempnam($path, $prefix);
        unlink($uniqueName);
        return basename($uniqueName);
    }
}
