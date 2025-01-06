<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// Initialiser la réponse
$response = [];

// Lire les données POST
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['performances']) && is_array($data['performances'])) {
    $performances = $data['performances'];

    // Insérer les données dans la table `objectif`
    foreach ($performances as $performance) {
        $id = $performance['id'];
        $description = $performance['description'];
        $weighting = $performance['weighting'];
        $status = $performance['status'];

        $sql = "INSERT INTO objectif (id, description, ponderation, statut, categorie) 
                VALUES ('$id', '$description', '$weighting', '$status', 'performance quotidienne')
                ON DUPLICATE KEY UPDATE
                description = '$description', ponderation = '$weighting', statut = '$status', categorie = 'performance quotidienne'";

        if ($conn->query($sql) === TRUE) {
            $response['message'] = "Les performances quotidiennes ont été enregistrées avec succès.";
        } else {
            $response['message'] = "Erreur : " . $conn->error;
        }
    }
} else {
    $response['message'] = "Erreur : Données non valides.";
}

// Récupérer l'ID de l'utilisateur connecté
if (isset($_SESSION['user_name'])) {
    $userId = $_SESSION['user_name'];

    // Mettre à jour les objectifs modifiés
    if (isset($data['modifiedObjectives']) && is_array($data['modifiedObjectives'])) {
        $modifiedObjectives = $data['modifiedObjectives'];

        foreach ($modifiedObjectives as $objective) {
            $sql = "UPDATE objectif SET ponderation = ?, statut = ? WHERE id_objectif = ? AND categorie = 'performance quotidienne'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isi", $objective['ponderation'], $objective['statut'], $objective['id_objectif']);
            $stmt->execute();
        }
    }

    // Récupérer les salariés sous la tutelle de l'utilisateur connecté
    $sql = "SELECT matricule FROM salarie WHERE superieur_hierarchique= ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $subordinates = [];
    while ($row = $result->fetch_assoc()) {
        $subordinates[] = $row['matricule'];
    }

    // Affecter les objectifs modifiés à chaque salarié sous la tutelle
    $modifiedObjectives = []; // Initialisez la variable
    foreach ($subordinates as $matricule) {
        foreach ($modifiedObjectives as $objective) {
            $sql = "INSERT INTO evaluation (matricule, id_objectif) VALUES (?, ?) ON DUPLICATE KEY UPDATE id_objectif = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $matricule, $objective['id_objectif'], $objective['id_objectif']);
            $stmt->execute();
        }
    }
} else {
    $response['message'] = "Erreur : Utilisateur non authentifié.";
}

$conn->close();
echo json_encode($response);
?>
