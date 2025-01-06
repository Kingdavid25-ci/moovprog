<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Remplacez par votre nom d'utilisateur MySQL
$password = ""; // Remplacez par votre mot de passe MySQL
//$dbname = "moov_africa_test"; // Remplacez par le nom de votre base de données
$dbname = "moovprog";
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer les valeurs des filtres
$unite = isset($_GET['unite']) ? $_GET['unite'] : '';
$matricule = isset($_GET['matricule']) ? $_GET['matricule'] : '';
$nom = isset($_GET['nom']) ? $_GET['nom'] : '';

// Construire la requête SQL en fonction des filtres appliqués
$sql = "SELECT r.*, u.nom_unite 
        FROM resultat r 
        JOIN unite u ON r.unite_id = u.id 
        WHERE 1=1";

if (!empty($unite)) {
    $sql .= " AND r.unite_id = '" . $conn->real_escape_string($unite) . "'";
}

if (!empty($matricule)) {
    $sql .= " AND r.MATRICULE LIKE '%" . $conn->real_escape_string($matricule) . "%'";
}

if (!empty($nom)) {
    $sql .= " AND r.nom LIKE '%" . $conn->real_escape_string($nom) . "%'";
}

// Exécuter la requête
$result = $conn->query($sql);

$resultats = array();

if ($result->num_rows > 0) {
    // Ajouter les résultats dans un tableau
    while($row = $result->fetch_assoc()) {
        $resultats[] = $row;
    }
}

// Renvoyer les résultats sous forme de JSON
header('Content-Type: application/json');
echo json_encode($resultats);

$conn->close();
?>
