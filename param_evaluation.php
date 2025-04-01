<?php
session_start();

// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
//$dbname = "moov_africa_test";
$dbname = "moovprog";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// MATRICULE de l'utilisateur connecté
$MATRICULE = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';

// Vérifier la fonction de l'utilisateur
$sql = "SELECT fonction_actuelle FROM salarie WHERE matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$is_dsi = false;

if ($user_data && $user_data['fonction_actuelle'] === 'Directeur Général de Moov Côte d’Ivoire') {
    $is_dsi = true;
}

// Afficher le matricule du salarié connecté
// echo "<p>Matricule du salarié connecté : " . htmlspecialchars($MATRICULE) . "</p>";

// Vérifier si le matricule du salarié connecté est correct
$sql = "SELECT COUNT(*) as total FROM salarie WHERE matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

if ($total == 0) {
    // Si le matricule n'existe pas, afficher un message d'erreur et arrêter l'exécution
    echo "<script>alert('Matricule incorrect. Veuillez vérifier vos informations de connexion.'); window.location.href = 'login.php';</script>";
    $conn->close();
    exit();
}

// Vérifier si le matricule est un supérieur hiérarchique
$sql = "SELECT COUNT(*) as total FROM salarie WHERE superieur_hierarchique = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$stmt->bind_result($total);
$stmt->fetch();
$stmt->close();

if ($total > 0) {
    // Si le matricule est trouvé comme supérieur hiérarchique
    //echo "<p>Trouvé : Le matricule est un supérieur hiérarchique.</p>";
} else {
    // Si le matricule n'est pas trouvé comme supérieur hiérarchique
    // echo "<p>Non trouvé : Le matricule n'est pas un supérieur hiérarchique.</p>";
}

// Récupérer toutes les unités organisationnelles
$units = [];
$sql = "SELECT id, nom FROM sructure_entreprise";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $units[] = $row;
    }
}

// Vérifier l'authentification de l'utilisateur
if ($MATRICULE) {
    // Récupérer l'unité de l'utilisateur connecté
    $sql = "SELECT unit_id FROM salarie WHERE matricule = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $MATRICULE);
    $stmt->execute();
    $stmt->bind_result($user_unit_id);
    $stmt->fetch();
    $stmt->close();

    if ($user_unit_id) {
        // Récupérer les objectifs des différentes catégories filtrés par l'unité de l'utilisateur connecté

        // Récupérer les objectifs de performance quotidienne
        $sql = "SELECT id, description, ponderation, statut FROM objectif WHERE categorie = 'performance quotidienne' AND sructure_entreprise_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_unit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $dailyPerformanceObjectives = [];
        while ($row = $result->fetch_assoc()) {
            $dailyPerformanceObjectives[] = $row;
        }

        // Récupérer les compétences
        $sql = "SELECT id, description, niveau_requis, statut FROM objectif WHERE categorie = 'competence ' AND sructure_entreprise_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_unit_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $competenceObjectives = [];
        while ($row = $result->fetch_assoc()) {
            $competenceObjectives[] = $row;
        }
    } else {
        // Gérer le cas où l'unité de l'utilisateur n'est pas trouvée
        echo "Unité de l'utilisateur non trouvée.";
        exit();
    }
} else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas authentifié
    header("Location: login.php");
    exit();
}

// Vérifier si le salarié connecté a des objectifs affectés
$sql = "SELECT COUNT(*) as count FROM evaluation WHERE MATRICULE = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $MATRICULE);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $objectivesCount = $row['count'];
}

