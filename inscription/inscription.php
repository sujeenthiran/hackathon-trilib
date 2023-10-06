<?php
// Connexion à la base de données (même code que dans votre fichier de connexion)
$serveur = "localhost";
$nom_utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "hackathon";

$connexion = new mysqli($serveur, $nom_utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

// Initialisation des messages
$messageErreur = "";
$messageSucces = "";

// Votre code PHP pour traiter l'inscription ici
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['password'])) {
    // Récupération des données du formulaire d'inscription
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification de l'unicité de l'email (pour éviter les doublons)
    $verification_sql = "SELECT * FROM users WHERE email='$email'";
    $verification_resultat = $connexion->query($verification_sql);

    if ($verification_resultat->num_rows > 0) {
        // Message d'erreur si l'e-mail existe déjà
        $messageErreur = '<p style="color: red;">L\'email est déjà utilisé. Veuillez choisir un autre email.</p>';
    } else {
        // Insertion des données dans la base de données
        $insertion_sql = "INSERT INTO users (nom, prenom, email, mot_de_passe) VALUES ('$nom', '$prenom', '$email', '$password')";

        if ($connexion->query($insertion_sql) === TRUE) {
            // Message de succès en cas d'inscription réussie
            $messageSucces = '<p style="color: green;">Inscription réussie ! Vous pouvez maintenant vous connecter.</p>';
        } else {
            // Message d'erreur en cas d'échec de l'insertion
            $messageErreur = '<p style="color: red;">Erreur lors de l\'inscription : ' . $connexion->error . '</p>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <title>Formulaire d'Inscription</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: black;
        }

        .page {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 100%;
            padding: 40px;
        }

        .left {
            background: #ff00ff;
            background: linear-gradient(to right, #ff00ff 0%, #ff0000 100%);
            color: white;
            padding: 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .login {
            font-size: 28px;
            font-weight: bold;
        }

        .eula {
            font-size: 14px;
        }

        .right {
            flex: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        svg {
            width: 200px;
            margin-bottom: 20px;
        }

        /* Styles pour le conteneur du formulaire */
.form {
    display: flex;
    flex-direction: column;
    align-items: center; /* Alignez les éléments horizontalement au centre */
    width: 100%;
    max-width: 300px;
}

/* Styles pour les étiquettes (labels) */
label {
    margin-top: 10px;
    font-weight: bold;
    width: 100%; /* Forcez les étiquettes à occuper la largeur totale */
}

/* Styles pour les champs de saisie (input) */
input[type="submit"]{
    background-color: green;
    padding: 10px;
    margin-bottom: 10px;
}
input[type="text"],
input[type="email"],
input[type="password"] {
    padding: 10px;
    margin-bottom: 10px;
    border: none;
    border-radius: 5px;
    background-color: gray;
    width: 100%; /* Forcez les champs de saisie à occuper la largeur totale */
}


        input[type="submit"]:hover {
            background-color: #ff0000;
        }

        /* Styles pour les messages d'erreur et de succès */
        .message-erreur {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .message-succes {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="container">
            <div class="left">
                <div class="login">Login</div>
                <div class="eula">By logging in you agree to the ridiculously long terms that you didn't bother to read</div>
            </div>
            <div class="right">
                <svg viewBox="0 0 320 300">
                    <defs>
                        <linearGradient
                            inkscape:collect="always"
                            id="linearGradient"
                            x1="13"
                            y1="193.49992"
                            x2="307"
                            y2="193.49992"
                            gradientUnits="userSpaceOnUse">
                            <stop
                                style="stop-color:#ff00ff;"
                                offset="0"
                                id="stop876" />
                            <stop
                                style="stop-color:#ff0000;"
                                offset="1"
                                id="stop878" />
                        </linearGradient>
                    </defs>
                    <path d="m 40,120.00016 239.99984,-3.2e-4 c 0,0 24.99263,0.79932 25.00016,35.00016 0.008,34.20084 -25.00016,35 -25.00016,35 h -239.99984 c 0,-0.0205 -25,4.01348 -25,38.5 0,34.48652 25,38.5 25,38.5 h 215 c 0,0 20,-0.99604 20,-25 0,-24.00396 -20,-25 -20,-25 h -190 c 0,0 -20,1.71033 -20,25 0,24.00396 20,25 20,25 h 168.57143" />
                </svg>
                <div class="form">
                    <form action="inscription.php" method="post">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" required><br>
                        <label for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" required><br>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required><br>
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        <input type="submit" id="submit" value="S'inscrire">
                         <a href="/hackathon/login/login.php"type="submitr"> login </a>
                    </form>
                    <?php echo $messageErreur; ?>
                <?php echo $messageSucces; ?>
                </div>
              
            </div>
        </div>
    </div>
    <script>
        var current = null;
        document.querySelector('#email').addEventListener('focus', function(e) {
            if (current) current.pause();
            current = anime({
                targets: 'path',
                strokeDashoffset: {
                    value: 0,
                    duration: 700,
                    easing: 'easeOutQuart'
                },
                strokeDasharray: {
                    value: '240 1386',
                    duration: 700,
                    easing: 'easeOutQuart'
                }
            });
        });
        document.querySelector('#password').addEventListener('focus', function(e) {
            if (current) current.pause();
            current = anime({
                targets: 'path',
                strokeDashoffset: {
                    value: -336,
                    duration: 700,
                    easing: 'easeOutQuart'
                },
                strokeDasharray: {
                    value: '240 1386',
                    duration: 700,
                    easing: 'easeOutQuart'
                }
            });
        });
        document.querySelector('#submit').addEventListener('focus', function(e) {
            if (current) current.pause();
            current = anime({
                targets: 'path',
                strokeDashoffset: {
                    value: -730,
                    duration: 700,
                    easing: 'easeOutQuart'
                },
                strokeDasharray: {
                    value: '530 1386',
                    duration: 700,
                    easing: 'easeOutQuart'
                }
            });
        });
    </script>
</body>
</html>
