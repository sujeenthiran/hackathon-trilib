<?php


// Vérifier si l'utilisateur est connecté (a une session active)
if (isset($_SESSION['nom_utilisateur']) && isset($_SESSION['prenom_utilisateur'])) {
    // Récupérer le nom et le prénom de l'utilisateur depuis les variables de session
    $nom_utilisateur = $_SESSION['nom_utilisateur'];
    $prenom_utilisateur = $_SESSION['prenom_utilisateur'];
} else {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: /hackathon/login/login.html");
    exit();
}

// Connexion à la base de données (à adapter avec vos informations)
$serveur = "localhost";
$nom_bdd = "root";
$mot_de_passe = "";
$base_de_donnees = "hackathon";

try {
    $bdd = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $nom_bdd, $mot_de_passe);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}

// Récupérer l'ID de l'utilisateur à partir de la table user en utilisant son nom et prénom
$sql_user = "SELECT id FROM users WHERE nom = :nom_utilisateur AND prenom = :prenom_utilisateur";
$stmt_user = $bdd->prepare($sql_user);
$stmt_user->bindParam(':nom_utilisateur', $nom_utilisateur);
$stmt_user->bindParam(':prenom_utilisateur', $prenom_utilisateur);
$stmt_user->execute();
$result_user = $stmt_user->fetch(PDO::FETCH_ASSOC);

if ($result_user) {
    $user_id = $result_user['id'];

    // Récupérer le photo_count de l'utilisateur depuis la table photo_count en utilisant son ID
    $sql_photo_count = "SELECT photo_count FROM photo_count WHERE user_id = :user_id";
    $stmt_photo_count = $bdd->prepare($sql_photo_count);
    $stmt_photo_count->bindParam(':user_id', $user_id);
    $stmt_photo_count->execute();
    $result_photo_count = $stmt_photo_count->fetch(PDO::FETCH_ASSOC);

    if ($result_photo_count) {
        $photo_count = $result_photo_count['photo_count'];
    } else {
        $photo_count = 0;
    }

    // Afficher les images pour l'utilisateur
    echo "<h1>Galerie de Photos pour $nom_utilisateur $prenom_utilisateur (photo_count = $photo_count)</h1>";

    echo "<div class='photo-gallery'>";
    for ($i = 1; $i <= $photo_count; $i++) {
        $nom_fichier = "$prenom_utilisateur" . "_$nom_utilisateur" . "_$i.jpg";
        echo "<div class='photo-item'>";
        echo "<img src='/hackathon/photo/images/$nom_fichier' alt='Photo $i'>";
        echo "<p>Nom du fichier : $nom_fichier</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    // L'utilisateur n'a pas été trouvé dans la table user
    echo "Utilisateur non trouvé.";
}
?>
<style>
    /* Styles pour la galerie de photos */

h1 {
    text-align: center;
    font-size: 24px;
}

.photo-gallery {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.photo-item {
    margin: 10px;
    text-align: center;
}

.photo-item img {
    max-width: 100%;
    height: auto;
    border: 1px solid #ccc;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
}

.photo-item p {
    margin-top: 5px;
    font-size: 16px;
}

/* Animation au survol des images */
.photo-item img:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
}

</style>