<?php
header('Content-Type: application/json');
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

// Obtenir le matricule de l'utilisateur
$matricule = $_GET['matricule'] ?? '';

// Initialiser les tableaux pour les données
$tachePrincipale = [];
$performanceQuotidienne = [];
$competence = [];

// Récupérer les données de la Tâche Principale
$sql = "SELECT * FROM evaluation WHERE matricule = ? AND categorie = 'tache_principale'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $tachePrincipale[] = $row;
}

$stmt->close();

// Récupérer les données de la Performance Quotidienne
$sql = "SELECT * FROM evaluation WHERE matricule = ? AND categorie = 'performance_quotidienne'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $performanceQuotidienne[] = $row;
}

$stmt->close();

// Récupérer les données de la Compétence
$sql = "SELECT * FROM evaluation WHERE matricule = ? AND categorie = 'competence'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $competence[] = $row;
}

$stmt->close();
$conn->close();

// Envoyer les données au format JSON
echo json_encode([
    'tachePrincipale' => $tachePrincipale,
    'performanceQuotidienne' => $performanceQuotidienne,
    'competence' => $competence
]);
?>
