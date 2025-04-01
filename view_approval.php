<?php
session_start();
include('db_connection.php');

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

// Vérifier que l'ID de l'objectif est défini dans l'URL
if (!isset($_GET['id_objectif'])) {
    die("Erreur : ID de l'objectif non défini.");
}

// Récupérer l'ID de l'objectif à partir de l'URL
$id_objectif = intval($_GET['id_objectif']);

// Récupérer les informations de l'approbation
$sql = "SELECT e.id_objectif, e.ponderation, e.date_realisation, e.NOTE_EVALUATEUR, o.description, e.commentaires, e.signature, e.approbateur 
        FROM evaluation e 
        JOIN objectif o ON e.id_objectif = o.id 
        WHERE e.id_objectif = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_objectif);
$stmt->execute();
$stmt->bind_result($id_objectif, $ponderation, $date_realisation, $note_evaluateur, $description, $commentaires, $signature, $approbateur);
$stmt->fetch();
$stmt->close();

// Assigner des valeurs par défaut si les variables sont nulles
$description = $description ?? '';
$ponderation = $ponderation ?? '';
$date_realisation = $date_realisation ?? '';
$note_evaluateur = $note_evaluateur ?? '';
$commentaires = $commentaires ?? '';
$signature = $signature ?? '';
$approbateur = $approbateur ?? '';
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Détails de l'Approbation</title>
<link rel="stylesheet" type="text/css" href="css/body.css">
<link rel="stylesheet" type="text/css" href="css/chrome.css">
<link rel="stylesheet" type="text/css" href="third-party/bootstrap/bootstrap-3.3.6-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="third-party/font-awesome/font-awesome-4.5.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container">
        <h1>Détails de l'Approbation</h1>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Mon Application</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="main.php">Accueil</a></li>
                    <li><a href="login.php">Déconnexion</a></li>
                </ul>
            </div>
        </nav>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Informations sur l'Approbation</h3>
            </div>
            <div class="panel-body">
                <p><strong>Objectif :</strong> <?php echo htmlspecialchars($description); ?></p>
                <p><strong>Pondération :</strong> <?php echo htmlspecialchars($ponderation); ?></p>
                <p><strong>Date de réalisation :</strong> <?php echo htmlspecialchars($date_realisation); ?></p>
                <p><strong>Note de l'Évaluateur :</strong> <?php echo htmlspecialchars($note_evaluateur); ?></p>
                <p><strong>Commentaires :</strong> <?php echo htmlspecialchars($commentaires); ?></p>
                <p><strong>Approuvé par :</strong> <?php echo htmlspecialchars($approbateur); ?></p>
                <p><strong>Signature :</strong></p>
                <img src="<?php echo htmlspecialchars($signature); ?>" alt="Signature" style="width: 200px; height: auto;">
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>