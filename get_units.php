<?php
// Configuration de la base de données
$host = 'localhost'; // Remplacez par votre hôte
$dbname = "moovprog";
//$dbname = 'moov_africa_test'; // Nom de votre base de données
$username = 'root'; // Nom d'utilisateur de la base de données
$password = ''; // Mot de passe de la base de données

try {
    // Connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête pour récupérer les unités
    $sql = "SELECT id, nom FROM sructure_entreprise";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Récupérer les résultats
    $units = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Renvoie les données au format JSON
    echo json_encode($units);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
