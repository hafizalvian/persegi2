<?php
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isLoggedIn() {
    return isset($_SESSION['admin']);
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: ../login.php");
        exit();
    }
}