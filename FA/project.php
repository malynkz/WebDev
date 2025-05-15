<?php
session_start();
// Importa la configurazione del database
include 'config.php';

// Controlla se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Recupera il record personale dal database per l'utente corrente
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT highscore FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($highscore);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Acchiappa la Talpa - Gioca</title>
	
	<style>
		body {
            background-image: url('bg.jpg');
            background-size: cover; /* Adjusts image to cover the entire background */
            background-repeat: no-repeat;
            background-position: center;
        }
	</style>
</head>

<body>
</body>
</html>