<?php
// logout.php
session_start();

// Détruire la session et rediriger vers la page de connexion
session_destroy();

header("Location: /hackathon/login/login.html");
exit();
?>
