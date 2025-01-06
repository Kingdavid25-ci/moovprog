<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');


// Vérifie si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Parcourir chaque objectif soumis
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'objective') !== false && strpos($key, 'Evaluation') !== false) {
            // Extraire l'index de l'objectif
            $index = str_replace(array('objective', 'Evaluation'), '', $key);
            
            // Récupérer les autres valeurs associées à cet objectif
            $description = $_POST['objective' . $index . 'Description'];
            $indicateur = $_POST['objective' . $index . 'Indicateur'];
            $dateDebut = $_POST['objective' . $index . 'DateDebut'];
            $dateFin = $_POST['objective' . $index . 'DateFin'];
            $ponderation = $_POST['objective' . $index . 'Ponderation'];
            $evaluation = $_POST['objective' . $index . 'Evaluation'];
            $matricule = $_POST['salarie'];

            // Préparer et exécuter la requête pour mettre à jour la note de l'objectif
            $sql = "UPDATE objectif 
                    SET NOTE_N1 = ? 
                    WHERE matricule = ? AND DESCRIBES = ? AND INDICATEUR_PERFORMANCE = ? AND DATE_DEBUT = ? AND DATE_LIMIT_OB = ? AND PONDERATION = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $evaluation, $matricule, $description, $indicateur, $dateDebut, $dateFin, $ponderation);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Fermer la connexion
$conn->close();

// Rediriger l'utilisateur après l'enregistrement des notes
header("Location: main-menu.html");
exit();
?>
