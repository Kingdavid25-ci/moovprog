<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');


// Initialiser la réponse
$response = [];

// Lire les données POST
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['competences']) && is_array($data['competences'])) {
    $competences = $data['competences'];

    // Insérer les données dans la table `objectif`
    foreach ($competences as $competence) {
        $id = $competence['id'];
        $description = $competence['description'];
        $niveau_requis = $competence['niveau_requis'];
        $status = $competence['status'];
        $Val_RH=false;

        $sql = "INSERT INTO objectif (id, description, niveau_requis, statut, categorie,Val_RG) 
                VALUES ('$id', '$description', '$niveau_requis', '$status', 'competence','$Val_RH')
                ON DUPLICATE KEY UPDATE
                description = '$description', niveau_requis = '$niveau_requis', statut = '$status', categorie = 'competence ','$Val_RH'";

        if ($conn->query($sql) === TRUE) {
            $response['message'] = "Les competences  ont été enregistrées avec succès.";
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
            $sql = "UPDATE objectif SET niveau_requis = ?, statut = ? WHERE id_objectif = ? AND categorie = 'competence '";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isi", $objective['niveau_requis'], $objective['statut'], $objective['id_objectif']);
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
