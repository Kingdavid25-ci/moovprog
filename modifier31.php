<?php
session_start();

// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
// $dbname = "moov_africa_test";
$dbname = "moovprog";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Matricule de l'utilisateur connecté
$matricule = $_SESSION['user_name'];

$salaries = [];

// Préparer et exécuter la requête pour récupérer les salariés sous la supervision de l'utilisateur connecté
$sql = "SELECT matricule, NOM, PRENOM FROM salarie WHERE superieur_hierarchique = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $matricule);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Stocker les résultats dans un tableau
    while ($row = $result->fetch_assoc()) {
        $salaries[] = $row;
    }
    
    $stmt->close();
}

$conn->close();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> Modification des Évaluations des Subordonnés</title>
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
.section { display: none; }
.section.active { display: block; }

        
    .narrow-select {
        width: 300px; /* Ajustez cette valeur selon vos besoins */
    }

</style>
<script>
        // Fonction pour récupérer les données des salariés
        function fetchEmployeeData(matricule) {
            console.log('Fetching data for matricule:', matricule); // Ajoutez cette ligne pour vérifier la valeur du matricule
            if (matricule) {
                fetch('fetch_employee_data_for_modif.php?matricule=' + matricule)
                    .then(response => response.json())
                    .then(data => {
                        populateTachePrincipale(data.tachePrincipale);
                        populatePerformanceQuotidienne(data.performanceQuotidienne);
                        populateCompetence(data.competence);
                        showSection('section1');
                    });
            }
        }

        // Fonction pour afficher une section spécifique
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }

        // Fonction pour remplir le tableau "Tâche Principale"
        function populateTachePrincipale(data) {
            let tableBody = document.getElementById('tachePrincipaleBody');
            tableBody.innerHTML = ''; // Effacer les données existantes
            data.forEach(row => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${row.description}</td>
                        <td>${row.indicateur_performance}</td>
                        <td><input type="text" name="ponderation[]" value="${row.ponderation}" /></td>
                        <td>${row.autoevaluation_objectif}</td>
                        <td><input type="text" name="note_objectif[]" value="${row.note_objectif}" /></td>
                        <input type="hidden" name="id_objectif[]" value="${row.id}" />
                    </tr>
                `;
            });
        }

        // Fonction pour remplir le tableau "Performance Quotidienne"
        function populatePerformanceQuotidienne(data) {
            let tableBody = document.getElementById('performanceQuotidienneBody');
            tableBody.innerHTML = ''; // Effacer les données existantes
            data.forEach(row => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${row.description}</td>
                        <td><input type="text" name="ponderation[]" value="${row.ponderation}" /></td>
                        <td><input type="text" name="AUTO_EVALUATION_PERFORM[]" value="${row.AUTO_EVALUATION_PERFORM}" /></td>
                        <td><input type="text" name="NOTE_EVALUATEUR[]" value="${row.NOTE_EVALUATEUR}" /></td>
                        <input type="hidden" name="id_performance[]" value="${row.id}" />

                    </tr>
                `;
            });
        }

        // Fonction pour remplir le tableau "Compétence"
        function populateCompetence(data) {
            let tableBody = document.getElementById('competenceBody');
            tableBody.innerHTML = ''; // Effacer les données existantes
            data.forEach(row => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${row.description}</td>
                        <td class="niveau-requis">${row.niveau_requis}</td>
                        <td><input type="text" name="niveau_capacite[]" class="niveau-capacite" value="${row.niveau_capacite}" oninput="calculateCapacityLacunes(this.closest('tr'))" /></td>
                        <td class="capacite-lacunes">${row.niveau_requis - row.niveau_capacite}</td>
                        <td><input type="text" name="COMMENTAIRE[]" value="${row.COMMENTAIRE}" /></td>
                        <input type="hidden" name="id_competence[]" value="${row.id}" />
                    </tr>
                `;
            });
        }

        // Calculer la capacité et les lacunes
        function calculateCapacityLacunes(row) {
            const niveauRequis = parseFloat(row.querySelector('.niveau-requis').textContent);
            const niveauCapaciteInput = row.querySelector('.niveau-capacite');
            const capaciteLacunesCell = row.querySelector('.capacite-lacunes');

            let niveauCapacite = parseFloat(niveauCapaciteInput.value) || 0;
            capaciteLacunesCell.textContent = niveauCapacite - niveauRequis;
        }

        // Initialise l'affichage pour la section "Tâche Principale"
        document.addEventListener("DOMContentLoaded", function () {
            showSection('section1');
        });

        // Met à jour le champ matricule caché à chaque sélection de salarié
        document.getElementById('salarie').addEventListener('change', function () {
    var matricule = this.value;
    console.log('Selected matricule:', matricule); // Vérifiez la valeur du matricule
    document.getElementById('selectedMatricule1').value = matricule;
    document.getElementById('selectedMatricule2').value = matricule;
    document.getElementById('selectedMatricule3').value = matricule;
});


    </script>
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
      <li><a href="#carousel">Accueil <span class="fa fa-home fa-lg ms-2"></span></a></li>
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
            <li><a href="">Valider une evaluation</a></li>
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
    <li><a href="">Se déconnecter <span class="fa fa-sign-out fa-lg me-2"></span></a></li>
</ul>

    </div>
  </div>
</nav>
<div class="container">
        <h2>Modification des Évaluations </h2>
        <div class="form-group">
            <label for="salarie">Sélectionnez un salarié :</label>
            <select id="salarie" class="form-control  narrow-select" onchange="fetchEmployeeData(this.value)">
                <option value="">-- Sélectionner --</option>
                <?php foreach ($salaries as $salarie): ?>
                    <option value="<?php echo $salarie['matricule']; ?>">
                        <?php echo htmlspecialchars($salarie['NOM']) . " " . htmlspecialchars($salarie['PRENOM']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <form action="update_tache_principale.php" method="POST">
    <div id="section1" class="section">
        <h3>Tâche principale</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Indicateur de performance</th>
                    <th>Pondération</th>
                    <th>Commentaire sur la réalisation</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody id="tachePrincipaleBody">
                <!-- Les données seront insérées ici par JavaScript -->
            </tbody>
        </table>
        <input type="hidden" name="matricule" value="" id="selectedMatricule1">
        <button type="button" class="btn btn-primary" onclick="showSection('section2')">Suivant</button>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </div>
</form>

<!-- Formulaire pour la section Performance Quotidienne -->
<form action="update_performance_quotidienne.php" method="POST">
    <div id="section2" class="section">
        <h3>Performance quotidienne</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Pondération</th>
                    <th>Commentaires sur la réalisation</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody id="performanceQuotidienneBody">
                <!-- Les données seront insérées ici par JavaScript -->
            </tbody>
        </table>
        <input type="hidden" name="matricule" value="" id="selectedMatricule2">
        <button type="button" class="btn btn-warning" onclick="showSection('section1')">Précédent</button>
        <button type="button" class="btn btn-primary" onclick="showSection('section3')">Suivant</button>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </div>
</form>

<!-- Formulaire pour la section Compétence -->
<form action="update_competence.php" method="POST">
    <div id="section3" class="section">
        <h3>Compétence</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Niveau requis</th>
                    <th>Niveau de capacité</th>
                    <th>Capacités et Lacunes</th>
                    <th>Commentaires</th>
                </tr>
            </thead>
            <tbody id="competenceBody">
                <!-- Les données seront insérées ici par JavaScript -->
            </tbody>
        </table>
        <input type="hidden" name="matricule" value="" id="selectedMatricule3">
        <button type="button" class="btn btn-warning" onclick="showSection('section2')">Précédent</button>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </div>
</form>


    </div>
    <script>
        // Met à jour le champ matricule caché à chaque sélection de salarié
        document.getElementById('salarie').addEventListener('change', function () {
            var matricule = this.value;
            document.getElementById('selectedMatricule1').value = matricule;
            document.getElementById('selectedMatricule2').value = matricule;
            document.getElementById('selectedMatricule3').value = matricule;
        });
    </script>
</body>


</html>
