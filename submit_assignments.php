<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Paramètres de connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "moovprog";

    // Créer une connexion à la base de données
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // MATRICULE de l'utilisateur connecté
    $MATRICULE = $_SESSION['user_name'];

    // Récupérer les employés et les objectifs
    $employees = json_decode($_POST['employees'], true);
    $objectives = json_decode($_POST['objectives'], true);

    foreach ($employees as $employee) {
        foreach ($objectives as $objective) {
            $id_objectif = $objective['id'];
            $ponderation = $objective['ponderation'];
            $date_realisation = $objective['date_realisation'];

            // Insérer les affectations dans la table evaluation
            $sql = "INSERT INTO evaluation (matricule, id_objectif, ponderation, date_realisation) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $employee, $id_objectif, $ponderation, $date_realisation);
            $stmt->execute();
        }
    }
 echo "<script>alert('objectifs affecté avec succes.'); window.location.href = 'affecter.php';</script>";
    $stmt->close();
    $conn->close();

    
    
}