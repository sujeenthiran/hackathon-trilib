<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hackathon";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

$sql = "SELECT nom, lieu, date FROM events";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // htmlspecialchars : empêche l'injection de code HTML/JS (XSS)
        echo "<li><strong>" . htmlspecialchars($row["nom"]) . "</strong> - Lieu: " . htmlspecialchars($row["lieu"]) . ", Date: " . htmlspecialchars($row["date"]) . "</li>";
    }
} else {
    echo "Aucun événement trouvé.";
}

$conn->close();
?>
