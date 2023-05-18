<?php
session_start();

if (isset($_SESSION['user_info'])) {
    unset($_SESSION['user_info']);
}

if (isset($_SESSION['cart'])) {
    unset($_SESSION['cart']);
}

header("Location: index.php");
?>