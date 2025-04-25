<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gebruiker') {
    header("Location: login.php");
    exit();
}

echo "Welkom, gebruiker! Hier kun je je bestellingen beheren.";
?>
