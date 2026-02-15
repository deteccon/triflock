<?php
session_start();

if (isset($_SESSION['uId'])) {
    header("Location: dashboard.php");
    exit;
}

require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController($pdo);

if (isset($_SESSION['error'])) {
    echo "<p style='color: red'>" . $_SESSION['error'] . "</p>";
    unset($_SESSION['error']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $auth->register($name, $email, $password);

    if ($result['success']) {
        $_SESSION['success'] = $result['message'];
        header("Location: login.php");
        exit;
        echo $result['message'];
    } else {
        $_SESSION['error'] = $result['message'];
        header("Location: register.php");
        exit;
    }
}
?>

<form method="post">
    <input type="text" name="name" id="name" placeholder="Enter your name" required>
    <input type="email" name="email" id="email" placeholder="Enter your mail" required>
    <input type="password" name="password" id="password" placeholder="********" required>
    <button type="submit">Register</button>
</form>