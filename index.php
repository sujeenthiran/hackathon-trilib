<?php
// Démarrer la session
session_start();

if (isset($_SESSION['nom_utilisateur'])) {
    // Récupérer le nom et prénom de l'utilisateur depuis la session
    $nom_utilisateur = $_SESSION['nom_utilisateur'];
    $prenom_utilisateur = $_SESSION['prenom_utilisateur'];
} else {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header("Location: /hackathon/login/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <style>
        #map {
            padding: 20%;
            height: 120%;
            zoom:250%;
            
        }
    </style>
</head>
<?php require_once('../hackathon/header.php'); ?>
<body>
    

    <div class="container">
        <div class="map" id="map"></div>
       
    </div>

    <footer>
        <p>&copy; ʜᴀᴄᴋᴀᴛᴏɴ</p>
    </footer>

    <script>
        var map = L.map('map').setView([48.8566, 2.3522], 12); // Coordonnées de Paris

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Chargez les coordonnées à partir du fichier JSON
        fetch('coordinates.json')
    .then(response => response.json())
    .then(coordinates => {
        coordinates.forEach(coord => {
            var marker = L.marker([coord.lat, coord.lon]).addTo(map);

            // Créez le contenu HTML de la popup avec le nom de l'utilisateur et l'image
            var popupContent = `
                <b>Adresse:</b> ${coord.adresse}<br/>
                <b>Utilisateur:</b> ${coord.user}<br/>
                <img src="${coord.image}" alt="Image de l'utilisateur" width="200"/>
            `;

            // Associez le contenu HTML à la popup du marqueur
            marker.bindPopup(popupContent);

            // Ajoutez un événement de clic pour ouvrir la popup
            marker.on('click', function () {
                marker.openPopup();
            });
        });
    })
    .catch(error => {
        console.error(error);
    });
    </script>
</body>

</html>
