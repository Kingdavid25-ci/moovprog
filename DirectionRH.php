<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Interface</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styles généraux pour la page */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        /* Configuration de l'image de fond */
        body {
            background-image: url('img/ab1.jpg'); /* Remplacez cette URL par celle de votre image de fond */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            display: flex;
            justify-content: center; /* Centre horizontalement le contenu */
            align-items: center; /* Centre verticalement le contenu */
        }

        /* Style de l'overlay sombre pour le contraste */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Couleur de superposition plus sombre */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column; /* Affiche les éléments en colonne */
            text-align: center;
            padding: 20px;
        }

        /* Style des boutons personnalisés */
        .btn-custom {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 2px solid white;
            margin: 10px;
            width: 250px;
            padding: 10px;
            transition: background-color 0.3s, color 0.3s, transform 0.3s; /* Transition pour l'effet de survol */
            font-size: 1.1em;
        }

        /* Effet de survol des boutons */
        .btn-custom:hover {
            background-color: white;
            color: black;
            transform: scale(1.1); /* Agrandit légèrement le bouton lors du survol */
        }

        /* Style du texte animé */
        h1 {
            margin-bottom: 40px;
            font-size: 4em;
            font-weight: bold;
            overflow: hidden;
            white-space: nowrap;
            border-right: 0.15em solid orange;
            animation: typing 3.5s steps(30, end), blink-caret 0.75s step-end infinite;
        }

        /* Keyframes pour l'effet de saisie du texte */
        @keyframes typing {
            from { width: 0; } /* Démarre à zéro largeur */
            to { width: 15ch; } /* S'arrête à 13 caractères */
        }

        /* Keyframes pour l'effet de clignotement du curseur */
        @keyframes blink-caret {
            from, to { border-color: transparent; }
            50% { border-color: orange; }
        }

        /* Ajout d'un effet de fondu pour l'overlay */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Animation de fondu pour l'overlay */
        .overlay {
            animation: fadeIn 4s ease-in-out;
        }
    </style>
</head>
<body>
    <!-- Overlay contenant les éléments de l'interface -->
    <div class="overlay">
        <h1>DRH Moov-Africa</h1> <!-- Titre avec animation -->
        <div>
            <!-- Boutons de navigation vers différentes pages -->
            <button class="btn btn-custom btn-lg" onclick="navigateTo('unit')">Gestion de la structure de l'entreprise</button>
            <button class="btn btn-custom btn-lg" onclick="navigateTo('admin2')">Gestion des paramètres d'évaluation</button>
            <button class="btn btn-custom btn-lg" onclick="navigateTo('objectives_summary')">Récapitulatif des différents objectifs</button>
            <button class="btn btn-custom btn-lg" onclick="navigateTo('evaluation_summary')">Récapitulatif des différentes évaluations</button>
            <button class="btn btn-custom btn-lg" onclick="navigateTo('filtre_resultat')">Resultats de toutes les évaluations</button>
        </div>
    </div>

    <script>
        // Fonction pour naviguer vers d'autres pages
        function navigateTo(page) {
            switch (page) {
                case 'admin2':
                    window.location.href = 'admin2.php'; // Redirige vers la page des paramètres d'évaluation
                    break;
                case 'unit':
                    window.location.href = 'unit.php'; // Redirige vers la gestion de la structure
                    break;
                case 'objectives_summary':
                    window.location.href = 'filtre.php'; // Redirige vers le récapitulatif des objectifs
                    break;
                case 'evaluation_summary':
                    window.location.href = 'filtre_evaluation'; // Redirige vers le récapitulatif des évaluations
                    break;
                    case 'filtre_resultat':
                    window.location.href = 'filtre_resultat.php'; // Redirige vers la gestion de la structure
                    break;
                default:
                    alert('Page not found'); // Message d'erreur si la page n'existe pas
            }
        }
    </script>
</body>
</html>
