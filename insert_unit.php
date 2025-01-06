<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
//$dbname = "moov_africa_test";
$dbname = "moovprog";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

$unit_name = isset($_POST['unit_name'])?$_POST['unit_name'] : '';
$unit_type = isset($_POST['unit_type'])?$_POST['unit_type']:'';
$parent_unit= isset($_POST['parent_unit'])?$_POST['parent_unit']:'';


$sql = "INSERT INTO sructure_entreprise (nom, type, parent_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $unit_name, $unit_type, $parent_unit);
$stmt->execute();

$stmt->close();
$conn->close();
?>
