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
$sql = "SELECT o.id, o.description, o.indicateur_performance, e.ponderation, e.autoevaluation_objectif, e.note_objectif FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'tache principale'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $tachePrincipale[] = $row;
}

$stmt->close();

// Récupérer les données de la Performance Quotidienne
$sql = "SELECT o.id, o.description, o.ponderation, e.AUTO_EVALUATION_PERFORM,e.NOTE_EVALUATEUR FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'performance quotidienne'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $performanceQuotidienne[] = $row;
}

$stmt->close();

// Récupérer les données de la Compétence
$sql = "SELECT o.id, o.description, o.niveau_requis, e.AUTO_EVALUATION_PERFORM,e.COMMENTAIRE, e.niveau_capacite FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'competence '";
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
