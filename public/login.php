<?php
session_start();

if (isset($_SESSION['uId'])) {
    header("Location: dashboard.php");
    exit;
}

require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController($pdo);

if (isset($_SESSION['success'])) {
    echo "<p style='color: green'>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo "<p style='color: red'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $auth->login($email, $password);

    if ($result['success']) {
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: login.php");
    }
}
?>

<form method="post">
    <input type="email" name="email" id="email" placeholder="Enter your mail" required>
    <input type="password" name="password" id="password" placeholder="********" required>
    <button type="submit">Login</button>
</form>