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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder@1.14.0/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet-control-geocoder@1.14.0/dist/Control.Geocoder.js"></script>

    
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
    </header>
    <center><h1>Événements liés à la Pollution</h1></center>
        
    
    <main>
        <section class="event-form">
            <h2>Ajouter un Événement</h2>
            <form id="eventForm" action="ajouter_evenement.php" method="post">
                <label for="eventName">Nom de l'Événement:</label>
                <input type="text" id="eventName" name="nom" required><br>
            
                <label for="eventLocation">Lieu:</label>
                <input type="text" id="eventLocation" name="lieu" required><br>
            
                <label for="eventDate">Date:</label>
                <input type="date" id="eventDate" name="date" required><br>
            
                <button type="submit">Ajouter</button>
            </form>
            
            
            
        </section>

        <section class="event-list">
            <h2>Liste des Événements</h2>
            <ul id="eventList">
                <!-- Les événements seront ajoutés ici avec JavaScript -->
            </ul>
        </section>
    </main>

    <script src="event.js"></script>
</body>

</html>
<style>
    body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, #206fdd, #444444);

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