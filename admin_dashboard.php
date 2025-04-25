<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

echo "Welkom, admin! Hier zijn je beheermogelijkheden.";
?>
