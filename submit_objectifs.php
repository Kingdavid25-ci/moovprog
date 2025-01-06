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
</body>
</html>
