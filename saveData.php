<?php
include('db_connection.php');

// Récupérer les données JSON depuis le POST
$data = json_decode(file_get_contents('php://input'), true);

// Ajouter un message de débogage pour afficher les données reçues
file_put_contents('php://stderr', print_r($data, true));

if ($data) {
    // Préparer la requête SQL pour insérer les données sans inclure l'ID
    $stmt = $conn->prepare("INSERT INTO objectif (Description, indicateur_performance, ponderation, etat, Categorie) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode(["message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit();
    }

    // Pour chaque catégorie de données
    foreach ($data as $category => $items) {
        foreach ($items as $item) {
            $stmt->bind_param("ssdss", 
                $item['description'], 
                $item['performanceIndicator'], 
                $item['ponderation'], 
                $item['etat'], 
                $category // La catégorie est soit 'tache principale', 'performance quotidienne', ou 'competence'
            );
            if (!$stmt->execute()) {
                echo json_encode(["message" => "Execute failed: " . $stmt->error]);
                $stmt->close();
                $conn->close();
                exit();
            }
            // Ajouter un message de débogage après chaque insertion réussie
            file_put_contents('php://stderr', "Inserted: " . json_encode($item) . "\n");
        }
    }

    $stmt->close();
    echo json_encode(["message" => "Toutes les données ont été enregistrées."]);
} else {
    echo json_encode(["message" => "Aucune donnée reçue."]);
}

$conn->close();
?>
