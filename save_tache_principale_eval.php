<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

echo '<pre>';
print_r($_POST);
echo '</pre>';

// Récupérer le matricule et les notes du formulaire
$matricule = $_POST['matricule'];
$notes = $_POST['note'];

// Mettre à jour la table 'evaluation' pour chaque note
foreach ($notes as $id_objectif => $note) {
    $sql = "UPDATE evaluation SET NOTE_OBJECTIF = ? WHERE MATRICULE = ? AND ID_OBJECTIF = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("dsi", $note, $matricule, $id_objectif);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();


echo "evaluation des tache principale a été sauvegardé avec succes";
exit;
?>
