<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($name, $email, $password, $verification_code)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name,email,password,verification_code) VALUES (?,?,?,?)");
        return $stmt->execute([$name, $email, $password, $verification_code]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        return $stmt->execute([$email]);
    }

    // User verification ko lagi from mailer ( Verification check must already have been done )
    public function verify($email, $code)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET verified=1 WHERE email=? AND verification_code=?");
        return $stmt->execute([$email, $code]);
    }
}
