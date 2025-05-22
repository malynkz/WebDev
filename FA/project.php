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
		html, body {
            height: 100%;
            margin: 0;
        }
		
		body {
            background-image: url('bg.jpg');
            background-size: cover; /* Adjusts image to cover the entire background */
            background-repeat: no-repeat;
            background-position: center;
			background-color: transparent;
        }
		
		.animated-bg {
		position: fixed;
		bottom: 35%;
		left: 22%;
		width: 100px;
		height: 100px;
		z-index: 0;
		pointer-events: none;
		}
		.animated-bg img {
		width: 100%;
		height: auto;
		display: block;
		}

		@keyframes slide-left {
		0% {
		left: 100%;
		}
		100% {
		left: -120px;
		}
		}
	</style>
</head>

<body>
	<div id ="character" class="animated-bg">
		<img src="catt.png" alt="Decorazione" />
	</div>
	
	<script>
		let lastTime = performance.now();
		let lastLeft = 0;
		const character = document.getElementById('character');
		const position = character.getBoundingClientRect();

		function checkSpeed() {
			const currentLeft = position.left;

			const currentTime = performance.now(); // current time in milliseconds
			const timeElapsed = (currentTime - lastTime) / 1000; // in seconds
			const distanceMoved = currentLeft - lastLeft;

			const speed = distanceMoved / timeElapsed; // pixels per second

			// update for next check
			lastTime = currentTime;
			lastLeft = currentLeft;
		}

		// call checkSpeed every 100ms
		setInterval(checkSpeed, 100);
	
		function jump() {
	 
	</script>
</body>
</html>