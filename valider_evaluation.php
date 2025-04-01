<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

// MATRICULE de l'utilisateur connecté
$MATRICULE = $_SESSION['user_name'];

// Vérifier si le matricule de l'utilisateur connecté existe dans la table salarie
$sql = "SELECT COUNT(*) as total FROM salarie WHERE matricule = ?";
$stmt_check = $conn->prepare($sql);
$stmt_check->bind_param("s", $MATRICULE);
$stmt_check->execute();
$stmt_check->bind_result($total);
$stmt_check->fetch();
$stmt_check->close();

if ($total == 0) {
    echo "<script>alert('Matricule incorrect. Veuillez vérifier vos informations de connexion.'); window.location.href = 'login.php';</script>";
    $conn->close();
    exit();
}

// Récupérer l'ID du poste de l'utilisateur connecté depuis la table affectation
$sql = "SELECT id_poste FROM affectation WHERE matricule = ?";
$stmt_poste = $conn->prepare($sql);
$stmt_poste->bind_param("s", $MATRICULE);
$stmt_poste->execute();
$stmt_poste->bind_result($id_poste);
$stmt_poste->fetch();
$stmt_poste->close();

if (!$id_poste) {
    die("Erreur : ID du poste non trouvé pour l'utilisateur connecté.");
}

// Récupérer les évaluations faites sur les collaborateurs
$sql = "SELECT e.id_objectif, e.ponderation, e.date_realisation, e.NOTE_EVALUATEUR, o.description 
        FROM evaluation e 
        JOIN objectif o ON e.id_objectif = o.id 
        JOIN salarie s ON e.matricule = s.matricule
        JOIN affectation a ON s.matricule = a.matricule
        WHERE s.superieur_hierarchique = ?";
$stmt_eval = $conn->prepare($sql);
$stmt_eval->bind_param("i", $id_poste);
$stmt_eval->execute();
$result = $stmt_eval->get_result();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Validation de l'Évaluation</title>
<link rel="stylesheet" type="text/css" href="css/body.css">
<link rel="stylesheet" type="text/css" href="css/chrome.css">
<link rel="stylesheet" type="text/css" href="third-party/bootstrap/bootstrap-3.3.6-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="third-party/font-awesome/font-awesome-4.5.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<style>
#toggleSubordinates {
    display: block;
    visibility: visible;
    opacity: 1;
}
.signature-pad {
    border: 1px solid #000;
    border-radius: 5px;
}
.button-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
</style>
</head>
<body>
    <div class="container">
        <h1>Validation de l'Évaluation</h1>
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
        <div class="button-container">
            <button id="toggleSubordinates" class="btn btn-primary">Cliquez ici pour voir vos subordonnés</button>
            <a href="view_approval.php" class="btn btn-info">Voir l'approbation</a>
        </div>
        <div id="subordinatesTable" style="display: none;">
            <?php include('liste_subordonnes.php'); ?>
        </div>
        <form action="process_evaluations.php" method="post" onsubmit="return submitForm()">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Objectif</th>
                        <th>Pondération</th>
                        <th>Note de l'Évaluateur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['description'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['ponderation'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($row['NOTE_EVALUATEUR'] ?? ''); ?></td>
                            <td>
                                <button type="submit" name="action" value="approve_<?php echo $row['id_objectif']; ?>" class="btn btn-success btn-sm">Approuver</button>
                                <button type="submit" name="action" value="reject_<?php echo $row['id_objectif']; ?>" class="btn btn-danger btn-sm">Rejeter</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="form-group">
                <label for="signature">Signature :</label>
                <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                <button type="button" class="btn btn-secondary" onclick="clearSignature()">Effacer</button>
            </div>
            <input type="hidden" name="signature" id="signature">
            <button type="submit" name="action" value="approve_all" class="btn btn-primary">Valider toutes les évaluations</button>
        </form>
    </div>

    <script>
    document.getElementById('toggleSubordinates').addEventListener('click', function() {
        const table = document.getElementById('subordinatesTable');
        table.style.display = (table.style.display === 'none') ? 'block' : 'none';
    });

    var canvas = document.getElementById('signature-pad');
    var signaturePad = new SignaturePad(canvas);

    function clearSignature() {
        signaturePad.clear();
    }

    function submitForm() {
        if (signaturePad.isEmpty()) {
            alert("Veuillez fournir une signature.");
            return false;
        } else {
            var dataURL = signaturePad.toDataURL();
            document.getElementById('signature').value = dataURL;
            return true;
        }
    }
    </script>
</body>
</html>

<?php
if ($stmt_eval) {
    $stmt_eval->close();
}
$conn->close();
?>