<?php
// Distrugge la sessione e torna al login
session_start();
session_destroy();
header('Location: index.php');
exit();
?>