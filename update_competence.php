<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// Afficher les données POST pour débogage
echo '<pre>';
print_r($_POST);
echo '</pre>';

if (isset($_POST['matricule']) && isset($_POST['id_competence'])) {
    $matricule = $_POST['matricule'];
    $id_competences = $_POST['id_competence'];
    $niveaux_capacite = $_POST['niveau_capacite'];
    $commentaires = $_POST['COMMENTAIRE'];

    foreach ($id_competences as $index => $id) {
        $niveau_capacite = $niveaux_capacite[$index];
        $commentaire = $commentaires[$index];

        $sql = "UPDATE evaluation SET niveau_capacite=?, commentaire=? WHERE ID_OBJECTIF=? AND matricule=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("dssi", $niveau_capacite, $commentaire, $id, $matricule);
        $stmt->execute();
    }

    $stmt->close();
}

?>
