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
            background-size: cover; /*Coprire tutto lo sfondo*/
            background-repeat: repeat-x; /*per lo scorrimento dell'immagine*/
            background-position: center;
			background-color: transparent;
			position: relative;
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
		.character img {
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
	<div id ="character" class="character">
		<img src="catt.png" alt="Decorazione" />
	</div>
	
	<script>
    const character = document.getElementById('character');
    let vSpeed = 0;
    let gravity = 500; 
    let lastTime = performance.now();
    let posY = 300; //altezza iniziale
    let isJumping = false;

    function jump() {
      const currentTime = performance.now();
      const deltaTime = (currentTime - lastTime) / 1000;
      lastTime = currentTime;

      //gravità (la gravità c'è SEMPRE, metti solo un pavimento che te la blocca
      vSpeed += gravity * deltaTime;
      posY += vSpeed * deltaTime;

      // Floor collision
      const floor = window.innerHeight - 50;
      if (posY > floor) {
        posY = floor;
        vSpeed = 0;
        isJumping = false;
      }

      character.style.top = posY + 'px';

      requestAnimationFrame(update);
    }

    document.addEventListener('keydown', (event) => {
      if (event.key === 'ArrowUp' && !isJumping) {
        verticalSpeed = -400; //funzione salta upon click
        isJumping = true;
      }
    });

    jump(); //riinizia il loop
	
	
	
  </script>
</body>
</html>