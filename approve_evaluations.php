<?php
session_start();
include('db_connection.php');

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

// Récupérer les données du formulaire
$id_objectifs = $_POST['id_objectif'];
$notes = $_POST['NOTE_EVALUATEUR'];
$commentaires = $_POST['commentaires_hidden'];
$signature = $_POST['signature'];
$superior = $_SESSION['user_name'];

// Mettre à jour les évaluations dans la base de données
foreach ($id_objectifs as $index => $id_objectif) {
    $note = $notes[$index];
    $sql = "UPDATE evaluation SET NOTE_EVALUATEUR = ?, commentaires = ?, signature = ?, approbateur = ? WHERE id_objectif = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsssi", $note, $commentaires, $signature, $superior, $id_objectif);
    $stmt->execute();
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();

// Afficher le message de succès et rediriger l'utilisateur
echo "<script>
    alert('Approbation réussie');
    window.location.href = 'valider_evaluation.php';
</script>";
?>