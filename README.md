# ♻️ Hackathon – carte des stations Trilib' à Paris

Application web réalisée en **3 jours lors d'un hackathon (octobre 2023)**. Elle aide les habitants à trouver les stations de tri **Trilib'** à Paris, à participer à des événements de nettoyage et à partager des photos.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Python](https://img.shields.io/badge/Python-3776AB?style=flat-square&logo=python&logoColor=white)
![Leaflet](https://img.shields.io/badge/Leaflet-199900?style=flat-square&logo=leaflet&logoColor=white)

## ✨ Fonctionnalités

- 🗺️ **Carte interactive** (Leaflet + OpenStreetMap) des stations Trilib'
- 🐍 **Script Python** (`main.py`) qui récupère les stations via l'**API Open Data de la Ville de Paris** et génère `coordinates.json`
- 👤 Inscription et connexion des utilisateurs (sessions PHP)
- 📅 Création et liste d'**événements** (nettoyage, collecte…)
- 📸 Prise de **photos** depuis la webcam et galerie personnelle

## 🔐 Sécurité (revue en 2026)

En reprenant ce projet avec mon regard d'étudiant en cybersécurité, j'ai corrigé les failles du code d'origine :

| Faille | Correction |
|---|---|
| **Injection SQL** (connexion, inscription, événements) | Requêtes préparées (`prepare` / `bind_param`) |
| **Mots de passe stockés en clair** | Hachage bcrypt avec `password_hash` / `password_verify` |
| **Fixation de session** | `session_regenerate_id()` après connexion |
| **XSS** (affichage des noms et des événements) | Échappement avec `htmlspecialchars` |
| **Upload de fichier non contrôlé** | Liste blanche d'extensions, vérification du contenu image, nom de fichier nettoyé |
| **Fuite d'informations** (requêtes SQL et erreurs affichées) | Messages d'erreur génériques |
| **Données personnelles dans le dépôt** | Remplacées par des données de démonstration |

## 🚀 Lancer le projet

1. Installer un serveur local (XAMPP, WAMP…) avec PHP et MySQL
2. Copier le dossier dans le répertoire web sous le nom `hackathon`
3. Importer `hackathon.sql` dans MySQL
4. (Optionnel) Mettre à jour les stations : `python main.py`
5. Ouvrir `http://localhost/hackathon-trilib/` et se connecter avec le compte de démo `demo@example.com` / `demo1234`

## 🛠️ Stack

PHP 8 · MySQL / MariaDB · JavaScript · Leaflet · Python (requests) · API Open Data Paris
