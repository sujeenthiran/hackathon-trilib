<?php
// main.php
session_start();

if (!isset($_SESSION['nom_utilisateur'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: /hackathon/login/login.html");
    exit();
}

$nom_utilisateur = $_SESSION['nom_utilisateur'];
$prenom_utilisateur = $_SESSION['prenom_utilisateur'];
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
    exit;
}

// Reste du code pour la gestion des photos...


// Chemin générique pour le répertoire de stockage des images
$uploadDirectory = 'images/';

// Vérifier si le répertoire de destination existe, sinon le créer
if (!file_exists($uploadDirectory)) {
    if (!mkdir($uploadDirectory, 0755, true)) {
        // Échec de la création du répertoire
        http_response_code(500);
        echo 'Erreur lors de la création du répertoire de stockage des images.';
        exit;
    }
}

// Vérifier si un fichier photo a été envoyé
if (isset($_FILES['photo']) && strpos($_FILES['photo']['type'], 'image/') === 0) {
    // Récupérer l'ID de l'utilisateur (à adapter à votre logique d'authentification)
    $nom_utilisateur = $_SESSION['nom_utilisateur'];
$prenom_utilisateur = $_SESSION['prenom_utilisateur'];

// Utiliser le nom et le prénom pour obtenir l'ID de l'utilisateur depuis la base de données
$sqlUserId = "SELECT id FROM users WHERE nom = :nom_utilisateur AND prenom = :prenom_utilisateur";
$stmtUserId = $bdd->prepare($sqlUserId);
$stmtUserId->bindParam(':nom_utilisateur', $nom_utilisateur);
$stmtUserId->bindParam(':prenom_utilisateur', $prenom_utilisateur);
$stmtUserId->execute();

if ($stmtUserId->rowCount() > 0) {
    $row = $stmtUserId->fetch(PDO::FETCH_ASSOC);
    $userId = $row['id'];

    // Le reste de votre code pour la gestion des images en utilisant $userId...
} else {
    // Utilisateur non trouvé dans la base de données
    http_response_code(404);
    echo 'Utilisateur non trouvé.';
}

    // Récupérer le nombre de photos prises par cet utilisateur depuis la table photo_count
    $sql = "SELECT photo_count FROM photo_count WHERE user_id = :user_id";
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // L'utilisateur existe dans la table photo_count, incrémenter le compteur
        $photoCount = $result['photo_count'] + 1;
        $sql = "UPDATE photo_count SET photo_count = :photo_count WHERE user_id = :user_id";
    } else {
        // L'utilisateur n'existe pas dans la table photo_count, insérer une nouvelle entrée
        $photoCount = 1;
        $sql = "INSERT INTO photo_count (user_id, photo_count) VALUES (:user_id, :photo_count)";
    }

    // Exécuter la requête pour mettre à jour ou insérer le compteur
    $stmt = $bdd->prepare($sql);
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':photo_count', $photoCount);
    $stmt->execute();

    // Récupérer l'extension du fichier
    $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

   // Construire le nom du fichier (prenom_nom_numerodephoto.extension)
    $photoName = $prenom_utilisateur . '_' . $nom_utilisateur . '_' . $photoCount . '.' . $extension;


    // Définir le chemin complet de destination
    $destination = $uploadDirectory . $photoName;

    // Déplacer le fichier téléchargé vers le répertoire de destination
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
        // Réponse de réussite
        http_response_code(200);
        echo 'Photo enregistrée avec succès.';
    } else {
        // Erreur lors du déplacement du fichier
        http_response_code(500);
        echo 'Erreur lors de l\'enregistrement de la photo.';
    }
} else {
    // Aucun fichier photo reçu ou fichier invalide
    http_response_code(400);
    echo 'Aucune photo reçue ou fichier invalide.';
}
?>
