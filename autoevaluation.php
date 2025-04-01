<?php
session_start();

// MATRICULE de l'utilisateur connecté
$matricule = $_SESSION['user_name'];

// Connect to database
//$connection = new mysqli('localhost', 'root', '', 'moov_africa_test');
$connection = new mysqli('localhost', 'root', '', 'moovprog');

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Fetch objectives for each category
$tachePrincipale = $connection->prepare("SELECT o.id, o.description, o.indicateur_performance, o.ponderation, e.autoevaluation_objectif FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'tache principale'");
$tachePrincipale->bind_param("i", $matricule);
$tachePrincipale->execute();
$tachePrincipaleResult = $tachePrincipale->get_result();

$performanceQuotidienne = $connection->prepare("SELECT o.id, o.description, o.ponderation, e.AUTO_EVALUATION_PERFORM FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'performance quotidienne'");
$performanceQuotidienne->bind_param("i", $matricule);
$performanceQuotidienne->execute();
$performanceQuotidienneResult = $performanceQuotidienne->get_result();

$development = $connection->prepare("SELECT o.id, o.description, e.reponse_develop FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'developpement'");
$development->bind_param("i", $matricule);
$development->execute();
$developmentResult = $development->get_result();

$connection->close();
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
.section { display: none; }
        .section.active { display: block; }
        .navigation-buttons { margin-top: 20px; }
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
    <div class="background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;">
    <div class="container">
        <h1> Auto-évaluation </h1>
      
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main.php">Acceuil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestion des evaluation</li>
                <li class="breadcrumb-item active" aria-current="page">Creation  des objectifs</li>
            </ol>
        </nav>
        <form action="save_evaluation.php" method="POST">

            <!-- Section Tâche Principale -->
            <div id="section1" class="section active">
                <h3>Tâche Principale</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Indicateur de Performance</th>
                            <th>Pondération</th>
                            <th>Commentaire sur la Réalisation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $tachePrincipaleResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['indicateur_performance']; ?></td>
                                <td><?php echo $row['ponderation']; ?></td>
                                <td><textarea name="auto_evaluation[<?php echo $row['id']; ?>]"><?php echo $row['autoevaluation_objectif']; ?></textarea></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-primary" onclick="nextSection(2)">Suivant</button>
            </div>

            <!-- Section Performance Quotidienne -->
            <div id="section2" class="section">
                <h3>Performance Quotidienne</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Pondération</th>
                            <th>Commentaire sur la Réalisation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $performanceQuotidienneResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['ponderation']; ?></td>
                                <td><textarea name="auto_evaluation_perform[<?php echo $row['id']; ?>]"><?php echo $row['AUTO_EVALUATION_PERFORM']; ?></textarea></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" onclick="previousSection(1)">Précedent</button>
                <button type="button" class="btn btn-secondary" onclick="previousSection(3)">Suivant</button>
            </div>
             <!-- developpement de la performance -->
             <div id="section3" class="section">
                <h3>Developpement des performances</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Questions</th>
                            <th>reponses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $developmentResult->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['description']; ?></td>
                                <td><textarea name="reponse_develop[<?php echo $row['id']; ?>]"><?php echo $row['reponse_develop']; ?></textarea></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" onclick="previousSection(2)">Précedent</button>
                <input type="submit" class="btn btn-success" value="Enregistrer">
            </div>


           
        </form>
    </div>

    <script>
        function nextSection(section) {
            if (validateSection(section - 1)) {
                document.querySelector('.section.active').classList.remove('active');
                document.getElementById(`section${section}`).classList.add('active');
            }
        }

        function previousSection(section) {
            document.querySelector('.section.active').classList.remove('active');
            document.getElementById(`section${section}`).classList.add('active');
        }

        function validateSection(section) {
            const currentSection = document.getElementById(`section${section}`);
            const textareas = currentSection.querySelectorAll('textarea');
            for (let textarea of textareas) {
                if (!/^[a-zA-Z\s]*$/.test(textarea.value)) {
                    alert('Veuillez entrer uniquement des caractères de type texte dans les commentaires sur la réalisation.');
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html>
