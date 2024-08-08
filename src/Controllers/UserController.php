<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Models\UserProfile;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Validators\Validation;
use Crmlva\Exposy\Uploader;
use Crmlva\Exposy\Models\Event;

class UserController extends Controller
{
    public function profile(): void
{
    $userId = Session::get('user_id');
    if (!$userId) {
        $this->redirect('/login');
        return;
    }

    $userModel = new User();
    $user = $userModel->getById($userId);

    $profileModel = new UserProfile();
    $profile = $profileModel->getProfileByUserId($userId);

    $eventModel = new Event();
    $savedEvents = $eventModel->getSavedEventsByUserId($userId);

    if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
        $this->handleProfileUpdate($userId);
    } else {
        $this->renderView('account', [
            'username' => $user['username'],
            'email' => $user['email'],
            'firstname' => $profile['firstname'] ?? '',
            'lastname' => $profile['lastname'] ?? '',
            'gender' => $profile['gender'] ?? '',
            'city' => $profile['city'] ?? '',
            'country' => $profile['country'] ?? '',
            'photo' => $profile['photo'] ?? 'assets/icons/User photo.svg',
            'alt_text' => $profile['alt_text'] ?? 'User photo',
            'savedEvents' => $savedEvents,
            'title' => 'Account',
            'errors' => $_SESSION['errors'] ?? [],
            'success' => $_SESSION['success'] ?? ''
        ]);

        unset($_SESSION['errors'], $_SESSION['success']);
    }
}

// Handle file uploads separately via AJAX
public function uploadPhoto(): void
{
    $uploader = new Uploader();
    $uploadedFiles = $uploader->handleFileUploads('user_photos/');

    if (!empty($uploadedFiles)) {
        // Assuming `handleFileUploads` returns an array with 'path' keys
        $photoUrl = $uploadedFiles[0]['path'];

        // Ensure photo URL is formatted correctly
        $fullPhotoUrl = \Crmlva\Exposy\Util::getUserPhotoUrl($photoUrl);

        $this->sendJsonResponse(true, [
            'message' => 'Photo uploaded successfully!',
            'photoUrl' => $fullPhotoUrl
        ], 200);
    } else {
        $this->sendJsonResponse(false, [
            'errors' => 'Failed to upload photo. Please try again.'
        ], 422);
    }
}

public function handleProfileUpdate(int $userId): void
{
    $data = $this->getData();

    $uploader = new Uploader();
    $uploadedFiles = $uploader->handleFileUploads('user_photos/');

    if (!empty($uploadedFiles)) {
        $data['photo'] = $uploadedFiles[0]['path'];
    }

    $validation = new Validation();
    $validation->validateStringField($data['firstname'] ?? '', 'firstname', 1, 255);
    $validation->validateStringField($data['lastname'] ?? '', 'lastname', 1, 255);
    $validation->validateStringField($data['city'] ?? '', 'city', 1, 255);
    $validation->validateCountry($data['country'] ?? '');
    $validation->validateGender($data['gender'] ?? '');
    $validation->validateStringField($data['alt_text'] ?? '', 'alt_text', 1, 255);

    if ($validation->getErrors()) {
        $this->sendJsonResponse(false, $validation->getErrors(), 422);
    } else {
        $profileModel = new UserProfile();
        $profileModel->updateProfile($userId, $data);

        $this->sendJsonResponse(true, ['message' => 'Profile updated successfully!', 'photo' => $data['photo'] ?? ''], 200);
    }
}

private function sendJsonResponse(bool $success, array $data, int $statusCode): void
{
    header('Content-Type: application/json');
    echo json_encode(['success' => $success] + $data);
    http_response_code($statusCode);
    exit();
}

}
