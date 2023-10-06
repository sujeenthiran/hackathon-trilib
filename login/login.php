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

    // Récupérez le nom et le prénom de l'utilisateur depuis la base de données
    $row = $resultat->fetch_assoc();
    $nom_utilisateur = $row['nom']; // Remplacez 'nom' par le nom de la colonne dans la base de données
    $prenom_utilisateur = $row['prenom']; // Remplacez 'prenom' par le nom de la colonne dans la base de données

    // Démarrez la session
    session_start();

    // Stockez le nom et le prénom de l'utilisateur dans des variables de session
    $_SESSION['nom_utilisateur'] = $nom_utilisateur;
    $_SESSION['prenom_utilisateur'] = $prenom_utilisateur;

    // Redirigez l'utilisateur vers la page "main.php"
    header("Location: /hackathon/");
    exit();
} else {
    echo "Échec de la connexion. Veuillez vérifier vos informations de connexion.";
}

$connexion->close();
?>
