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
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns user or false
    }

    // User verification ko lagi from mailer ( Verification check must already have been done )
    public function verify($email, $code)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET verified=1, verification_code = NULL WHERE email=? AND verification_code=? AND verified=0");
        $stmt->execute([$email, $code]);

        return $stmt->rowCount() > 0;
    }
}
