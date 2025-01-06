<?php
session_start(); // Démarrer la session

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

// Vérifier si la clé 'matricule' existe dans le tableau $_POST
if (isset($_POST['matricule'])) {
    $matricule = $_POST['matricule']; // Récupère la valeur du matricule envoyé via le formulaire
    
    // Requête SQL pour récupérer les évaluations du subordonné sélectionné
    $sql = "SELECT DESCRIBES, INDICATEUR_PERFORMANCE, DATE_DEBUT, DATE_LIMIT_OB, PONDERATION, NOTE_N1 FROM objectif WHERE matricule = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricule);
    $stmt->execute();
    $result = $stmt->get_result();

    $evaluations = [];
    // Boucle pour récupérer chaque ligne de résultat et l'ajouter au tableau des évaluations
    while ($row = $result->fetch_assoc()) {
        $evaluations[] = $row;
    }

    $stmt->close();

    // Afficher les évaluations au format JSON
    echo json_encode(['objectifs' => $evaluations]);
} else {
    echo json_encode(['error' => 'Matricule non fourni.']);
}

// Fermer la connexion à la base de données
$conn->close();
?>
