<?php
session_start();
include('db_connection.php');

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

// MATRICULE de l'utilisateur connecté
$MATRICULE = $_SESSION['user_name'];

// Récupérer les évaluations en attente de validation
$sql = "SELECT * FROM evaluation WHERE statut_evaluation = 'En attente' AND superieur_hierarchique = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Valider les évaluations</title>
<link rel="stylesheet" type="text/css" href="css/body.css">
<link rel="stylesheet" type="text/css" href="css/chrome.css">
</head>
<body>
    <div class="container">
        <h1>Valider les évaluations</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Objectif</th>
                    <th>Pondération</th>
                    <th>Date de réalisation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['matricule']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_objectif']); ?></td>
                        <td><?php echo htmlspecialchars($row['ponderation']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_realisation']); ?></td>
                        <td>
                            <button class="btn btn-success" onclick="validerEvaluation(<?php echo $row['id']; ?>)">Approuver</button>
                            <button class="btn btn-danger" onclick="rejeterEvaluation(<?php echo $row['id']; ?>)">Rejeter</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <button class="btn btn-primary" onclick="validerTout()">Valider tout</button>
    </div>

    <script>
        function validerEvaluation(id) {
            if (confirm('Êtes-vous sûr de vouloir approuver cette évaluation ?')) {
                window.location.href = 'update_statut.php?action=valider&id=' + id;
            }
        }

        function rejeterEvaluation(id) {
            if (confirm('Êtes-vous sûr de vouloir rejeter cette évaluation ?')) {
                window.location.href = 'update_statut.php?action=rejeter&id=' + id;
            }
        }

        function validerTout() {
            if (confirm('Êtes-vous sûr de vouloir approuver toutes les évaluations ?')) {
                window.location.href = 'update_statut.php?action=valider_tout';
            }
        }
    </script>
</body>
</html>
```
<?php
session_start();
include('db_connection.php');

// Vérifier l'action à effectuer
$action = $_GET['action'];

if ($action == 'valider') {
    $id = $_GET['id'];
    $sql = "UPDATE evaluation SET statut_evaluation = 'Validée' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
} elseif ($action == 'rejeter') {
    $id = $_GET['id'];
    $sql = "UPDATE evaluation SET statut_evaluation = 'Rejetée' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
} elseif ($action == 'valider_tout') {
    $MATRICULE = $_SESSION['user_name'];
    $sql = "UPDATE evaluation SET statut_evaluation = 'Validée' WHERE statut_evaluation = 'En attente' AND superieur_hierarchique = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MATRICULE);
    $stmt->execute();
    $stmt->close();
}

echo "L'enregistrement a été sauvegardé.";
$conn->close();
header('Location: valider_evaluation.php');
exit();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Résultat de l'insertion des objectifs</title>
</head>
<body>
    <p><a href="créer_objectif.php">Retour à la page de création des objectifs</a></p>
</body>
</html>