$conn->close();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Évaluation des performances</title>
<link rel="icon" type="image/png" href="images/logo48.png" />
<link rel="stylesheet" type="text/css" href="css/body.css">
<link rel="stylesheet" type="text/css" href="css/chrome.css">
<link rel="stylesheet" type="text/css" href="third-party/bootstrap/bootstrap-3.3.6-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="third-party/font-awesome/font-awesome-4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-cookies.min.js"></script>
<script type="text/javascript" src="third-party/bootstrap/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="third-party/bootstrap/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script src="js/menu.js"></script>
<link rel="icon" type="image/png" href="images/logo48.png" />
<link rel="stylesheet" type="text/css" href="css/body.css">
<link rel="stylesheet" type="text/css" href="css/chrome.css">
<link rel="stylesheet" type="text/css" href="third-party/bootstrap/bootstrap-3.3.6-dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="third-party/font-awesome/font-awesome-4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script type="text/javascript" src="third-party/jQuery/jquery-2.2.1.min.js"></script>
<script type="text/javascript" src="third-party/jQuery/jquery.cookie-1.4.1.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-animate.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-route.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-touch.min.js"></script>
<script type="text/javascript" src="third-party/angularjs/angular-1.5.0/angular-cookies.min.js"></script>
<script type="text/javascript" src="third-party/bootstrap/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/config.js"></script>
<script type="text/javascript" src="js/app.js"></script>
<script type="text/javascript" src="js/directive.js"></script>
<script type="text/javascript" src="js/service.js"></script>
<script type="text/javascript" src="third-party/angularjs-ui/UI-Bootstrap/ui-bootstrap-tpls-1.3.2.js"></script>
<script type="text/javascript" src="third-party/Blob.js-master/Blob.js"></script>
<script type="text/javascript" src="third-party/FileSaver.js/FileSaver.js-1.3.2/FileSaver.min.js"></script>
<script src="third-party/ng-file-upload-12.2.12/demo/src/main/webapp/js/ng-file-upload-shim.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<style type="text/css">
/*  CSS styles */
.section {
    display: none;
}

.section.active {
    display: block;
}
  
@font-face {
  font-family: 'Material Icons';
  font-style: normal;
  font-weight: 400;
  src: url('third-party/material-design-icons/iconfont/MaterialIcons-Regular.eot'); /* For IE6-8 */
  src: local('Material Icons'),
       local('MaterialIcons-Regular'),
       url('third-party/material-design-icons/iconfont/MaterialIcons-Regular.woff2') format('woff2'),
       url('third-party/material-design-icons/iconfont/MaterialIcons-Regular.woff') format('woff'),
       url('third-party/material-design-icons/iconfont/MaterialIcons-Regular.ttf') format('truetype');
}
.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;  /* Preferred icon size */
  display: inline-block;
  line-height: 1;
  text-transform: none;
  letter-spacing: normal;
  word-wrap: normal;
  white-space: nowrap;
  direction: ltr;
  -webkit-font-smoothing: antialiased;
  text-rendering: optimizeLegibility;
  -moz-osx-font-smoothing: grayscale;
  font-feature-settings: 'liga';
}
.menu-btn {
    max-width: 120px;
    box-sizing: content-box;
    overflow: hidden;
}
.menu-btn img {
    width: 100%;
}
.menu-btn h5 {
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    padding: 0px;
    margin: 0px;
}
.carousel-inner > .item > img {
    width:100%;
    height:500px;
}
</style>
<script>
// jQuery
$(function() {
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){
        window.location.hash = hash;
      });
    }
  });
});

function checkObjectives() {
    <?php if ($is_dsi): ?>
        return true; // Le DSI a toujours accès
    <?php else: ?>
        <?php if ($objectivesCount == 0): ?>
            alert('Veuillez contacter vos supérieurs hiérarchiques pour définir vos objectifs s\'il vous plaît.');
            return false;
        <?php endif; ?>
    <?php endif; ?>
    return true;
}

function nextSection(sectionNumber) {
    if (checkObjectives()) {
        document.querySelectorAll('.section').forEach(section => {
            section.classList.remove('active');
        });
        document.getElementById('section' + sectionNumber).classList.add('active');
    }
}

function previousSection(sectionNumber) {
    if (checkObjectives()) {
        document.querySelectorAll('.section').forEach(section => {
            section.classList.remove('active');
        });
        document.getElementById('section' + sectionNumber).classList.add('active');
    }
}

