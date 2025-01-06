<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Paramètres de connexion à la base de données
  include('db_connection.php');
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

            // Insérer les affectations dans la table `evaluation`
            $sql = "INSERT INTO evaluation (matricule, id_objectif, ponderation, date_realisation) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $employee, $id_objectif, $ponderation, $date_realisation);
            $stmt->execute();
        }
    }

 //   $stmt->close();
    $conn->close();

	echo "objectifs affecté avec succes.";
   exit; 
    
}

