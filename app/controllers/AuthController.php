<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';

class AuthController
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new User($pdo);
    }

    public function register($name, $email, $password)
    {
        if ($this->userModel->findByEmail($email)) {
            return ['success' => false, 'message' => 'Email already registered'];
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $verificationCode = bin2hex(random_bytes(16));

        if ($this->userModel->create($name, $email, $passwordHash, $verificationCode)) {
            // $verify_link = BASE_URL . "/verify.php?code=$verificationCode&email=$email";
            // $subject = "Verify your Trilock account to activate";

            // TODO: Left to add mail sending logic

            return ['success' => true, 'message' => 'User registered successfully. Please check your mail for verification'];
        }

        return ['success' => false, 'message' => 'Registration failed'];
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }

        if (!password_verify($password, $user['password'])) {
            return ['success' => false, 'message' => 'Invalid credentials'];
        }

        // TODO: Left to add mail sending logic
        // if (!$user['verified']) {
        //     return ['success' => false, 'message' => 'Please verify your email first.'];
        // }

        session_start();
        $_SESSION['uId'] = $user['id'];
        $_SESSION['uName'] = $user['name'];

        return ['success' => true, 'message' => 'Login successful'];
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public function verifyEmail($email, $code)
    {
        if ($this->userModel->verify($email, $code)) {
            return ['success' => true, 'message' => 'Verified successfully'];
        }

        return ['success' => false, 'message' => 'Invalid verification link'];
    }
}
