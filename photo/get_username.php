<?php
// main.php
session_start();

if (!isset($_SESSION['nom_utilisateur'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: /hackathon/login/login.html");
    exit();
}
?>
<?php
// Informations de connexion à la base de données
$serveur = "localhost";
$nom_utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "hackathon";

try {
    // Connexion à la base de données avec PDO
    $bdd = new PDO("mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8", $nom_utilisateur, $mot_de_passe);

    // Préparez et exécutez la requête SQL pour obtenir le nom d'utilisateur
    $query = "SELECT user FROM user";
    $result = $bdd->query($query);

    // Récupérez la première ligne du résultat (vous pouvez adapter cela si vous avez plusieurs utilisateurs)
    $row = $result->fetch(PDO::FETCH_ASSOC);

    // Renvoyez le nom d'utilisateur en tant que réponse JSON
    if ($row) {
        $response = array('username' => $row['user']);
        echo json_encode($response);
    } else {
        echo 'Aucun utilisateur trouvé.';
    }

    // Fermez la connexion à la base de données
    $bdd = null;
} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
}
?>
