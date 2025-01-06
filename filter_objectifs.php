<?php
$servername = "localhost";
$username = "root";
$password = "";
//$dbname = "moov_africa_test";
$dbname = "moovprog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

$categorie = $_GET['categorie'] ?? '';
$unite = $_GET['unite'] ?? '';

$sql = "";

switch ($categorie) {
    case 'tache principale':
        
        $sql = "SELECT o.id, o.description, o.indicateur_performance, o.ponderation, o.categorie, s.nom AS nom_unite 
        FROM objectif o
        LEFT JOIN sructure_entreprise s ON o.sructure_entreprise_id = s.id
        WHERE (o.categorie = ? OR ? = '')
        AND (s.id = ? OR ? = '')";
        break;

    case 'performance quotidienne':
        $sql = "SELECT o.id, o.description, o.ponderation, o.categorie, s.nom AS nom_unite
                FROM objectif o
                
                LEFT JOIN sructure_entreprise s ON o.sructure_entreprise_id = s.id
                WHERE (o.categorie = ? OR ? = '')
                AND (s.id = ? OR ? = '')";
        break;

    case 'competence ':
        $sql = "SELECT o.id, o.description, o.niveau_requis, o.ponderation, o.categorie, s.nom AS nom_unite 
        FROM objectif o
        LEFT JOIN sructure_entreprise s ON o.sructure_entreprise_id = s.id
        WHERE (o.categorie = ? OR ? = '')
        AND (s.id = ? OR ? = '')";
        break;
    
    default:
        die("Catégorie invalide sélectionnée.");
}

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erreur lors de la préparation: " . $conn->error);
}

$stmt->bind_param('ssss', $categorie, $categorie, $unite, $unite);
$stmt->execute();

if ($stmt->error) {
    die("Erreur d'exécution: " . $stmt->error);
}

$result = $stmt->get_result();

$evaluations = [];
while ($row = $result->fetch_assoc()) {
    $evaluations[] = $row;
}

echo json_encode($evaluations);

$conn->close();
?>
