<?php
session_start();
include "footer.php";
// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verwerken van het formulier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // SQL query om de gebruiker op te halen
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $username, $hashed_password, $role);

    // Als de gebruiker bestaat, verifieer het wachtwoord
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        
        // Vergelijk het ingevoerde wachtwoord met het gehashte wachtwoord
        if (password_verify($input_password, $hashed_password)) {
            // Sla de gebruikersgegevens op in de sessie
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Redirect naar het dashboard op basis van de rol
            if ($role === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            echo "Incorrect wachtwoord!";
        }
    } else {
        echo "Gebruiker niet gevonden!";
    }

    $stmt->close();
}

$conn->close();
?>
