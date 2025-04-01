<?php
session_start();
include('db_connection.php');

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

// Récupérer les données du formulaire
$matricule = $_SESSION['user_name'];
$ponderations = $_POST['ponderation'];
$notes = $_POST['NOTE_EVALUATEUR'];
$id_objectifs = $_POST['id_objectif'];

// Mettre à jour la table 'evaluation' pour chaque objectif
foreach ($id_objectifs as $index => $id_objectif) {
    $ponderation = $ponderations[$index];
    $note = $notes[$index];

    $sql = "UPDATE evaluation SET ponderation = ?, NOTE_EVALUATEUR = ?, date_realisation = NOW() WHERE MATRICULE = ? AND ID_OBJECTIF = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("dsis", $ponderation, $note, $matricule, $id_objectif);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
header('Location: valider_evaluation.php');
exit();
?>