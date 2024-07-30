<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Models\UserProfile;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Validators\Validation;

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

        // Fetch user profile
        $profileModel = new UserProfile();
        $profile = $profileModel->getProfileByUserId($userId);

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $this->handleProfileUpdate($userId);
        } else {
            // Render the profile page with current user data and profile information
            $this->renderView('account', [
                'username' => $user['username'],
                'firstname' => $profile['firstname'] ?? '',
                'lastname' => $profile['lastname'] ?? '',
                'gender' => $profile['gender'] ?? '',
                'city' => $profile['city'] ?? '',
                'country' => $profile['country'] ?? '',
                'title' => 'Account',
                'errors' => $_SESSION['errors'] ?? [],
                'success' => $_SESSION['success'] ?? ''
            ]);
            // Clear messages after rendering
            unset($_SESSION['errors'], $_SESSION['success']);
        }
    }


    private function handleProfileUpdate(int $userId): void
    {
        // Fetch POST data
        $data = $this->getData();

        // Validate and update profile data
        $validation = new Validation();
        $validation->validateStringField($data['firstname'] ?? '', 'firstname', 1, 255);
        $validation->validateStringField($data['lastname'] ?? '', 'lastname', 1, 255);
        $validation->validateStringField($data['city'] ?? '', 'city', 1, 255);
        $validation->validateCountry($data['country'] ?? '');
        $validation->validateGender($data['gender'] ?? '');

        // Log validation errors
        error_log("Validation errors: " . print_r($validation->getErrors(), true));

        if ($validation->getErrors()) {
            // If validation fails, redirect back with errors
            $_SESSION['errors'] = $validation->getErrors();
            $this->redirect('/account');
        } else {
            $profileModel = new UserProfile();
            $profileModel->updateProfile($userId, $data);

            // Set a success message in the session
            $_SESSION['success'] = 'Profile updated successfully!';
            $this->redirect('/account');
        }
    }
}
