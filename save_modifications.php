<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');
// Fonction pour nettoyer les données d'entrée
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Récupérer les données du formulaire
$matricule = isset($_POST['salarie']) ? clean_input($_POST['salarie']) : '';

// Récupérer toutes les modifications d'objectifs
$objectifs = [];
foreach ($_POST as $key => $value) {
    if (strpos($key, 'objectif') === 0) {
        preg_match('/objectif(\d+)([A-Za-z]+)/', $key, $matches);
        $index = $matches[1];
        $field = $matches[2];

        if (!isset($objectifs[$index])) {
            $objectifs[$index] = [];
        }

        $objectifs[$index][$field] = clean_input($value);
    }
}

// Parcourir chaque objectif et mettre à jour la base de données
foreach ($objectifs as $objectif) {
    $description = isset($objectif['Description']) ? $objectif['Description'] : '';
    $indicateur = isset($objectif['Indicateur']) ? $objectif['Indicateur'] : '';
    $dateDebut = isset($objectif['DateDebut']) ? $objectif['DateDebut'] : '';
    $dateFin = isset($objectif['DateFin']) ? $objectif['DateFin'] : '';
    $ponderation = isset($objectif['Ponderation']) ? $objectif['Ponderation'] : '';
    $noteN1 = isset($objectif['objectif']) ? $objectif['objectif'] : '';

    // Préparer la requête SQL pour mettre à jour l'objectif
    $sql = "UPDATE objectif SET DESCRIBES = ?, INDICATEUR_PERFORMANCE = ?, DATE_DEBUT = ?, DATE_LIMIT_OB = ?, PONDERATION = ?, NOTE_N1 = ? WHERE matricule = ? AND DESCRIBES = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $description, $indicateur, $dateDebut, $dateFin, $ponderation, $noteN1, $matricule, $description);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Rediriger vers la page précédente après la mise à jour
header("Location: evaluer_subalterne.php");
exit();
?>