function addObjective() {
    if (checkObjectives()) {
        // Ajout d'un nouvel objectif
        var description = document.getElementById('objectiveDescription').value;
        var performanceIndicator = document.getElementById('performanceIndicator').value;
        var weighting = document.getElementById('objectiveWeighting').value;

        if (description && performanceIndicator && weighting) {
            var table = document.getElementById('transversalObjectivesTable').getElementsByTagName('tbody')[0];
            var newRow = table.insertRow();
            var descriptionCell = newRow.insertCell(0);
            var performanceIndicatorCell = newRow.insertCell(1);
            var weightingCell = newRow.insertCell(2);
            var statusCell = newRow.insertCell(3);
            var updateCell = newRow.insertCell(4);
            var deleteCell = newRow.insertCell(5);

            descriptionCell.innerHTML = description;
            performanceIndicatorCell.innerHTML = performanceIndicator;
            weightingCell.innerHTML = weighting;
            statusCell.innerHTML = '<select class="form-control"><option value="Actif">Actif</option><option value="Inactif">Inactif</option></select>';
            updateCell.innerHTML = '<button class="btn btn-warning" onclick="updateObjective(this)">Modifier</button>';
            deleteCell.innerHTML = '<button class="btn btn-danger" onclick="deleteObjective(this)">Supprimer</button>';

            // Réinitialiser le formulaire
            document.getElementById('addObjectiveForm').reset();
        } else {
            alert('Veuillez remplir tous les champs.');
        }
    }
}

function saveTransversalObjectives() {
    if (checkObjectives()) {
        var table = document.getElementById('transversalObjectivesTable');
        var totalWeighting = 0;
        for (var i = 1; i < table.rows.length; i++) {
            totalWeighting += parseInt(table.rows[i].cells[2].innerHTML);
        }
        if (totalWeighting === 100) {
            // Collect the objectives data
            var objectives = [];
            for (var i = 1; i < table.rows.length; i++) {
                var row = table.rows[i];
                var objective = {
                    description: row.cells[0].innerHTML,
                    performanceIndicator: row.cells[1].innerHTML,
                    weighting: row.cells[2].innerHTML,
                    status: row.cells[3].querySelector('select').value
                };
                objectives.push(objective);
            }

            // Send the data via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_transversal_objectives.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    var response = JSON.parse(xhr.responseText);
                    alert(response.message);
                }
            };
            xhr.send(JSON.stringify({objectives: objectives, category: 'tache principale'}));
        } else {
            alert('La somme des pondérations doit être égale à 100%. Actuelle : ' + totalWeighting + '%.');
        }
    }
}

function saveDailyPerformance() {
    <?php if ($is_dsi): ?>
        // Pour le DSI, pas de vérification de la somme des pondérations
        var form = document.getElementById('dailyPerformanceForm');
        var formData = new FormData(form);
        // ... reste du code de sauvegarde ...
    <?php else: ?>
        if (checkObjectives()) {
            var form = document.getElementById('dailyPerformanceForm');
            var formData = new FormData(form);
            var totalWeighting = 0;

            // Calculer la somme des pondérations
            formData.forEach((value, key) => {
                if (key === 'ponderation') {
                    totalWeighting += parseInt(value);
                }
            });

            if (totalWeighting === 100) {
                // Récupérer les données des performances
                var performances = [];
                form.querySelectorAll('tbody tr').forEach(row => {
                    var performance = {
                        description: row.cells[0].innerHTML,
                        weighting: row.cells[1].querySelector('input').value,
                        status: row.cells[2].querySelector('select').value
                    };
                    performances.push(performance);
                });

                // Afficher les données à envoyer dans la console pour vérification
                console.log("Performances to send:", performances);

                // Envoyer les données via AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_daily_performances.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        console.log("Response from save_daily_performances.php:", xhr.responseText);
                        var response = JSON.parse(xhr.responseText);
                        alert(response.message);

                        // Envoyer les données à assign_daily_performances.php après avoir enregistré les performances
                        sendData(performances);
                    }
                };
                xhr.send(JSON.stringify({ performances: performances }));
            } else {
                alert('La somme des pondérations doit être égale à 100%. Actuelle : ' + totalWeighting + '%.');
            }
        }
    <?php endif; ?>
}

