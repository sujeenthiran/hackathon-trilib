<!-- index.html -->
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prendre une Photo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    
</head>

<body>
    
    <header>
    <div class="top-bar">
            <a href="/hackathon/index.php"><img src="/hackathon/paris.png" alt="Paris"></a>
            <a href="/hackathon/events/event.php"><button class="btn-event">Événements</button></a>
            <a href="/hackathon/photo/photo.php"><button class="btn-filter">photo</button></a>
            <!-- Afficher le nom et prénom de l'utilisateur -->
            <p>Bienvenue, <?php echo htmlspecialchars("$prenom_utilisateur $nom_utilisateur"); ?> !</p>
            <a href="/hackathon/logout/logout.php">Déconnexion</a>
            <input type="text" class="search-bar" placeholder="Rechercher...">
        </div>
    </header><h1>Prendre une Photo</h1>
    <!-- Afficher la vue de la caméra (avant le clic sur "Prendre Photo") -->
    <video id="camera-view" autoplay></video>

    <!-- Bouton pour prendre une photo avec la caméra -->
    <button id="capture-button">Prendre une Photo</button>
    <button id="show-photos-button">Afficher les Photos</button>
    <section id="photos-section">
        <h2>Vos Photos</h2>
       <?php require_once("gallery.php");  ?>
    </section>

    <script>
        const cameraView = document.getElementById('camera-view');
        const captureButton = document.getElementById('capture-button');
        let mediaStream = null;

        // Gestionnaire d'événements pour le bouton de capture
        captureButton.addEventListener('click', async function() {
            try {
                // Capturer une image depuis la caméra
                const canvas = document.createElement('canvas');
                canvas.width = cameraView.videoWidth;
                canvas.height = cameraView.videoHeight;
                canvas.getContext('2d').drawImage(cameraView, 0, 0, canvas.width, canvas.height);

                // Convertir l'image en format JPEG
                const photoBlob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg'));
                
                // Envoyer la photo vers le serveur (en utilisant FormData)
                const formData = new FormData();
                formData.append('photo', photoBlob, 'photo.jpg');

                const response = await fetch('upload.php', {
                    method: 'POST',
                    body: formData,
                });

                if (response.ok) {
                    console.log('Photo enregistrée avec succès.');
                } else {
                    console.error('Erreur lors de l\'envoi de la photo.');
                }
            } catch (error) {
                console.error('Erreur lors de la capture de la photo :', error);
            }
        });

        // Accès à la caméra
        async function startCamera() {
            try {
                // Accéder à la caméra
                mediaStream = await navigator.mediaDevices.getUserMedia({ video: true });
                cameraView.srcObject = mediaStream;
            } catch (error) {
                console.error('Erreur lors de l\'accès à la caméra :', error);
            }
        }

        // Démarrer la caméra lorsque la page est chargée
        window.addEventListener('load', () => {
            startCamera();
        });
        // JavaScript
        document.addEventListener('DOMContentLoaded', function () {
            const showPhotosButton = document.getElementById('show-photos-button');
            
            // Gestionnaire d'événements pour le bouton "Afficher les photos"
            showPhotosButton.addEventListener('click', function () {
                // Faites défiler vers la section contenant les photos
                const photosSection = document.getElementById('photos-section');
                photosSection.scrollIntoView({ behavior: 'smooth' });
            });
        });

    </script>
</body>
</html>
<style>
    body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #206fdd, #444444);
    color: #ffffff;
}

header, footer {
    background-color: #333;
    color: #fff;
    text-align: center;
}

header {
    padding: 20px 0;
    position: relative;
}

header h1 {
    font-size: 2em;
}

header .top-bar {
    display: flex;
    align-items: center;
    justify-content: space-between; /* Changement de l'alignement */
}

.top-bar .btn-event, .top-bar .btn-filter, .top-bar .search-bar {
    margin: 0 10px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
}

.top-bar .btn-event, .top-bar .btn-filter {
    background-color: #007bff;
    color: #ffffff;
    cursor: pointer;
}

.top-bar .search-bar {
    background-color: #444;
    color: #ffffff;
    padding-left: 15px;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    margin: 50px 0;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background: linear-gradient(to bottom, #007bff, #0056b3);
}

.map {
    flex: 1;
    max-width: 600px;
    position: relative;
}

.map img {
    max-width: 100%;
}

.info, .fadeIn {
    flex: 1;
    padding: 20px;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s, transform 0.6s;
}

.info h2, .fadeIn h2 {
    animation: bounce 2s infinite alternate;
}

@keyframes bounce {
    0% {
        transform: translateY(0);
    }
    100% {
        transform: translateY(-10px);
    }
}

a {
    transition: color 0.3s;
    color: inherit;
}

a:hover {
    color: #ff9900;
}

.btn {
    background: radial-gradient(#ff9900, #ff4500);
    border: none;
    color: #ffffff;
}

.icon {
    font-size: 24px;
}

.footer-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.top-bar {
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Alignement sur le même niveau */
}

.btn-event, .btn-filter {
    margin: 0 10px;
    padding: 10px 20px;
    background-color: #007bff;
    border: none;
    color: #ffffff;
    cursor: pointer;
    border-radius: 5px;
    font-size: 16px;
}

.search-bar {
    padding: 10px;
    border: none;
    border-radius: 5px;
    margin-right: 10px;
    font-size: 16px;
}

header img {
    max-width: 100px;
    height: auto;
}
</style>