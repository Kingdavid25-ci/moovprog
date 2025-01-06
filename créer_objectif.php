<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// MATRICULE de l'utilisateur connecté
$MATRICULE = $_SESSION['user_name'];



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
        <h1> Création des objectifs </h1>
      
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
                   <button type="button" id="add-unit" class="btn btn-secondary">Ajouter une unité</button>
          </div>
                  <div id="new-unit-form" style="display: none;">
                    <h3>Ajouter une nouvelle unité organisationnelle</h3>
                    <div class="form-group">
                        <label for="new-unit-name">Nom de l'unité</label>
                        <input type="text" id="new-unit-name" name="new-unit-name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="new-unit-type">Type d'unité</label>
                        <select id="new-unit-type" name="new-unit-type" class="form-control">
                            <option value="direction">Direction</option>
                            <option value="sous-direction">Sous-Direction</option>
                            <option value="division">Division</option>
                            <option value="service">Service</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="parent-unit">Unité parente</label>
                        <select id="parent-unit" name="parent-unit" class="form-control">
                            <option value="">Sélectionner l'unité parente</option>
                            <?php foreach ($units as $unit): ?>
                                <option value="<?php echo $unit['id']; ?>"><?php echo $unit['nom']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="button" id="save-unit" class="btn btn-primary">Enregistrer l'unité</button>
                </div>
               

                 <!-- Entrée pour spécifier le nombre d'objectifs -->
              <div class="form-group">
                <label for="numObjectives">Nombre d'Objectifs</label>
                <input type="number" id="numObjectives" name="numObjectives" min="1" value="1">
              </div>

               <!-- Conteneur pour les champs des objectifs, qui sera rempli par JavaScript -->
               <div id="objectivesContainer" class="form-group">
               <!-- Les champs des objectifs seront ajoutés ici par le script JavaScript -->
               </div>
               <!-- Champ de date -->
               <label for="dateCreation">Date de création :</label>
                 <input type="date" id="dateCreation" name="dateCreation">


               <!-- Bouton pour ajouter dynamiquement des champs d'objectifs -->
                 <button type="button" onclick="addObjectives()">Cliquez pour ajouter</button>
               <!-- Bouton pour soumettre le formulaire -->
               <button type="submit">Cliquez pour créer</button>

        </form>
         <!-- Formulaire pour la saisie des pondérations et la modification du statut -->
         <h3>Pondérations et Statuts de la Performance Quotidienne</h3>
            <form id="statusForm" action="update_statut.php" method="POST" onsubmit="return validatePonderations();">
                <?php foreach ($dailyPerformanceObjectives as $objective): ?>
                    <div class="objective">
                        <p><?php echo htmlspecialchars($objective['description'] ?? ''); ?></p>
                        <div class="form-group">
                            <label for="ponderation_<?php echo htmlspecialchars($objective['id'] ?? ''); ?>">Pondération :</label>
                            <input type="number" id="ponderation_<?php echo htmlspecialchars($objective['id'] ?? ''); ?>" name="ponderation[<?php echo htmlspecialchars($objective['id'] ?? ''); ?>]" value="<?php echo htmlspecialchars($objective['ponderation'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="statut_<?php echo htmlspecialchars($objective['id'] ?? ''); ?>">Statut :</label>
                            <select id="statut_<?php echo htmlspecialchars($objective['id'] ?? ''); ?>" name="statut[<?php echo htmlspecialchars($objective['id'] ?? ''); ?>]" required>
                                <option value="Applicable" <?php echo (isset($objective['statut']) && $objective['statut'] == 'Applicable') ? 'selected' : ''; ?>>Applicable</option>
                                <option value="Non applicable" <?php echo (isset($objective['statut']) && $objective['statut'] == 'Non applicable') ? 'selected' : ''; ?>>Non applicable</option>
                            </select>
                        </div>
                    </div>
                <?php endforeach; ?>
                <button type="submit" name="submit_status"> cliquez pour Enregistrer </button>
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
            var totalPonderation = 0;
            var inputs = document.querySelectorAll('input[type="number"][id^="ponderation_"]');

            inputs.forEach(function(input) {
                totalPonderation += parseFloat(input.value) || 0;
            });

            if (totalPonderation !== 100) {
                alert("La somme des pondérations doit être exactement de 100. La somme actuelle est de " + totalPonderation + ".");
                return false;
            }

            return true;
        }
    </script>
      </div>
    </div>
   </div>
  <div class ="container" id="dateCreationDisplay"></div>
<script>
function addObjectives() {
    const numObjectives = document.getElementById('numObjectives').value;
    const objectivesContainer = document.getElementById('objectivesContainer');
    objectivesContainer.innerHTML = ''; // Clear existing objectives

    for (let i = 1; i <= numObjectives; i++) {
        const objectiveDiv = document.createElement('div');
        objectiveDiv.className = 'objective';

        const label = document.createElement('label');
        label.textContent = `Objectif ${i}`;

        const descriptionInput = document.createElement('input');
        descriptionInput.type = 'text';
        descriptionInput.name = `objective${i}Description`;
        descriptionInput.placeholder = "Description de l'objectif";
        descriptionInput.required = true;

        const indicateurTextarea = document.createElement('textarea');
        indicateurTextarea.name = `objective${i}Indicateur`;
        indicateurTextarea.placeholder = "Indicateur de performance";
        indicateurTextarea.required = true;

        const ponderationInput = document.createElement('input');
        ponderationInput.type = 'number';
        ponderationInput.name = `objective${i}Ponderation`;
        ponderationInput.placeholder = "Pondération";
        ponderationInput.required = true;

        objectiveDiv.appendChild(label);
        objectiveDiv.appendChild(descriptionInput);
        objectiveDiv.appendChild(indicateurTextarea);
        objectiveDiv.appendChild(ponderationInput);
        
        objectivesContainer.appendChild(objectiveDiv);
    }
}

document.getElementById('add-unit').addEventListener('click', function() {
    var form = document.getElementById('new-unit-form');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
});




</script>

</body>
</html>
