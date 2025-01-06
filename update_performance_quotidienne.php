<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// Afficher les données POST pour débogage
echo '<pre>';
print_r($_POST);
echo '</pre>';

if (isset($_POST['matricule']) && isset($_POST['id_performance'])) {
    $matricule = $_POST['matricule'];
    $id_performances = $_POST['id_performance'];
    $ponderations = $_POST['ponderation'];
    $note_evaluateurs = $_POST['NOTE_EVALUATEUR'];

    foreach ($id_performances as $index => $id) {
        $ponderation = $ponderations[$index];
        $note_evaluateur = $note_evaluateurs[$index];

        $sql = "UPDATE evaluation SET ponderation=?, note_evaluateur=? WHERE ID_OBJECTIF=? AND matricule=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dssi", $ponderation, $note_evaluateur, $id, $matricule);
        $stmt->execute();
    }

    $stmt->close();
}

?>
