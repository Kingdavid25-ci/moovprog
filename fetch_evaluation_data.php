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

// Récupérer les objectifs affectés et leurs pondérations
$objectives = [];
foreach ($employees as $employee) {
    $sql = "SELECT o.id, o.description, e.matricule, o.ponderation, o.indicateur_performance, o.date_realisation, e.autoevaluation_objectif
            FROM evaluation e 
            JOIN objectif o ON e.id_objectif = o.id 
            WHERE e.matricule = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $employee['matricule']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $objectives[$employee['matricule']][] = $row;
        }
    }
    $stmt->close();
}

$conn->close();

echo json_encode(['employees' => $employees, 'objectives' => $objectives]);
?>
