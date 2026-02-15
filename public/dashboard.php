<?php
session_start();

if (!isset($_SESSION['uId'])) {
    $_SESSION['error'] = "You must login to access";
    header("Location: login.php");
    exit;
}

?>

<h2>Welcome, <?php echo $_SESSION['uName']; ?> 👋</h2>

<form action="./logout.php" method="post">
    <button type="submit">Logout</button>
</form>