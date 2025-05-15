<?php
// File di configurazione della connessione al database

// Dati di accesso al database (modifica se necessario)
$host = "localhost";
$user = "root";
$pass = ""; // Su XAMPP di default la password è vuota
$dbname = "Flushed_Away";

// Crea la connessione al database MySQL
$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica se la connessione ha avuto successo, altrimenti mostra errore e termina
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>