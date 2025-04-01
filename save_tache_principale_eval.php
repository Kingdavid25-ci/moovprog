<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// Récupérer le matricule et les notes du formulaire
$matricule = $_POST['matricule'];
$notes = $_POST['note'];

// Vérifier que le matricule est présent
if (empty($matricule)) {
    echo "<script>alert('Le matricule est requis.'); window.location.href = 'evaluation31.php';</script>";
    exit();
}

// Vérifier que des notes ont été soumises
if (empty($notes)) {
    echo "<script>alert('Aucune note soumise.'); window.location.href = 'evaluation31.php';</script>";
    exit();
}

// Vérifier que toutes les notes sont numériques
foreach ($notes as $id_objectif => $note) {
    if (!is_numeric($note)) {
        echo "<script>alert('Toutes les notes doivent être des valeurs numériques.'); window.location.href = 'evaluation31.php';</script>";
        exit();
    }
}

// Mettre à jour la table 'evaluation' pour chaque note
foreach ($notes as $id_objectif => $note) {
    $sql = "UPDATE evaluation SET NOTE_OBJECTIF = ?, NOTE_EVALUATEUR = ? WHERE MATRICULE = ? AND ID_OBJECTIF = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("dsis", $note, $note, $matricule, $id_objectif);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();

echo "<script>alert('Évaluation des tâches principales sauvegardée avec succès.'); window.location.href = 'modifier31.php';</script>";
exit();
?>
