<?php
// Connexion à la base de données (même code que dans votre fichier de connexion)
$serveur = "localhost";
$nom_utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "hackathon";

$connexion = new mysqli($serveur, $nom_utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

// Récupération des données du formulaire d'inscription
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$password = $_POST['password'];

// Vérification de l'unicité de l'email (pour éviter les doublons)
$verification_sql = "SELECT * FROM utilisateurs WHERE email='$email'";
$verification_resultat = $connexion->query($verification_sql);

if ($verification_resultat->num_rows > 0) {
    echo "L'email est déjà utilisé. Veuillez choisir un autre email.";
} else {
    // Insertion des données dans la base de données
    $insertion_sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES ('$nom', '$prenom', '$email', '$password')";

    if ($connexion->query($insertion_sql) === TRUE) {
        echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    } else {
        echo "Erreur lors de l'inscription : " . $connexion->error;
    }
}

$connexion->close();
?>
