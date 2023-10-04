<?php
// Récupérez les données du formulaire d'inscription
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];

// Générez un code de confirmation unique
$code_confirmation = bin2hex(random_bytes(16)); // Génère une chaîne hexadécimale aléatoire de 32 caractères

// Enregistrez le code de confirmation dans la base de données avec l'utilisateur

// Adresse e-mail de l'expéditeur
$expediteur = 'contact@example.com';

// Sujet de l'e-mail
$sujet = 'Confirmation d\'inscription';

// Message de l'e-mail
$message = "Cher $prenom $nom,\n\n";
$message .= "Cliquez sur le lien ci-dessous pour confirmer votre inscription :\n";
$message .= "https://votre-site.com/confirmation.php?code=$code_confirmation";

// En-têtes de l'e-mail
$headers = "From: $expediteur\r\n";
$headers .= "Reply-To: $expediteur\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Envoi de l'e-mail
if (mail($email, $sujet, $message, $headers)) {
    echo 'E-mail de confirmation envoyé avec succès !';
} else {
    echo 'Erreur lors de l\'envoi de l\'e-mail.';
}
?>