function savecompetence() {
    <?php if ($is_dsi): ?>
        // Pour le DSI, accès direct à la sauvegarde
        var form = document.getElementById('competenceForm');
        var formData = new FormData(form);
        // ... reste du code de sauvegarde ...
    <?php else: ?>
        if (checkObjectives()) {
            var form = document.getElementById('competenceForm');
            var formData = new FormData(form);

            // Récupérer les données des competences
            var competences = [];
            form.querySelectorAll('tbody tr').forEach(row => {
                var competence = {
                    description: row.cells[0].innerHTML,
                    niveau_requis: row.cells[1].querySelector('input').value,
                    status: row.cells[2].querySelector('select').value
                };
                competences.push(competence);
            });

            // Afficher les données à envoyer dans la console pour vérification
            console.log("Data to send to save_competence.php:", JSON.stringify({ competences: competences }));

            // Envoyer les données via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'save_competence.php', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    console.log("Response from save_competence.php:", xhr.responseText);
                    var response = JSON.parse(xhr.responseText);
                    alert(response.message);

                    // Envoyer les données à assign_competences.php après avoir enregistré les competence
                    sendData(competences);
                }
            };
            xhr.send(JSON.stringify({ competences: competences }));
        }
    <?php endif; ?>
}
</script>
</head>

<body ng-app="myApp">
<div id="top">
  <div id="topBar"></div>
</div>
<nav class="navbar navbar-default" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Evaluation moov-africa</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav" id="bs-example-navbar-collapse-1">
      <li><a href="main.php">Accueil <span class="fa fa-home fa-lg ms-2"></span></a></li>
      <li class="dropdown menu-admin">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestion des évaluations <span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li class="menu-admin"><a href="DirectionRH.php">Direction RH</a></li> 
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Superieur n+1</li>
            <li class="menu-admin"><a href="param_evaluation.php">Gestion des paramètres</a></li>
            <li class="menu-admin"><a href="affecter.php">Affecter des objectifs</a></li>
            
          </ul>
        </li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestion des performances<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="dropdown-header">Details de la gestion</li>
            <li class="menu-admin"><a href="autoevaluation.php">Autoevaluation</a></li>
            <li><a href="evaluation31.php">Evaluer un collaborateur</a></li>
            <li><a href="modifier31.php">Modifier une evaluation</a></li>
            <li><a href="valider_evaluation.php">Valider une evaluation</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Rapport</li>
            <li><a href="">Rapport individuel</a></li>
            <li><a href="">Rapport collectif</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Reclamation</li>
            <li><a href="reclamation.php">Faire une reclamation</a></li>
          </ul>
        </li>
       
      </ul>
      <ul class="nav navbar-nav navbar-right">
    <li><a href="mes_infos.php">Mes infos <span class="fa fa-user fa-lg me-2"></span></a></li>
    <li><a href="index.php">Se déconnecter <span class="fa fa-sign-out fa-lg me-2"></span></a></li>
</ul>

    </div>
  </div>
