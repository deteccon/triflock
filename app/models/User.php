<?php
class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($name, $email, $password, $token, $expiry)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name,email,password,verification_code, verification_expiry) VALUES (?,?,?,?,?)");
        return $stmt->execute([$name, $email, $password, $token, $expiry]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns user or false
    }

    public function deleteByEmail($email)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE email=?");
        return $stmt->execute([$email]);
    }

    public function verify($token)
    {
        $stmt = $this->pdo->prepare("SELECT id, verified FROM users WHERE verification_code=? AND verification_expiry > NOW()");
        $stmt->execute([$token]);

        $user = $stmt->fetch();

        if (!$user) {
            $stmt2 = $this->pdo->prepare("SELECT id, verified FROM users WHERE verification_code IS NULL AND verified = 1");
            $stmt2->execute();
            $user2 = $stmt2->fetch();

            if ($user2) {
                return 'already_verified';
            }

            return 'invalid';
        }

        if ($user['verified']) {
            return 'already_verified';
        }

        $update = $this->pdo->prepare("UPDATE users SET verified = 1, verification_code = NULL, verification_expiry = NULL WHERE id = ?");
        $update->execute([$user['id']]);

        return 'success';
    }
}
