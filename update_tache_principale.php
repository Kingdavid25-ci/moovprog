<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// Afficher les données POST pour débogage
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Assurez-vous que les données POST ne sont pas vides avant de procéder
if (isset($_POST['matricule']) && isset($_POST['id_objectif'])) {
    $matricule = $_POST['matricule'];
    $id_objectifs = $_POST['id_objectif'];
    $ponderations = $_POST['ponderation'];
    $note_objectifs = $_POST['note_objectif'];

    echo 'Matricule reçu : ' . htmlspecialchars($matricule); // Debugging

    foreach ($id_objectifs as $index => $id) {
        $ponderation = $ponderations[$index];
        $note_objectif = $note_objectifs[$index];
        
        $sql = "UPDATE evaluation SET ponderation=?, note_objectif=? WHERE ID_OBJECTIF=? AND matricule=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dssi", $ponderation, $note_objectif, $id, $matricule);
        $stmt->execute();
    }

    $stmt->close();
}

$conn->close();
?>
