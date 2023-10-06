
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Rétractable</title>
    <link rel="stylesheet" href="styles.css"> <!-- Lien vers un fichier CSS externe -->
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="logo">
                <a href="/hackathon/index.php"><img src="/hackathon/paris.png" alt="Paris"></a>
            </div>
            <div class="user-info">
                <p>Bienvenue, <?php echo "$prenom_utilisateur $nom_utilisateur"; ?> !</p>
            </div>
            <span class="menu-icon" id="toggle-menu">&#9776;</span>
            <div class="mobile-menu">
                <a href="/hackathon/events/event.php">Événements</a>
                <a href="/hackathon/photo/photo.php">Photo</a>
                <a href="/hackathon/logout/logout.php">Déconnexion</a>
                <input type="text" class="search-bar" placeholder="Rechercher...">
            </div>
        </div>
    </header>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
