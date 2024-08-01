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
                'firstname' => $profile['firstname'] ?? '',
                'lastname' => $profile['lastname'] ?? '',
                'gender' => $profile['gender'] ?? '',
                'city' => $profile['city'] ?? '',
                'country' => $profile['country'] ?? '',
                'photo' => $profile['photo'] ?? 'assets/icons/User photo.svg',
                'title' => 'Account',
                'errors' => $_SESSION['errors'] ?? [],
                'success' => $_SESSION['success'] ?? ''
            ]);
    
            unset($_SESSION['errors'], $_SESSION['success']);
        }
    }
    

    private function handleProfileUpdate(int $userId): void {
        $data = $this->getData();
    
        // Handle the file upload
        $uploader = new \Crmlva\Exposy\Uploader();
        $uploadedFiles = $uploader->handleFileUploads('user_photos/');
    
        if (!empty($uploadedFiles)) {
            // Save the photo path in the data
            $data['photo'] = $uploadedFiles[0]['path'];
        }
    
        $validation = new Validation();
        $validation->validateStringField($data['firstname'] ?? '', 'firstname', 1, 255);
        $validation->validateStringField($data['lastname'] ?? '', 'lastname', 1, 255);
        $validation->validateStringField($data['city'] ?? '', 'city', 1, 255);
        $validation->validateCountry($data['country'] ?? '');
        $validation->validateGender($data['gender'] ?? '');
    
        if ($validation->getErrors()) {
            $_SESSION['errors'] = $validation->getErrors();
            $this->redirect('/account');
        } else {
            $profileModel = new UserProfile();
            $profileModel->updateProfile($userId, $data);
    
            $_SESSION['success'] = 'Profile updated successfully!';
            $this->redirect('/account');
        }
    }
}
