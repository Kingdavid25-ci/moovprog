<?php
session_start();

// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
//$dbname = "moov_africa_test";
$dbname = "moovprog";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// MATRICULE de l'utilisateur connecté
$MATRICULE = $_SESSION['user_name'];

// Récupérer les employés sous le superviseur
$employees = [];
$sql = "SELECT matricule, nom, prenom FROM salarie WHERE superieur_hierarchique = (SELECT matricule FROM salarie WHERE matricule = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}
$stmt->close();

// Récupérer l'unité de l'utilisateur connecté
$sql = "SELECT unit_id FROM salarie WHERE matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$unit_id = $row['unit_id'];
$stmt->close();

// Récupérer les objectifs de l'unité avec pondération et date de réalisation
$objectives = [];
$sql = "SELECT id, description, ponderation, date_realisation FROM objectif WHERE sructure_entreprise_id = ? AND categorie = 'tache principale'" ;
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $unit_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $objectives[] = $row;
    }
}
$stmt->close();

$conn->close();

echo json_encode(['employees' => $employees, 'objectives' => $objectives]);
?>
