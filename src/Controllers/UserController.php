<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Models\UserProfile;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Validators\Validation;
use Crmlva\Exposy\Uploader;

class UserController extends Controller
{
    public function profile(): void {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        $userModel = new User();
        $user = $userModel->getById($userId);

        $profileModel = new UserProfile();
        $profile = $profileModel->getProfileByUserId($userId);

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
                'title' => 'Account',
                'errors' => $_SESSION['errors'] ?? [],
                'success' => $_SESSION['success'] ?? ''
            ]);

            // Clear session errors and success message after rendering them
            unset($_SESSION['errors'], $_SESSION['success']);
        }
    }

    public function handleProfileUpdate(int $userId): void {
        $data = $this->getData();
    
        // Handle file upload
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
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
            http_response_code(422);
            exit();
        } else {
            $profileModel = new UserProfile();
            $profileModel->updateProfile($userId, $data);
    
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'photo' => $data['photo'] ?? ''
            ]);
            http_response_code(200);
            exit();
        }
    }
}
