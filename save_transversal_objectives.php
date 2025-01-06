<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');


// Vérifier si l'utilisateur est connecté et récupérer son ID
if (!isset($_SESSION['user_name'])) {
    echo json_encode(['message' => 'Utilisateur non connecté']);
    exit;
}
$user_id = $_SESSION['user_name'];

// Récupérer le unit_id de l'utilisateur connecté
$sql = "SELECT unit_id FROM salarie WHERE matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['message' => 'Utilisateur non trouvé']);
    exit;
}
$row = $result->fetch_assoc();
$unit_id = $row['unit_id'];

// Lire les données JSON envoyées par la requête AJAX
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['objectives']) || !is_array($data['objectives'])) {
    echo json_encode(['message' => 'Données invalides']);
    exit;
}

// Initialiser la variable de réponse
$response = ['message' => ''];

try {
    // Parcourir les objectifs et les insérer dans la base de données
    foreach ($data['objectives'] as $objective) {
        $id = $objective['id'];
        $description = $objective['description'];
        $performanceIndicator = $objective['performanceIndicator'];
        $weighting = $objective['weighting'];
        $status = $objective['status'];

        $sql = "INSERT INTO objectif (id, description, indicateur_performance, ponderation, statut, categorie, sructure_entreprise_id)
                VALUES ('$id', '$description', '$performanceIndicator', '$weighting', '$status', 'tache principale', '$unit_id')
                ON DUPLICATE KEY UPDATE description='$description', indicateur_performance='$performanceIndicator', ponderation='$weighting', statut='$status', sructure_entreprise_id='$unit_id'";

        if ($conn->query($sql) !== TRUE) {
            $response['message'] .= "Erreur : " . $sql . "<br>" . $conn->error . "<br>";
        }
    }
    $response['message'] .= "Données enregistrées avec succès.";
} catch (Exception $e) {
    $response['message'] = "Erreur : " . $e->getMessage();
}

// Fermer la connexion à la base de données
$conn->close();

// Envoyer la réponse JSON
echo json_encode($response);
?>
