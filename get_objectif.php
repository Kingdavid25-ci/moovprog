<?php
session_start(); // Démarre une nouvelle session ou reprend une session existante

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
    die("Échec de la connexion : " . $conn->connect_error); // Arrête l'exécution du script en cas d'erreur de connexion
}

// Vérifier si la clé 'matricule' existe dans le tableau $_POST
if (isset($_POST['matricule'])) {
    $matricule = $_POST['matricule']; // Récupère la valeur du matricule envoyé via le formulaire

    // Requête SQL pour récupérer les objectifs du salarié sélectionné
    $sql = "SELECT DESCRIBES, INDICATEUR_PERFORMANCE, DATE_DEBUT, DATE_LIMIT_OB, PONDERATION,AUTOEVALUATION,DATE_REALISATION FROM objectif WHERE matricule = ?";
    $stmt = $conn->prepare($sql); // Prépare la requête SQL
    $stmt->bind_param("s", $matricule); // Lie le paramètre matricule à la requête
    $stmt->execute(); // Exécute la requête
    $result = $stmt->get_result(); // Récupère le résultat de la requête

    $objectifs = [];
    while ($row = $result->fetch_assoc()) { // Parcourt chaque ligne du résultat
        $objectifs[] = $row; // Ajoute chaque ligne au tableau des objectifs
    }

    $stmt->close(); // Ferme la requête préparée
} else {
    // Gérer le cas où 'matricule' n'est pas défini
    echo "Veuillez fournir un matricule valide.";
}

// Fermer la connexion à la base de données
$conn->close(); // Ferme la connexion à la base de données

// Afficher les objectifs au format JSON
echo json_encode(['objectifs' => $objectifs]); // Encode le tableau des objectifs en JSON et l'affiche
?>
