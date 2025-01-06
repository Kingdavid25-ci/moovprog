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
        
        $sql = "SELECT sa.MATRICULE, o.description, o.indicateur_performance, ev.ponderation, ev.date_realisation, o.categorie, s.nom AS nom_unite, ev.autoevaluation_objectif, ev.note_objectif            FROM evaluation ev
                INNER JOIN objectif o ON ev.ID_OBJECTIF = o.id
                INNER JOIN salarie sa ON ev.MATRICULE = sa.MATRICULE
                LEFT JOIN sructure_entreprise s ON o.sructure_entreprise_id = s.id
                WHERE (o.categorie = ? OR ? = '')
                AND (s.id = ? OR ? = '')";

        break;

    case 'performance quotidienne':
        $sql = "SELECT sa.MATRICULE, o.description, o.ponderation, ev.AUTO_EVALUATION_PERFORM, ev.note_evaluateur,o.categorie, s.nom AS nom_unite
                FROM evaluation ev
                INNER JOIN objectif o ON ev.ID_OBJECTIF = o.id
                INNER JOIN salarie sa ON ev.MATRICULE = sa.MATRICULE
                LEFT JOIN sructure_entreprise s ON o.sructure_entreprise_id = s.id
                WHERE (o.categorie = ? OR ? = '')
                AND (s.id = ? OR ? = '')";
        break;

    case 'competence ':
        $sql = "SELECT sa.MATRICULE, o.description, o.niveau_requis, ev.niveau_capacite, ev.commentaire, ev.capacite_lacune,o.categorie, s.nom AS nom_unite
                FROM evaluation ev
                INNER JOIN objectif o ON ev.ID_OBJECTIF = o.id
                INNER JOIN salarie sa ON ev.MATRICULE = sa.MATRICULE
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
