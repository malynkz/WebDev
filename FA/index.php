<?php
session_start();
// Importa la configurazione del database
include 'config.php';

// Inizializza una variabile per eventuali messaggi di errore
$errore = "";

// Se il form è stato inviato (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Legge i dati dal form
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    // Se è stato cliccato "Login"
    if (isset($_POST['login'])) {
        // Prepara la query per trovare l'utente tramite username
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        // Se esiste un utente con quel nome, verifica la password
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed);
            $stmt->fetch();
            if (password_verify($password, $hashed)) {
                // Login riuscito: salva dati in sessione e reindirizza al gioco
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: project.php");
                exit();
            } else {
                $errore = "Password errata.";
            }
        } else {
            $errore = "Utente non trovato.";
        }
        $stmt->close();
    }
    // Se è stato cliccato "Registrati"
    elseif (isset($_POST['register'])) {
        // Controlla se esiste già un utente con lo stesso username
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errore = "Nome utente già registrato.";
        } else {
            // Crea la password hashata
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            // Inserisce nuovo utente
            $stmt2 = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt2->bind_param("ss", $username, $hashed);
            if ($stmt2->execute()) {
                // Registrazione riuscita: salva dati in sessione e vai al gioco
                $_SESSION['user_id'] = $stmt2->insert_id;
                $_SESSION['username'] = $username;
                header("Location: project.php");
                exit();
            } else {
                $errore = "Errore registrazione.";
            }
            $stmt2->close();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Flushed Away Login</title>
</head>
<body>
    <h2>FlushedAway - Login / Registrazione</h2>
    <!-- Mostra eventuali errori -->
    <?php if ($errore): ?><p style="color:red;"><?= htmlspecialchars($errore) ?></p><?php endif; ?>
    <!-- Form di login/registrazione -->
    <form method="post">
        <label>Nome utente: <input type="text" name="username" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit" name="login">Login</button>
        <button type="submit" name="register">Registrati</button>
    </form>
	<style>
		body {
            background-image: url('login_bg.png');
            background-size: cover; /* Adjusts image to cover the entire background */
            background-repeat: no-repeat;
            background-position: center;
        }
		.floating-object {
            position: absolute;
            top: 100px;
            left: -200px; /* start off-screen */
            width: 100px;
            height: 100px;
            background-color: red;
            animation: floatRight 10s linear infinite;
        }

        @keyframes floatRight {
            0% {
                left: -200px;
            }
            100% {
                left: 100%;
            }
        }
    </style>
</body>
	<img src="shit.png" class="floating-object" />
</body>
</html>