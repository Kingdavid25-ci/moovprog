<?php
session_start();
include('db_connection.php');

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

// Récupérer les données du formulaire
$id_objectif = $_POST['id_objectif'];
$matricule = $_POST['matricule'];
$note_evaluateur = $_POST['NOTE_EVALUATEUR'];

// Mettre à jour la note de l'évaluateur pour l'objectif spécifié
$sql = "UPDATE evaluation SET NOTE_EVALUATEUR = ?, date_realisation = NOW() WHERE id_objectif = ? AND matricule = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sis", $note_evaluateur, $id_objectif, $matricule);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header('Location: details_evaluation.php?matricule=' . $matricule);
exit();
?>