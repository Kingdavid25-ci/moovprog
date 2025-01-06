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

// matricule de l'utilisateur connecté
$matricule = $_SESSION['user_name'];

// Récupérer le NOM du salarié à partir de son matricule
$sql = "SELECT NOM FROM salarie WHERE matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matricule);
$stmt->execute();
$stmt->bind_result($NOM_superieur);
$stmt->fetch();
$stmt->close();

$salaries = [];

if ($NOM_superieur) {
    // Si un NOM a été trouvé, récupérer tous les salariés qui ont ce NOM comme supérieur hiérarchique
    $sql = "SELECT matricule, NOM, PRENOM FROM salarie WHERE superieur_hierarchique = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $NOM_superieur);
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
<title> objectif_main | Main Menu</title>
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
          <a class="navbar-brand" href="#">Evaluation des performances</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav" id="bs-example-navbar-collapse-1">
            <li><a href="#carousel">Acceuil<span class="fa fa-home fa-lg"></span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Evaluation<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">details d'objectif</li>
                <li class="menu-admin"><a href="">voir mon objectif</a></li>
                <li class="menu-admin"><a href="">faire mon objectif</a></li>
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
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gestion des évaluations <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">details de la gestion</li>
                <li class="menu-admin"><a href="créer_objectif.php">créer des objectifs</a></li>
                <li class="menu-admin"><a href="affecter.php">affecter des objectifs</a></li>
                <li><a href="Evaluation_objectif.php">evaluer un subalterne</a></li>
                <li><a href="modifier_evaluation.php">modifier une objectif</a></li>
                <li><a href="">valider une objectif</a></li>
              </ul>
            </li>
            <li class="dropdown menu-admin">
              <button type="button" class="btn btn-primary" style="padding-top: 14px;">Récap des évaluations</button>
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
        <h1>Modifier une evaluation</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main-menu.html">Acceuil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestion des objectif</li>
                <li class="breadcrumb-item active" aria-current="page">modifier une evaluation</li>
            </ol>
        </nav>
  <!-- Formulaire pour soumettre des objectifs -->
<form id="objectivesForm" action="save_modifications.php" method="POST">
    <div class="form-group">
        <label for="salarie-select">Sélectionner le salarié</label>
        <select id="salarie-select" name="salarie" class="form-control">
            <!-- Vérifie s'il y a des salariés dans le tableau $salaries -->
            <?php if (count($salaries) > 0): ?>
                <!-- Boucle pour afficher chaque salarié en option dans le menu déroulant -->
                <?php foreach ($salaries as $salarie): ?>
                    <option value="<?php echo $salarie['matricule']; ?>">
                        <?php echo $salarie['matricule']; ?> - <?php echo $salarie['NOM']; ?> <?php echo $salarie['PRENOM']; ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Si aucun salarié n'est trouvé, afficher un message -->
                <option value="">Aucun salarié trouvé</option>
            <?php endif; ?>
        </select>
        </div>

        <div id="objectifContainer" class="form-group"></div>

        <button type="button" onclick="fetchobjectifs()">Afficher les Évaluations</button>
        <button type="submit">Enregistrer les modifications</button>
    </form>
</div>

<script>
// Fonction pour récupérer les évaluations d'un subordonné via AJAX
function fetchobjectifs() {
    const matricule = document.getElementById('salarie-select').value;

    $.ajax({
        url: 'get_evaluation.php', // URL du script PHP à appeler
        type: 'POST', // Méthode de requête
        dataType: 'json', // Type de données attendu en réponse
        data: { matricule: matricule }, // Données envoyées au serveur
        success: function(response) {
            // Vérifier si la réponse contient les objectifs
            if (response.objectifs) {
                // Afficher les évaluations récupérées
                displayobjectifs(response.objectifs);
            } else {
                console.error('Erreur: Aucune évaluation trouvée.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur lors de la récupération des évaluations:', error);
        }
    });
}

// Fonction pour afficher les évaluations récupérées
function displayobjectifs(objectifs) {
    const objectifContainer = document.getElementById('objectifContainer');
    objectifContainer.innerHTML = ''; // Vider le conteneur des évaluations

    // Boucle pour chaque évaluation récupérée
    objectifs.forEach((objectif, index) => {
        const objectifDiv = document.createElement('div');
        objectifDiv.className = 'objectif';

        // Créer et ajouter les champs de saisie pour chaque attribut de l'évaluation
        const descriptionInput = document.createElement('input');
        descriptionInput.type = 'text';
        descriptionInput.name = 'objectif' + index + 'Description';
        descriptionInput.placeholder = 'Description de l\'objectif';
        descriptionInput.value = objectif.DESCRIBES;
        objectifDiv.appendChild(descriptionInput);

        const indicateurInput = document.createElement('input');
        indicateurInput.type = 'text';
        indicateurInput.name = 'objectif' + index + 'Indicateur';
        indicateurInput.placeholder = 'Indicateur de performance';
        indicateurInput.value = objectif.INDICATEUR_PERFORMANCE;
        objectifDiv.appendChild(indicateurInput);

        const dateDebutInput = document.createElement('input');
        dateDebutInput.type = 'date';
        dateDebutInput.name = 'objectif' + index + 'DateDebut';
        dateDebutInput.placeholder = 'Date de début';
        dateDebutInput.value = objectif.DATE_DEBUT;
        objectifDiv.appendChild(dateDebutInput);

        const dateFinInput = document.createElement('input');
        dateFinInput.type = 'date';
        dateFinInput.name = 'objectif' + index + 'DateFin';
        dateFinInput.placeholder = 'Date de fin';
        dateFinInput.value = objectif.DATE_LIMIT_OB;
        objectifDiv.appendChild(dateFinInput);

        

        const ponderationInput = document.createElement('input');
        ponderationInput.type = 'number';
        ponderationInput.name = 'objectif' + index + 'Ponderation';
        ponderationInput.placeholder = 'Pondération';
        ponderationInput.value = objectif.PONDERATION;
        objectifDiv.appendChild(ponderationInput);

        

        const objectifInput = document.createElement('input');
        objectifInput.type = 'number';
        objectifInput.name = 'objectif' + index + 'objectif';
        objectifInput.placeholder = 'NOTE_N1';
        objectifInput.value = objectif.NOTE_N1;
        objectifDiv.appendChild(objectifInput);

        // Ajouter le div de l'évaluation au conteneur
        objectifContainer.appendChild(objectifDiv);
    });
    
    const dateRealisationInput = document.createElement('input');
        dateRealisationInput.type = 'date';
        dateRealisationInput.name = `objective${i}DateFin`;
        const dateRealisationText = document.createElement('span');
        dateRealisationText.textContent = 'Date limite de realisation : ';

        
}

</script>

</body>
</html>
