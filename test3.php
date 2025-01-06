<?php
session_start();

// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
//$dbname = "moov_africa";
$dbname = "moovprog";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// MATRICULE de l'utilisateur connecté
$MATRICULE = isset($_SESSION['user_name']) ? $_SESSION['user_name']:'';

// Récupérer toutes les unités organisationnelles
$units = [];
$sql = "SELECT id, nom FROM sructure_entreprise";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $units[] = $row;
    }
}

// Récupérer les objectifs de catégorie <performance quotidienne>
$dailyPerformanceObjectives = [];
$sql = "SELECT id, description, ponderation FROM objectif WHERE categorie = 'performance quotidienne'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $dailyPerformanceObjectives[] = $row;
    }
}
$conn->close();
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Evaluation_main | Main Menu</title>
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
<script src="third-party/ng-file-upload-12.2.12/demo/src/main/webapp/js/ng-file-upload.js"></script>
<script src="js/menu.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style type="text/css">
  
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
h1, h2, h3 {
    color: #333;
}
.objective-list {
    margin-top: 20px;
}
.objective {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
    background-color: #fafafa;
}
.form-group {
    margin-bottom: 15px;
}
label {
    display: block;
    margin-bottom: 5px;
}
select, input[type="text"], textarea, input[type="date"], input[type="number"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
}
button {
    padding: 10px 15px;
    background-color: #5cb85c;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background-color: #4cae4c;
}
</style>
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
          <a class="navbar-brand" href="#">evaluation des performances</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav" id="bs-example-navbar-collapse-1">
            <li><a href="#carousel">Acceuil<span class="fa fa-home fa-lg"></span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Evaluation <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">details d'evaluation</li>
                <li class="menu-admin"><a href="">voir mon evaluation</a></li>
                <li class="menu-admin"><a href="">faire mon evaluation</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Rapport</li>
                <li><a href="">Rapport individuel</a></li>
                <li><a href="">Rapport collectif</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Reclamation</li>
                <li><a href="">faire une reclamation</a></li>
              </ul>
            </li>
            <li class="dropdown menu-admin">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestion des evaluations <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">details de la gestion</li>
                <li class="menu-admin"><a href="créer_objectif.php">créer des objectifs</a></li>
                <li class="menu-admin"><a href="affecter.php">affecter des objectifs</a></li>
                <li><a href="Evaluation_objectif.php">evaluer un subalterne</a></li>
                <li><a href="modifier_evaluation.php">modifier une evaluation</a></li>
                <li><a href="">valider une evaluation</a></li>
              </ul>
            </li>
            <li class="dropdown menu-admin">
              <button type="button" class="btn btn-primary" style="padding-top: 14px;">Récap des évaluation</button>
              <ul class="dropdown-menu"></ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="mes_infos.php">Mes infos<span class="fa fa-user fa-lg"></span></a></li>
            <li><a href="">Se deconecter<span class="fa fa-sign-out fa-lg"></span></a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;">
    <div class="container">
        <h1> Création des paramètres </h1>
      
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main-menu.html">Acceuil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestion des evaluation</li>
                <li class="breadcrumb-item active" aria-current="page">Creation  des objectifs</li>
            </ol>
        </nav>
        <p>Définissez les objectifs pour vos subordonnés.</p>
     <div id="objective-container" class="container">
     
        <form id="objectivesForm" action="submit_OB_crée.php" method="POST">
                <div class="form-group">
                    <label for="unit">Unité</label>
                    <select name="unit" id="unit" class="form-control" required>
                        <option value="">Sélectionner l'unité</option>
                        <?php foreach ($units as $unit): ?>
                            <option value="<?php echo $unit['id']; ?>"><?php echo $unit['nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Objectifs</label>
                    <table class="table table-bordered" id="objectivesTable">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Indicateur de performance</th>
                                <th>Pondération</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be dynamically added here -->
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" onclick="addObjective()">Ajouter un objectif</button>
                </div>

                   <button type="button" class="btn btn-success" onclick="validateAndSubmitForm()">Enregistrer les objectifs</button>
        </form>
        
    </div>

    <script>
        // Function to add an objective
        function addObjective() {
            const table = document.getElementById('objectivesTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            const cell1 = row.insertCell(0);
            const cell2 = row.insertCell(1);
            const cell3 = row.insertCell(2);
            const cell4 = row.insertCell(3);

            cell1.innerHTML = '<input type="text" name="description[]" class="form-control" required>';
            cell2.innerHTML = '<input type="text" name="indicateur[]" class="form-control" required>';
            cell3.innerHTML = '<input type="number" name="ponderation[]" class="form-control" required>';
            cell4.innerHTML = '<button type="button" class="btn btn-danger" onclick="removeObjective(this)">Supprimer</button>';
        }

        // Function to remove an objective
        function removeObjective(button) {
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
        }

        // Function to validate total ponderation
        function validateAndSubmitForm() {
            const ponderationInputs = document.getElementsByName('ponderation[]');
            let total = 0;
            for (let i = 0; i < ponderationInputs.length; i++) {
                total += parseFloat(ponderationInputs[i].value) || 0;
            }
            if (total !== 100) {
                alert('La pondération totale doit être égale à 100%. Actuellement : ' + total + '%');
            } else {
                document.getElementById('objectivesForm').submit();
            }
        }
    </script>
         <!-- Formulaire pour la saisie des pondérations et la modification du statut -->
         <h3>Pondérations et Statuts de la Performance Quotidienne</h3>
         <form id="statutForm" action="update_statut.php" method="POST" onsubmit="return validatePonderations();">
        <h5>entrez les pondérations et le statut de la Performance Quotidienne</h5>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Description</th>
              <th>Pondération</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($dailyPerformanceObjectives as $objective) : ?>
              <tr>
                <td><?php echo $objective['description']; ?></td>
                <td>
                  <input type="number" id="ponderation-<?php echo $objective['id']; ?>" name="ponderation-<?php echo $objective['id']; ?>" value="<?php echo $objective['ponderation']; ?>" min="0" max="100" required>
                </td>
                <td>
                  <select id="statut-<?php echo $objective['id']; ?>" name="statut-<?php echo $objective['id']; ?>">
                    <option value="Applicable" <?php if(isset($objective['statut']) && $objective['statut'] == 'Applicable') echo 'selected'; ?>>Applicable</option>
                    <option value="Non Applicable" <?php if(isset($objective['statut']) && $objective['statut'] == 'Non Applicable') echo 'selected'; ?>>Non Applicable</option>
                  </select>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <button type="submit" name="submit_statut"> cliquez pour Enregistrer </button>
      </form>
        </div>
    </div>
    <div id="footer"></div>
    
    <script>
        $(document).ready(function(){
            $('#topBar').load("header.html");
            $('#footer').load("footer.html");
        });

        function validatePonderations() {
          var total = 0;
          var ponderations = document.querySelectorAll(".ponderation");

          ponderations.forEach(function(p) {
            total += parseFloat(p.value) || 0;
          });

          if (total !== 100) {
            alert("Le total des pondérations doit être égal à 100%. Actuellement: " + total + "%");
            return false;
          }
          return true;
        }
    </script>
      </div>
    </div>
   </div>
  <div class ="container" id="dateCreationDisplay"></div>

</body>
</html>
