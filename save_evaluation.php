<?php
session_start();

// MATRICULE de l'utilisateur connecté
$MATRICULE = $_SESSION['user_name'];

include('db_connection.php');

// Assurez-vous que la connexion à la base de données est établie
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Processing Tâche Principale auto-evaluation
if (isset($_POST['auto_evaluation'])) {
    foreach ($_POST['auto_evaluation'] as $objectif_id => $commentaire) {
        $stmt = $conn->prepare("UPDATE evaluation SET autoevaluation_objectif = ? WHERE MATRICULE = ? AND ID_OBJECTIF = ?");
        $stmt->bind_param("sii", $commentaire, $MATRICULE, $objectif_id);
        $stmt->execute();
    }
}

// Processing Performance Quotidienne auto-evaluation
if (isset($_POST['auto_evaluation_perform'])) {
    foreach ($_POST['auto_evaluation_perform'] as $objectif_id => $commentaire) {
        $stmt = $conn->prepare("UPDATE evaluation SET AUTO_EVALUATION_PERFORM = ? WHERE MATRICULE = ? AND ID_OBJECTIF = ?");
        $stmt->bind_param("sii", $commentaire, $MATRICULE, $objectif_id);
        $stmt->execute();
    }
}

// Processing Développement auto-evaluation
if (isset($_POST['reponse_develop'])) {
    foreach ($_POST['reponse_develop'] as $objectif_id => $reponse) {
        $stmt = $conn->prepare("UPDATE evaluation SET reponse_develop = ? WHERE MATRICULE = ? AND ID_OBJECTIF = ?");
        $stmt->bind_param("sii", $reponse, $MATRICULE, $objectif_id);
        $stmt->execute();
    }
}

$conn->close();

// Redirect to a confirmation page or back to the evaluation form
echo"autoevaluation effectué avec succès";
exit();
?>
