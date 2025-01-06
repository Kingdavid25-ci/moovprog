<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

$matricule_salarie = $_POST['matricule_salarie'];
$numObjectives = $_POST['numObjectives'];

// Boucle sur chaque objectif pour insérer les données
for ($i = 1; $i <= $numObjectives; $i++) {
    $objectiveID = $_POST["objective{$i}ID"];
    $commentaire = $_POST["objective{$i}Commentaire"];
    $dateRealisation = $_POST["objective{$i}DateRealisation"];
    $noteN1 = $_POST["objective{$i}NoteN1"];

    // Insertion ou mise à jour de l'évaluation
    $sql = "INSERT INTO evaluation (ID_OBJECTIF, COMMENTAIRE, DATE_REALISATION, NOTE_N1) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE COMMENTAIRE=?, DATE_REALISATION=?, NOTE_N1=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $objectiveID, $commentaire, $dateRealisation, $noteN1, $commentaire, $dateRealisation, $noteN1);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: mesobjectifs.php?success=true");
?>
