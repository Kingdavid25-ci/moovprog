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

// Récupérer l'ID du poste de l'utilisateur connecté
$sql = "SELECT id_poste FROM affectation WHERE matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$user_poste_id = $row['id_poste'];
$stmt->close();

// Vérifier si l'ID du poste a bien été trouvé
if (!$user_poste_id) {
    die(json_encode(["error" => "ID du poste non trouvé pour l'utilisateur connecté."]));
}

// Récupérer les employés sous le superviseur en se basant sur son poste
$employees = [];
$sql = "SELECT matricule, nom, prenom FROM salarie WHERE superieur_hierarchique = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_poste_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
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
$sql = "SELECT id, description, ponderation, date_realisation FROM objectif WHERE sructure_entreprise_id = ? AND categorie = 'tache principale'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $unit_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $objectives[] = $row;
    }
}
$stmt->close();

$conn->close();

echo json_encode(['employees' => $employees, 'objectives' => $objectives]);
?>