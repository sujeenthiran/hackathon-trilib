<?php
session_start();
if (!isset($_SESSION['nom_utilisateur'])) {
    header("Location: /hackathon/login/login.html");
    exit();
}

$servername = "localhost";
$username = "root"; // Remplacez par votre nom d'utilisateur MySQL
$password = ""; // Remplacez par votre mot de passe MySQL
$dbname = "hackathon"; // Remplacez par le nom de votre base de données

// Créez une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Vérifiez si les données ont été envoyées via le formulaire
if(isset($_POST['nom']) && isset($_POST['lieu']) && isset($_POST['date'])) {
    // Récupérez les données du formulaire
    $nom = $_POST['nom'];
    $lieu = $_POST['lieu'];
    $date = $_POST['date'];

    // Préparez et exécutez la requête SQL pour ajouter l'événement
    $stmt = $conn->prepare("INSERT INTO events (nom, lieu, date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nom, $lieu, $date);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirige vers la page principale après l'ajout
        exit();
    } else {
        echo "Erreur lors de l'ajout de l'événement.";
    }
} else {
    echo "Veuillez remplir tous les champs du formulaire.";
}

// Fermez la connexion à la base de données
$conn->close();
?>
