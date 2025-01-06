<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// Matricule de l'utilisateur connecté
$matricule = $_SESSION['user_name'];

// Récupérer le unit_id du supérieur à partir de son matricule
$sql = "SELECT unit_id FROM salarie WHERE matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$stmt->bind_result($unit_superieur);
$stmt->fetch();
$stmt->close();

// Obtenir la date actuelle du système
$date_creation = date("Y-m-d H:i:s");

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Traiter les pondérations et statuts
    if (isset($_POST['ponderation']) && isset($_POST['statut'])) {
        foreach ($_POST['ponderation'] as $id => $ponderation) {
            $statut = $_POST['statut'][$id];

            $id = $conn->real_escape_string($id);
            $ponderation = $conn->real_escape_string($ponderation);
            $statut = $conn->real_escape_string($statut);
            $unit_superieur = $conn->real_escape_string($unit_superieur);
            $date_creation = $conn->real_escape_string($date_creation);

            $sql = "UPDATE objectif SET 
                        ponderation = '$ponderation', 
                        statut = '$statut', 
                        sructure_entreprise_id = '$unit_superieur', 
                        date_creation = '$date_creation' 
                    WHERE id = '$id'";
            $conn->query($sql);
        }
    }

    // Récupérer les objectifs de catégorie "performance quotidienne" avec le statut "Applicable"
    $objectives = [];
    $sql = "SELECT id FROM objectif WHERE sructure_entreprise_id = ? AND categorie = 'performance quotidienne' AND statut = 'Applicable'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $unit_superieur);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $objectives[] = $row['id'];
        }
    }
    $stmt->close();

    // Récupérer les employés sous le superviseur
    $employees = [];
    $sql = "SELECT matricule FROM salarie WHERE superieur_hierarchique = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $matricule);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row['matricule'];
        }
    }
    $stmt->close();

    // Affecter les objectifs aux employés dans la table evaluation
    if (!empty($objectives) && !empty($employees)) {
        foreach ($employees as $employee) {
            foreach ($objectives as $objective_id) {
                // Vérifier si l'association existe déjà
                $sql = "SELECT 1 FROM evaluation WHERE MATRICULE = ? AND ID_OBJECTIF = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ii", $employee, $objective_id);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows == 0) {
                    // Si l'association n'existe pas, insérer une nouvelle ligne
                    $sql = "INSERT INTO evaluation (MATRICULE, ID_OBJECTIF) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ii", $employee, $objective_id);
                    $stmt->execute();
                }
                $stmt->close();
            }
        }
    }
}

echo "L'enregistrement a été sauvegardé.";
$conn->close();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Résultat de l'insertion des objectifs</title>
</head>
<body>
    <p><a href="créer_objectif.php">Retour à la page de création des objectifs</a></p>
</body>
</html>
