<!-- index.html -->
<?php
// main.php
session_start();

if (!isset($_SESSION['nom_utilisateur'])) {
    // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
    header("Location: /hackathon/login/login.html");
    exit();
}
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
    <h1>Prendre une Photo</h1>

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