</nav>


    <div class="container">
        <h1>Gestion des paramètres</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main.php">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestion des évaluations</li>
                <li class="breadcrumb-item active" aria-current="page">Gestion des paramètres</li>
            </ol>
        </nav>
       
        
        <!-- Section 1: Création des objectifs transversaux -->
        
        <div id="section1" class="section active">
        <div class="form-group">
            <h4>Définissez des objectifs pour vos collaborateurs</h4>
            <?php if (!$is_dsi): ?>
                <?php if ($objectivesCount > 0): ?>
                    <div class="form-group">
                        <h5>Voici vos objectifs :</h5>
                        <button class="btn btn-info" onclick="toggleObjectives()">Afficher/Masquer les objectifs</button>
                        <div id="objectives-container" style="max-height: 400px; overflow-y: auto; display: none;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Indicateur de performance</th>
                                        <th>Pondération</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Récupérer les objectifs affectés au salarié connecté
                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    $sql = "SELECT o.description, o.indicateur_performance, e.ponderation, o.statut FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.matricule = ?";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bind_param("s", $MATRICULE);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while ($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                                            <td><?php echo htmlspecialchars($row['indicateur_performance']); ?></td>
                                            <td><?php echo htmlspecialchars($row['ponderation']); ?></td>
                                            <td><?php echo htmlspecialchars($row['statut']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Vous n'avez pas d'objectifs.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

            <div id="objective-container" class="container">
                <form id="addObjectiveForm" class="form-inline">
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" id="objectiveDescription" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Indicateur de performance</label>
                        <input type="text" id="performanceIndicator" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Pondération</label>
                        <input type="number" id="objectiveWeighting" class="form-control" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addObjective()">Ajouter</button>
                </form>
                <br>
                <table class="table table-bordered" id="transversalObjectivesTable">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Indicateur de performance</th>
                            <th>Pondération</th>
                            <th>etat</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="navigation-buttons">
                <button class="btn btn-primary" onclick="saveTransversalObjectives()">Enregistrer</button>

                    <button class="btn btn-primary" onclick="nextSection(2)">Suivant</button>
                </div>
            </div>
        </div>

        <!-- Section 2: Performances Quotidiennes -->
        <div id="section2" class="section">
        <div class="form-group">
            <h4>Validez la pondération et le statut des performances quotidiennes a évaluer</h4>
        </div>
            <form id="dailyPerformanceForm">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Pondération</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dailyPerformanceObjectives as $objective): ?>
                            <tr>
                                <td><?php echo $objective['description']; ?></td>
                                <td>
                                    <input type="number" name="ponderation" class="form-control ponderation-input" value="<?php echo $objective['ponderation']; ?>">
                                </td>
                                <td>
                                    <select name="statut" class="form-control status-select">
                                        <option value="Applicable" <?php echo $objective['statut'] == 'Applicable' ? 'selected' : ''; ?>>Applicable</option>
                                        <option value="Non Applicable" <?php echo $objective['statut'] == 'Non Applicable' ? 'selected' : ''; ?>>Non Applicable</option>
                                    </select>
                                </td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
            <div class="navigation-buttons">
                <button class="btn btn-primary" onclick="previousSection(1)">Précédent</button>
                <button class="btn btn-primary" onclick="nextSection(3)">Suivant</button>
                <button class="btn btn-primary" onclick="saveDailyPerformance()">Enregistrer</button>
               
            </div>
        </div>
        
       <!-- Section 3: compétence -->
 <div id="section3" class="section">
 <div class="form-group">
            <h4>Validez le niveau réquis et le statut des compétences a évaluer</h4>
        </div>
    <form id="competenceForm">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Niveau réquis</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($competenceObjectives as $objective): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($objective['description']); ?></td>
                        <td>
                            <input type="number" name="niveau_requis" class="form-control niveau_requis-input" value="<?php echo htmlspecialchars($objective['niveau_requis']); ?>">
                        </td>
                        <td>
                            <select name="statut" class="form-control niveau_requis-select">
                                <option value="Applicable" <?php echo $objective['statut'] == 'Applicable' ? 'selected' : ''; ?>>Applicable</option>
                                <option value="Non Applicable" <?php echo $objective['statut'] == 'Non Applicable' ? 'selected' : ''; ?>>Non Applicable</option>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
    <div class="navigation-buttons">
        <button class="btn btn-primary" onclick="previousSection(2)">Précédent</button>
        <button class="btn btn-primary" onclick="savecompetence()">Enregistrer</button>
    </div>
 </div>

</div>

    </div>
    <script>
               // mise a jour des ponderation lorsque le statut est Non Applicable
        document.addEventListener("DOMContentLoaded", function () {
            const statusSelects = document.querySelectorAll('.status-select');

            statusSelects.forEach(select => {
                select.addEventListener('change', function () {
                    const row = select.closest('tr');
                    const ponderationInput = row.querySelector('.ponderation-input');
                    
                    if (select.value === 'Non Applicable') {
                        ponderationInput.value = 0; // Mettre la pondération à zéro
                        ponderationInput.disabled = true; // Désactiver l'entrée
                    } else {
                        ponderationInput.disabled = false; // Activer l'entrée
                    }
                });

                // Déclencher l'événement une fois au chargement pour gérer les valeurs initiales
                select.dispatchEvent(new Event('change'));
            });
        });
               // mise a jour du niveau requis lorsque le statut est Non Applicable
               document.addEventListener("DOMContentLoaded", function () {
            const statusSelects = document.querySelectorAll('.niveau_requis-select');

            statusSelects.forEach(select => {
                select.addEventListener('change', function () {
                    const row = select.closest('tr');
                    const ponderationInput = row.querySelector('.niveau_requis-input');
                    
                    if (select.value === 'Non Applicable') {
                        ponderationInput.value = 0; // Mettre la pondération à zéro
                        ponderationInput.disabled = true; // Désactiver l'entrée
                    } else {
                        ponderationInput.disabled = false; // Activer l'entrée
                    }
                });

                // Déclencher l'événement une fois au chargement pour gérer les valeurs initiales
                select.dispatchEvent(new Event('change'));
            });
        });

    // Script pour la gestion des sections
    function nextSection(sectionNumber) {
        if (checkObjectives()) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById('section' + sectionNumber).classList.add('active');
        }
    }

    function previousSection(sectionNumber) {
        if (checkObjectives()) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById('section' + sectionNumber).classList.add('active');
        }
    }

    // Ajout d'un nouvel objectif
    function addObjective() {
        if (checkObjectives()) {
            var description = document.getElementById('objectiveDescription').value;
            var performanceIndicator = document.getElementById('performanceIndicator').value;
            var weighting = document.getElementById('objectiveWeighting').value;

            if (description && performanceIndicator && weighting) {
                var table = document.getElementById('transversalObjectivesTable').getElementsByTagName('tbody')[0];
                var newRow = table.insertRow();
                var descriptionCell = newRow.insertCell(0);
                var performanceIndicatorCell = newRow.insertCell(1);
                var weightingCell = newRow.insertCell(2);
                var statusCell = newRow.insertCell(3);
                var updateCell = newRow.insertCell(4);
                var deleteCell = newRow.insertCell(5);

                descriptionCell.innerHTML = description;
                performanceIndicatorCell.innerHTML = performanceIndicator;
                weightingCell.innerHTML = weighting;
                statusCell.innerHTML = '<select class="form-control"><option value="Actif">Actif</option><option value="Inactif">Inactif</option></select>';
                updateCell.innerHTML = '<button class="btn btn-warning" onclick="updateObjective(this)">Modifier</button>';
                deleteCell.innerHTML = '<button class="btn btn-danger" onclick="deleteObjective(this)">Supprimer</button>';

                // Réinitialiser le formulaire
                document.getElementById('addObjectiveForm').reset();
            } else {
                alert('Veuillez remplir tous les champs.');
            }
        }
    }

    // Mettre à jour un objectif
    function updateObjective(button) {
        var row = button.parentNode.parentNode;
        row.contentEditable = true;
        button.textContent = 'Enregistrer';
        button.onclick = function() {
            row.contentEditable = false;
            button.textContent = 'Modifier';
            button.onclick = function() {
                updateObjective(button);
            }
        };
    }

    // Supprimer un objectif
    function deleteObjective(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    // Enregistrer les objectifs transversaux
    function saveTransversalObjectives() {
        if (checkObjectives()) {
            var table = document.getElementById('transversalObjectivesTable');
            var totalWeighting = 0;
            for (var i = 1; i < table.rows.length; i++) {
                totalWeighting += parseInt(table.rows[i].cells[2].innerHTML);
            }
            if (totalWeighting === 100) {
                // Collect the objectives data
                var objectives = [];
                for (var i = 1; i < table.rows.length; i++) {
                    var row = table.rows[i];
                    var objective = {
                        description: row.cells[0].innerHTML,
                        performanceIndicator: row.cells[1].innerHTML,
                        weighting: row.cells[2].innerHTML,
                        status: row.cells[3].querySelector('select').value
                    };
                    objectives.push(objective);
                }

                // Send the data via AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_transversal_objectives.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        var response = JSON.parse(xhr.responseText);
                        alert(response.message);
                    }
                };
                xhr.send(JSON.stringify({objectives: objectives, category: 'tache principale'}));
            } else {
                alert('La somme des pondérations doit être égale à 100%. Actuelle : ' + totalWeighting + '%.');
            }
        }
    }

    // Enregistrer les performances quotidiennes
    function saveDailyPerformance() {
        <?php if ($is_dsi): ?>
            // Pour le DSI, pas de vérification de la somme des pondérations
            var form = document.getElementById('dailyPerformanceForm');
            var formData = new FormData(form);
            // ... reste du code de sauvegarde ...
        <?php else: ?>
            if (checkObjectives()) {
                var form = document.getElementById('dailyPerformanceForm');
                var formData = new FormData(form);
                var totalWeighting = 0;

                // Calculer la somme des pondérations
                formData.forEach((value, key) => {
                    if (key === 'ponderation') {
                        totalWeighting += parseInt(value);
                    }
                });

                if (totalWeighting === 100) {
                    // Récupérer les données des performances
                    var performances = [];
                    form.querySelectorAll('tbody tr').forEach(row => {
                        var performance = {
                            description: row.cells[0].innerHTML,
                            weighting: row.cells[1].querySelector('input').value,
                            status: row.cells[2].querySelector('select').value
                        };
                        performances.push(performance);
                    });

                    // Afficher les données à envoyer dans la console pour vérification
                    console.log("Performances to send:", performances);

                    // Envoyer les données via AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'save_daily_performances.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            console.log("Response from save_daily_performances.php:", xhr.responseText);
                            var response = JSON.parse(xhr.responseText);
                            alert(response.message);

                            // Envoyer les données à assign_daily_performances.php après avoir enregistré les performances
                            sendData(performances);
                        }
                    };
                    xhr.send(JSON.stringify({ performances: performances }));
                } else {
                    alert('La somme des pondérations doit être égale à 100%. Actuelle : ' + totalWeighting + '%.');
                }
            }
        <?php endif; ?>
    }

    // Fonction pour envoyer les données à assign_daily_performances.php
    function sendData(performances) {
        // Afficher les données à envoyer dans la console pour vérification
        console.log("Data to send to assign_daily_performances.php:", JSON.stringify({ performances: performances }));

        var xhrAssign = new XMLHttpRequest();
        xhrAssign.open('POST', 'assign_daily_performances.php', true);
        xhrAssign.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
        xhrAssign.onreadystatechange = function () {
            if (xhrAssign.readyState === 4) {
                console.log("Response from assign_daily_performances.php:", xhrAssign.responseText);
                var responseAssign = JSON.parsestringify()(xhrAssign.responseText);
                alert(responseAssign.message);
            }
        };
        xhrAssign.send(JSON.stringify({ performances: performances }));
    }

    // Enregistrer les compétences
    function savecompetence() {
        <?php if ($is_dsi): ?>
            // Pour le DSI, accès direct à la sauvegarde
            var form = document.getElementById('competenceForm');
            var formData = new FormData(form);
            // ... reste du code de sauvegarde ...
        <?php else: ?>
            if (checkObjectives()) {
                var form = document.getElementById('competenceForm');
                var formData = new FormData(form);

                // Récupérer les données des competences
                var competences = [];
                form.querySelectorAll('tbody tr').forEach(row => {
                    var competence = {
                        description: row.cells[0].innerHTML,
                        niveau_requis: row.cells[1].querySelector('input').value,
                        status: row.cells[2].querySelector('select').value
                    };
                    competences.push(competence);
                });

                // Afficher les données à envoyer dans la console pour vérification
                console.log("Data to send to save_competence.php:", JSON.stringify({ competences: competences }));

                // Envoyer les données via AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_competence.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        console.log("Response from save_competence.php:", xhr.responseText);
                        var response = JSON.parse(xhr.responseText);
                        alert(response.message);

                        // Envoyer les données à assign_competences.php après avoir enregistré les competence
                        sendData(competences);
                    }
                };
                xhr.send(JSON.stringify({ competences: competences }));
            }
        <?php endif; ?>
    }

    function toggleObjectives() {
        const objectivesContainer = document.getElementById('objectives-container');
        if (objectivesContainer.style.display === 'none') {
            objectivesContainer.style.display = 'block';
        } else {
            objectivesContainer.style.display = 'none';
        }
    }
</script>

</body>
</html>
