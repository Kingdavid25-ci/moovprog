<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// Récupérer les données du formulaire
$unit = isset($_POST['unit']) ? $_POST['unit'] : null;
$dateCreation = isset($_POST['dateCreation']) ? $_POST['dateCreation'] : null;
$numObjectives = isset($_POST['numObjectives']) ? $_POST['numObjectives'] : 0;

if ($unit && $dateCreation && $numObjectives) {
    for ($i = 1; $i <= $numObjectives; $i++) {
        $description = isset($_POST["objective{$i}Description"]) ? $_POST["objective{$i}Description"] : '';
        $indicateur = isset($_POST["objective{$i}Indicateur"]) ? $_POST["objective{$i}Indicateur"] : '';
        $ponderation = isset($_POST["objective{$i}Ponderation"]) ? $_POST["objective{$i}Ponderation"] : 0;

        // Préparer et exécuter la requête d'insertion
        $stmt = $conn->prepare("INSERT INTO objectifs (unité, date_creation, description_objectif, indicateur_performance, ponderation) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isssi", $unit, $dateCreation, $description, $indicateur, $ponderation);
        
        if ($stmt->execute() === TRUE) {
            echo "Nouvel objectif créé avec succès.<br>";
        } else {
            echo "Erreur : " . $stmt->error . "<br>";
        }
        
        $stmt->close();
    }
} else {
    echo "Tous les champs sont requis.<br>";
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Résultat de l'insertion des objectifs</title>
</head>
<body>
    <p><a href="créer_objectif.php">Retour à la page de création des objectifs</a></p>
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Objectifs</title>
    <style>
        /* Étape 2 : Ajouter le CSS pour styliser le pop-up */
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <p><a href="créer_objectif.php">Retour à la page de création des objectifs</a></p>

    <!-- Étape 1 : Ajouter le code HTML pour le pop-up -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Votre message ici...</p>
        </div>
    </div>

    <button id="myBtn">Ouvrir le Pop-up</button>

    <script>
        // Étape 3 : Ajouter le JavaScript pour afficher et masquer le pop-up
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
</body>
</html>

