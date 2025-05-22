<?php
session_start();
include 'config.php';
$errore = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errore = "Tutti i campi sono obbligatori.";
    } else if (isset($_POST['login'])) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed);
            $stmt->fetch();
            if (password_verify($password, $hashed)) {
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
    } elseif (isset($_POST['register'])) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errore = "Nome utente già registrato.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt2->bind_param("ss", $username, $hashed);
            if ($stmt2->execute()) {
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
    <title>Flushed Away - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
		body {
            background: url('bg.jpg') no-repeat center center fixed;
			background-size: cover;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #fff;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 2rem 3rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin: 1rem 0 0.5rem;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            width: 48%;
            padding: 0.6rem;
            margin-top: 1rem;
            font-size: 1rem;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[name="register"] {
            background-color: #2196F3;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        .error {
            background-color: #ff4d4d;
            padding: 0.8rem;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 1rem;
            color: #fff;
        }
		.animated-bg {
			position: fixed;
			bottom: 40%;
			left: 100%;
			width: 100px;
			height: 100px;
			z-index: 0; /* dietro alla form */
			pointer-events: none;
			animation: slide-left 15s linear infinite;
		}
		.animated-bg img {
			width: 100%;
			height: auto;
			display: block;
		}

		/* Animazione */
		@keyframes slide-left {
			0% {
				left: 100%;
			}
			100% {
				left: -120px;
			}
		}

		/* Assicurati che il container sia davanti */
		.container {
			position: relative;
			z-index: 1;
		}

    </style>
</head>
<body>
    <div class="container">
        <h2>FlushedAway</h2>
        <?php if ($errore): ?>
            <div class="error"><?= htmlspecialchars($errore) ?></div>
        <?php endif; ?>
        <form method="post" autocomplete="off">
            <label for="username">Nome utente</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <div class="buttons">
                <button type="submit" name="login">Login</button>
                <button type="submit" name="register">Registrati</button>
            </div>
        </form>
    </div>
	<div class="animated-bg">
		<img src="cat.png" alt="Decorazione" />
	</div>
</body>
</html>
