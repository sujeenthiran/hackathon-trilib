<?php
// Connexion à la base de données
$serveur = "localhost";
$nom_utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "hackathon";

$connexion = new mysqli($serveur, $nom_utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

// Récupération des données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

// Vérification de l'authentification
$sql = "SELECT * FROM users WHERE email='$email' AND mot_de_passe='$password'";
$resultat = $connexion->query($sql);

if ($resultat->num_rows > 0) {
    // Vous êtes connecté avec succès !
    
    // Redirigez l'utilisateur vers la page "main.php"
    header("Location: ./main.php");
    exit(); // Assurez-vous d'utiliser exit() pour arrêter l'exécution du script ici
} else {
    echo "Échec de la connexion. Veuillez vérifier vos informations de connexion.";
}


$connexion->close();
?>