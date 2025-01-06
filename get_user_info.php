<?php
// get_user_info.php

session_start(); // Assurez-vous que la session est démarrée pour obtenir le matricule

// Connexion à la base de données
$host = 'localhost'; // à ajuster si besoin
$dbname = "moovprog";
//$dbname = 'moov_africa_test';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer le matricule de l'utilisateur connecté
    $matricule = $_SESSION['user_name']; // Assurez-vous que la session contient bien le matricule

    // Requête SQL pour récupérer les infos du salarié
    $stmt = $pdo->prepare("SELECT nom, prenom, matricule, sexe, superieur_hierarchique, date_naissance, date_embauche, coefficient, localisation FROM salarie WHERE matricule = :user_name");
    $stmt->bindParam(':matricule', $matricule, PDO::PARAM_STR);
    $stmt->execute();

    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retourner les informations sous forme de JSON
    echo json_encode($user_info);

} catch (PDOException $e) {
    echo 'Échec lors de la connexion : ' . $e->getMessage();
}
?>
