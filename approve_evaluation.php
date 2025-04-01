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

// Mettre à jour l'état de l'évaluation pour l'approuver
$sql = "UPDATE evaluation SET etat = 'Approuvé', date_approbation = NOW() WHERE id_objectif = ? AND matricule = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("is", $id_objectif, $matricule);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header('Location: details_evaluation.php?matricule=' . $matricule);
exit();
?>