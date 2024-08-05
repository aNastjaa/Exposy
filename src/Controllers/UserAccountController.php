<?php

namespace Crmlva\Exposy\Controllers;

use Crmlva\Exposy\Controller;
use Crmlva\Exposy\Models\User;
use Crmlva\Exposy\Models\UserProfile;
use Crmlva\Exposy\Session;
use Crmlva\Exposy\Validators\Validation;
use Crmlva\Exposy\Util;
use Crmlva\Exposy\Database;

class UserAccountController extends Controller
{
    public function updateAccount(): void
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $data = $this->getData();

            $validation = new Validation();
            $validation->validateStringField($data['username'] ?? '', 'username', 3, 255);
            $validation->validateEmail($data['email'] ?? '');

            if ($validation->getErrors()) {
                $this->sendJsonResponse(false, $validation->getErrors(), 422);
            } else {
                $userModel = new User();

                if ($userModel->getByUsername($data['username']) && $data['username'] !== Session::get('username')) {
                    $validation->addError('username', 'Username already exists');
                }

                if ($userModel->getByEmail($data['email']) && $data['email'] !== Session::get('email')) {
                    $validation->addError('email', 'Email already exists');
                }

                if ($validation->getErrors()) {
                    $this->sendJsonResponse(false, $validation->getErrors(), 422);
                } else {
                    $userModel->updateUserProfile($userId, $data['username'], $data['email']);
                    Session::set('username', $data['username']);
                    Session::set('email', $data['email']);
                    $this->sendJsonResponse(true, ['message' => 'Profile updated successfully!'], 200);
                }
            }
        }
    }

    public function updatePassword(): void
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $data = $this->getData();

            $validation = new Validation();
            $validation->validatePassword($data['new-password'] ?? '');

            if ($validation->getErrors()) {
                $this->sendJsonResponse(false, $validation->getErrors(), 422);
                return;
            }

            $userModel = new User();
            $user = $userModel->getById($userId);

            if (!$user || !isset($data['password']) || !Util::verifyPassword($data['password'], $user['password'])) {
                $validation->addError('password', 'Old password is incorrect');
            }

            if ($validation->getErrors()) {
                $this->sendJsonResponse(false, $validation->getErrors(), 422);
            } else {
                $hashedPassword = Util::hashPassword($data['new-password']);
                $userModel->updateUserPassword($userId, $hashedPassword);
                $this->sendJsonResponse(true, ['message' => 'Password updated successfully!'], 200);
            }
        }
    }

    public function deleteAccount(): void
    {
        $userId = Session::get('user_id');
        if (!$userId) {
            $this->redirect('/login');
            return;
        }

        if ($this->isRequestMethod(self::REQUEST_METHOD_POST)) {
            $userModel = new User();
            $db = Database::getInstance(); // Get the singleton instance

            // Start a transaction to ensure data integrity
            $db->beginTransaction();

            try {
                // Delete user profile (if applicable)
                $userProfileModel = new UserProfile();
                $userProfileModel->deleteProfile($userId);

                // Delete the user account
                $userModel->deleteUser($userId);

                // Commit the transaction
                $db->commit();

                // End the session and redirect to login
                Session::clearAll();
                $this->sendJsonResponse(true, ['message' => 'Account deleted successfully!'], 200);
            } catch (\Exception $e) {
                // Rollback the transaction if something goes wrong
                $db->rollBack();
                $this->sendJsonResponse(false, ['message' => 'Failed to delete account.'], 500);
            }
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
