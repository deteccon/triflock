<?php
    $servername = "localhost";
    $user = "triflock";
    $pass = "triflock@#$196T";
    $db = "triflock";

    $conn = new mysqli($servername, $user, $pass, $db);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "Connected Successfully";
    $conn->close();
?>