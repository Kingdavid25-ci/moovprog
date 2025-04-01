<?php
session_start();
include('db_connection.php');

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

// Récupérer le matricule du salarié à partir de l'URL
$matricule = $_GET['matricule'];

// Récupérer les informations du salarié
$sql = "SELECT s.nom, s.prenom, s.fonction_actuelle, 
        CONCAT(eval.nom, ' ', eval.prenom) as evaluateur
        FROM salarie s 
        LEFT JOIN affectation a ON s.superieur_hierarchique = a.id_poste
        LEFT JOIN salarie eval ON a.matricule = eval.matricule
        WHERE s.matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$stmt->bind_result($nom, $prenom, $fonction, $evaluateur);
$stmt->fetch();
$stmt->close();

// Vérifier si les variables sont NULL et leur attribuer une valeur par défaut
$nom = $nom ?? '';
$prenom = $prenom ?? '';
$fonction = $fonction ?? '';
$evaluateur = $evaluateur ?? 'Non assigné';

// Récupérer les évaluations du salarié
$sql = "SELECT e.id_objectif, e.ponderation, e.date_realisation, e.NOTE_EVALUATEUR, o.description 
        FROM evaluation e 
        JOIN objectif o ON e.id_objectif = o.id 
        WHERE e.matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Détails de l'Évaluation</title>
<link rel="stylesheet" type="text/css" href="css/body.css">
<link rel="stylesheet" type="text/css" href="css/chrome.css">
<link rel="stylesheet" type="text/css" href="third-party/bootstrap/bootstrap-3.3.6-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="third-party/font-awesome/font-awesome-4.5.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<style>
.signature-pad {
    border: 1px solid #000;
    border-radius: 5px;
}
.signature-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
    margin-bottom: 20px;
}
.comments-section {
    flex: 1;
}
.signature-section {
    flex: 1;
}
.form-group {
    margin-bottom: 15px;
}
</style>
</head>
<body>
    <div class="container">
        <h1>Détails de l'Évaluation</h1>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Mon Application</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="main.php">Accueil</a></li>
                    <li><a href="index.php">Déconnexion</a></li>
                </ul>
            </div>
        </nav>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Informations sur le salarié</h3>
            </div>
            <div class="panel-body">
                <p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
                <p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom); ?></p>
                <p><strong>Fonction actuelle :</strong> <?php echo htmlspecialchars($fonction); ?></p>
                <p><strong>Évaluateur du salarié :</strong> <?php echo htmlspecialchars($evaluateur); ?></p>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Évaluations</h3>
            </div>
            <div class="panel-body">
                <form id="evaluationForm" action="approve_evaluations.php" method="post" onsubmit="return validateForm()">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Objectif</th>
                                <th>Pondération</th>
                                <th>Date de réalisation</th>
                                <th>Note de l'Évaluateur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                                    <td><?php echo htmlspecialchars($row['ponderation']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_realisation']); ?></td>
                                    <td><input type="text" name="NOTE_EVALUATEUR[]" value="<?php echo htmlspecialchars($row['NOTE_EVALUATEUR']); ?>" class="form-control" readonly></td>
                                    <input type="hidden" name="id_objectif[]" value="<?php echo htmlspecialchars($row['id_objectif']); ?>" />
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="enableEditing(this)">Modifier</button>
                                        <button type="button" class="btn btn-success btn-sm" style="display:none;" onclick="saveChanges(this)">Enregistrer</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <div class="signature-container">
                        <div class="comments-section">
                            <div class="form-group">
                                <label for="commentaires">Commentaires :</label>
                                <textarea name="commentaires" id="commentaires" class="form-control" rows="4" readonly></textarea>
                                <button type="button" class="btn btn-primary btn-sm" onclick="enableCommentEditing()">Modifier Commentaires</button>
                                <button type="button" class="btn btn-success btn-sm" style="display:none;" onclick="saveCommentChanges()">Enregistrer Commentaires</button>
                            </div>
                        </div>
                        <div class="signature-section">
                            <div class="form-group">
                                <label for="signature">Signature :</label>
                                <canvas id="signature-pad" class="signature-pad" width="400" height="200"></canvas>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-secondary" onclick="clearSignature()">Effacer</button>
                                </div>
                                <input type="hidden" name="signature" id="signature">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="commentaires_hidden" id="commentaires_hidden">
                    <button type="submit" class="btn btn-success">Approuver toutes les évaluations</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        function enableEditing(button) {
            const row = button.closest('tr');
            const noteInput = row.querySelector('input[name="NOTE_EVALUATEUR[]"]');
            const saveButton = row.querySelector('button.btn-success');
            noteInput.removeAttribute('readonly');
            noteInput.classList.add('editable');
            saveButton.style.display = 'inline';
            button.style.display = 'none';
        }

        function saveChanges(button) {
            const row = button.closest('tr');
            const noteInput = row.querySelector('input[name="NOTE_EVALUATEUR[]"]');
            noteInput.setAttribute('readonly', 'readonly');
            noteInput.classList.remove('editable');
            button.style.display = 'none';
            const modifyButton = row.querySelector('button.btn-primary');
            modifyButton.style.display = 'inline';
        }

        function enableCommentEditing() {
            const commentInput = document.getElementById('commentaires');
            const saveButton = document.querySelector('button[onclick="saveCommentChanges()"]');
            commentInput.removeAttribute('readonly');
            commentInput.classList.add('editable');
            saveButton.style.display = 'inline';
            document.querySelector('button[onclick="enableCommentEditing()"]').style.display = 'none';
        }

        function saveCommentChanges() {
            const commentInput = document.getElementById('commentaires');
            commentInput.setAttribute('readonly', 'readonly');
            commentInput.classList.remove('editable');
            document.querySelector('button[onclick="saveCommentChanges()"]').style.display = 'none';
            document.querySelector('button[onclick="enableCommentEditing()"]').style.display = 'inline';
            document.getElementById('commentaires_hidden').value = commentInput.value;
        }

        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        function clearSignature() {
            signaturePad.clear();
        }

        function validateForm() {
            const noteInputs = document.querySelectorAll('input[name="NOTE_EVALUATEUR[]"]');
            for (let i = 0; i < noteInputs.length; i++) {
                if (isNaN(noteInputs[i].value) || noteInputs[i].value.trim() === '') {
                    alert('Veuillez remplir les valeurs du champ Note de l\'Évaluateur avec des valeurs numériques.');
                    return false;
                }
            }

            if (signaturePad.isEmpty()) {
                alert('Veuillez fournir une signature.');
                return false;
            }

            document.getElementById('commentaires_hidden').value = document.getElementById('commentaires').value;
            document.getElementById('signature').value = signaturePad.toDataURL();
            return true;
        }
    </script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>