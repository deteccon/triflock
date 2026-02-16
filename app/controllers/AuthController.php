<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../core/Mailer.php';

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
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime("+24 hours"));

        if ($this->userModel->create($name, $email, $passwordHash, $token, $expiry)) {
            $verify_link = BASE_URL . "/verify.php?token=$token";

            $mailsent = Mailer::sendVerificationMail($email, $name, $verify_link);

            if (!$mailsent) {
                $this->userModel->deleteByEmail($email);

                return ['success' => false, 'message' => 'Registration failed. Could not sent verification mail.'];
            }

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

        if (!$user['verified']) {
            return ['success' => false, 'message' => 'Please verify your email first.'];
        }

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

    public function verifyEmail($token)
    {
        $result = $this->userModel->verify($token);

        if ($result === 'success') {
            return ['success' => true, 'message' => 'Email verified successfully'];
        }

        if ($result === 'already_verified') {
            return ['success' => false, 'message' => 'Email already verified'];
        }

        return ['success' => false, 'message' => 'Invalid verification link'];
    }
}
