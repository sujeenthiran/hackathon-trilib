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
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Vérification de l'authentification : requête préparée (anti-injection SQL)
// puis vérification du mot de passe haché avec password_verify()
$stmt = $connexion->prepare("SELECT nom, prenom, mot_de_passe FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row && password_verify($password, $row['mot_de_passe'])) {
    // Vous êtes connecté avec succès !
    $nom_utilisateur = $row['nom']; // Remplacez 'nom' par le nom de la colonne dans la base de données
    $prenom_utilisateur = $row['prenom']; // Remplacez 'prenom' par le nom de la colonne dans la base de données

    // Démarrez la session et changez son identifiant (anti fixation de session)
    session_start();
    session_regenerate_id(true);

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
