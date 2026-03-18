<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['photo'] = $user['photo'];

                $this->redirectByRole($user['role']);
            } else {
                $this->render('auth/login', ['error' => 'Invalid username or password']);
            }
        } else {
            if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
                // Already logged in, redirect based on role
                $this->redirectByRole($_SESSION['role']);
            }
            $this->render('auth/login');
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('/login');
    }

    private function redirectByRole($role) {
        switch ($role) {
            case 'Admin':
                $this->redirect('/admin/dashboard');
                break;
            case 'Student':
                $this->redirect('/student/dashboard');
                break;
            case 'Consultant':
            case 'Lecturer':
            case 'Tutor':
                $this->redirect('/consultant/dashboard');
                break;
            default:
                // If role is unknown, just stay on login or logout
                if (isset($_SESSION['user_id'])) {
                    session_destroy();
                }
                $this->render('auth/login', ['error' => 'Unauthorized role.']);
                exit();
        }
    }
}
