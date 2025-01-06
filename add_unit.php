<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['new-unit-name'];
    $type = $_POST['new-unit-type'];
    $parent_id = $_POST['parent-unit'] ?? null;
    $responsable_id = $_POST['responsable-id'] ?? null; // Retrieve the responsable_id

    $sql = "INSERT INTO sructure_entreprise (nom, type, parent_id, responsable_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $nom, $type, $parent_id, $responsable_id); // Use the correct types for the parameters

    if ($stmt->execute()) {
        echo "Unité ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'unité : " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
header("Location: votre_fichier_html.php"); // Redirect to the main page after adding
exit;
?>
