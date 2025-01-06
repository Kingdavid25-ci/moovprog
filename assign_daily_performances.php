<?php
header('Content-Type: application/json'); // Assure que le type de contenu est JSON
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// MATRICULE de l'utilisateur connecté
$MATRICULE = $_SESSION['user_name'];

// Récupérer les employés sous le superviseur
$employees = [];
$sql = "SELECT matricule FROM salarie WHERE superieur_hierarchique = (SELECT matricule FROM salarie WHERE matricule = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $employees[] = $row['matricule'];
    }
}
$stmt->close();

// Récupérer les données envoyées
$data = json_decode(file_get_contents('php://input'), true);

// Vérifiez si 'performances' existe dans $data et s'il n'est pas null
if (isset($data['performances']) && is_array($data['performances'])) {
    $performances = $data['performances'];
    
    // Préparer l'insertion des affectations
    $sqlInsert = "INSERT INTO evaluation (matricule, ID_objectif) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);

    // Insérer les objectifs pour chaque employé
    foreach ($employees as $employee) {
        foreach ($performances as $performance) {
            // Vérifiez si 'id' existe dans $performance
            if (isset($performance['id'])) {
                $stmtInsert->bind_param("si", $employee, $performance['id']);
                $stmtInsert->execute();
            }
        }
    }

    $stmtInsert->close();
    $conn->close();

    // Retourner une réponse JSON
    echo json_encode(["message" => "Les objectifs de performance quotidienne ont été affectés avec succès."]);
} else {
    // Si les données ne sont pas valides, retourner un message d'erreur
    echo json_encode(["message" => "Aucune donnée valide reçue."]);
}
?>
