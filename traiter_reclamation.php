<?php
// Connexion à la base de données
include('db_connection.php');

// Récupération du matricule de l'utilisateur connecté
session_start();
$matricule = $_SESSION['user_name'];

// Génération de l'ID Objectif personnalisé avec une incrémentation
// Rechercher le nombre de réclamations précédentes pour cet utilisateur
$sql_count = "SELECT COUNT(*) as total FROM evaluation WHERE Matricule='$matricule'";
$result = $conn->query($sql_count);
$row = $result->fetch_assoc();
$increment = $row['total'] + 1;

// Création de l'ID Objectif unique
$id_objectif = "RECL" . $matricule . "_" . $increment;

// Récupérer les données de la réclamation
$reclamation = $conn->real_escape_string($_POST['reclamation']);

// Insertion de la réclamation dans la base de données
$sql = "INSERT INTO evaluation (ID_OBJECTIF, Matricule, Reclamation) VALUES ('$id_objectif', '$matricule', '$reclamation')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Réclamation enregistrée avec succès avec l\'ID Objectif : $id_objectif'); window.location.href = 'reclamation.php';</script>";
} else {
    echo "<script>alert('Erreur : " . $conn->error . "'); window.location.href = 'reclamation.php';</script>";
}

// Fermer la connexion
$conn->close();
?>
