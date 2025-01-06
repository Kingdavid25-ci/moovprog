<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

echo '<pre>';
print_r($_POST);
echo '</pre>';
// Récupérer le matricule, niveaux de capacité, lacunes et commentaires du formulaire
$matricule = $_POST['matricule'];
$capacites = $_POST['capacite'];
$commentaires = $_POST['commentaire'];

// Mettre à jour la table 'evaluation' pour chaque compétence
foreach ($capacites as $id_objectif => $niveau_capacite) {
    if (isset($_POST['niveau_requis'][$id_objectif])) {
        $niveau_requis = $_POST['niveau_requis'][$id_objectif];
    } else {
        $niveau_requis = 0; // Ou une autre valeur par défaut
    }
    $capacite_lacune = $niveau_capacite - $niveau_requis;
    $commentaire = $commentaires[$id_objectif];

    $sql = "UPDATE evaluation SET NIVEAU_CAPACITE = ?, CAPACITE_LACUNE = ?, COMMENTAIRE = ? WHERE MATRICULE = ? AND ID_OBJECTIF = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ddssi", $niveau_capacite, $capacite_lacune, $commentaire, $matricule, $id_objectif);
        $stmt->execute();
        $stmt->close();
    }
}


$conn->close();
echo "evaluation des tache principale a été sauvegardé avec succes";
exit;
?>
