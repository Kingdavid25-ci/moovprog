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

// Vérifiez si 'competences' existe dans $data et s'il n'est pas null
if (isset($data['competences']) && is_array($data['competences'])) {
    $competences = $data['competences'];
    
    // Préparer l'insertion des affectations
    $sqlInsert = "INSERT INTO evaluation (matricule, ID_objectif) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);

    // Insérer les objectifs pour chaque employé
    foreach ($employees as $employee) {
        foreach ($competences as $competence) {
            // Vérifiez si 'id' existe dans $competence
            if (isset($competence['id'])) {
                $stmtInsert->bind_param("si", $employee, $competence['id']);
                $stmtInsert->execute();
            }
        }
    }

    $stmtInsert->close();
    $conn->close();

    // Retourner une réponse JSON
    echo json_encode(["message" => "Les objectifs de categorie competence ont été affectés avec succès."]);
} else {
    // Si les données ne sont pas valides, retourner un message d'erreur
    echo json_encode(["message" => "Aucune donnée valide reçue."]);
}
?>
