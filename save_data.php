<?php
header('Content-Type: application/json');

// Configuration de la connexion
include('db_connection.php');


// Récupérer les données POST
$data = json_decode(file_get_contents('php://input'), true);

// Vérifier si les données ont bien été reçues
if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Aucune donnée reçue.']);
    exit;
}

// Vérifier la présence de toutes les clés
if (!isset($data['objectives']) || !isset($data['performances']) || !isset($data['competencies']) || !isset($data['development'])) {
    echo json_encode(['status' => 'error', 'message' => 'Données manquantes.', 'data' => $data]);
    exit;
}

// Récupérer les IDs de toutes les unités dans la table sructure_entreprise
$structure_ids = [];
$sql = "SELECT id FROM sructure_entreprise";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $structure_ids[] = $row['id'];
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Aucune unité trouvée dans la table sructure_entreprise.']);
    exit;
}

// Préparer une réponse
$response = ['status' => 'error', 'message' => '', 'errors' => []];

// Insérer les objectifs transversaux
foreach ($data['objectives'] as $objective) {
    $description = $conn->real_escape_string($objective['description']);
    $indicateur_performance = $conn->real_escape_string($objective['indicator']);
    $ponderation = $objective['weighting'];
    $etat = $conn->real_escape_string($objective['etat']);

    foreach ($structure_ids as $structure_id) {
        $sql = "INSERT INTO objectif (description, indicateur_performance, ponderation, categorie, statut, etat, sructure_entreprise_id)
                VALUES ('$description', '$indicateur_performance', $ponderation, 'tache principale', 'Applicable', '$etat', $structure_id)";

        if (!$conn->query($sql)) {
            $response['errors'][] = "Erreur lors de l'insertion des objectifs transversaux pour l'unité $structure_id: " . $conn->error;
        }
    }
}

// Insérer les performances quotidiennes
foreach ($data['performances'] as $performance) {
    $description = $conn->real_escape_string($performance['description']);
    $ponderation = $performance['weighting'];
    $etat = $conn->real_escape_string($performance['etat']);

    foreach ($structure_ids as $structure_id) {
        $sql = "INSERT INTO objectif (description, ponderation, categorie, statut, etat, sructure_entreprise_id)
                VALUES ('$description', $ponderation, 'performance quotidienne', 'Applicable', '$etat', $structure_id)";

        if (!$conn->query($sql)) {
            $response['errors'][] = "Erreur lors de l'insertion des performances quotidiennes pour l'unité $structure_id: " . $conn->error;
        }
    }
}

// Insérer les compétences
foreach ($data['competencies'] as $competency) {
    $description = $conn->real_escape_string($competency['description']);
    $niveau_requis = $conn->real_escape_string($competency['requiredLevel']);
    $etat = $conn->real_escape_string($competency['etat']);

    foreach ($structure_ids as $structure_id) {
        $sql = "INSERT INTO objectif (description, niveau_requis, categorie, statut, etat, sructure_entreprise_id)
                VALUES ('$description', '$niveau_requis', 'competence', 'Applicable', '$etat', $structure_id)";

        if (!$conn->query($sql)) {
            $response['errors'][] = "Erreur lors de l'insertion des compétences pour l'unité $structure_id: " . $conn->error;
        }
    }
}

// Insérer les développements
foreach ($data['development'] as $developmentQuestion) {
    $description = $conn->real_escape_string($developmentQuestion['description']);
    $etat = $conn->real_escape_string($developmentQuestion['etat']);

    foreach ($structure_ids as $structure_id) {
        $sql = "INSERT INTO objectif (description, categorie, statut, etat, sructure_entreprise_id)
                VALUES ('$description', 'developpement', 'Applicable', '$etat', $structure_id)";

        if (!$conn->query($sql)) {
            $response['errors'][] = "Erreur lors de l'insertion des développements pour l'unité $structure_id: " . $conn->error;
        }
    }
}

if (empty($response['errors'])) {
    $response['status'] = 'success';
    $response['message'] = 'Données sauvegardées avec succès !';
} else {
    $response['message'] = 'Erreur lors de la sauvegarde des données.';
}

$conn->close();
echo json_encode($response);
?>
