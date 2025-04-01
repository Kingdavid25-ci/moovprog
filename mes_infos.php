<?php
// Démarrer une session pour stocker les informations de l'utilisateur connecté
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moovprog";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer le matricule de l'utilisateur connecté depuis la session
$matricule = $_SESSION['user_name'];

// Requête pour récupérer les informations du salarié
$sql = "SELECT nom, prenom, matricule, fonction_actuelle, email, superieur_hierarchique, date_naissance, date_embauche, categorie_professionnelle, localisation 
        FROM salarie 
        WHERE matricule = '$matricule'";

$result = $conn->query($sql);

// Vérifier si le résultat contient des données
if ($result->num_rows > 0) {
    // Récupérer les données de l'utilisateur
    $row = $result->fetch_assoc();
    $superieur_id_poste = $row['superieur_hierarchique'];

    // Requête pour récupérer le nom et prénom du supérieur hiérarchique
    $sql_superieur = "SELECT s.nom, s.prenom 
                      FROM salarie s 
                      JOIN poste p ON s.fonction_actuelle = p.nom_poste 
                      WHERE p.id_poste = '$superieur_id_poste'";
    $result_superieur = $conn->query($sql_superieur);

    if ($result_superieur->num_rows > 0) {
        $superieur_row = $result_superieur->fetch_assoc();
        $superieur_nom_complet = $superieur_row['nom'] . " " . $superieur_row['prenom'];
    } else {
        $superieur_nom_complet = "Non trouvé";
    }
} else {
    echo "Aucun résultat trouvé";
}

// Requête pour récupérer les notes des trois dernières années
$sql_evaluations = "SELECT ANNEE, NOTE_GLOBALE FROM resultat 
                   WHERE MATRICULE = '$matricule' 
                   ORDER BY ANNEE DESC 
                   LIMIT 3";

$result_evaluations = $conn->query($sql_evaluations);

// Stocker les notes dans un tableau
$evaluations = [];
if ($result_evaluations->num_rows > 0) {
    while($row_evaluation = $result_evaluations->fetch_assoc()) {
        $evaluations[] = $row_evaluation;
    }
} else {
    // S'il n'y a pas de résultats, remplissez avec des valeurs nulles
    $evaluations = [
        ['ANNEE' => 'Aucune', 'NOTE_GLOBALE' => 'Aucune donnée'],
        ['ANNEE' => 'Aucune', 'NOTE_GLOBALE' => 'Aucune donnée'],
        ['ANNEE' => 'Aucune', 'NOTE_GLOBALE' => 'Aucune donnée'],
    ];
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
</script>

</head>

<body ng-app="myApp">
<div id="top">
  <div id="topBar"></div>
</div>


<div class="container mt-4">
        <h1 class="page-header">Profil personnel</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main.php">Accueil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Mes infos</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-sm-6">
                <!-- Informations personnelles -->
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Nom:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['nom']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Prénom:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['prenom']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Matricule:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['matricule']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Fonction actuelle:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['fonction_actuelle']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Supérieur hiérarchique:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $superieur_nom_complet; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Date de naissance:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['date_naissance']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Date d'embauche:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['date_embauche']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Catégorie professionnelle:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['categorie_professionnelle']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Localisation:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['localisation']; ?></p>
                    </div>
                </div>
                <hr>
                <div class="mb-3 row">
                    <label class="col-sm-6 col-form-label">Email:</label>
                    <div class="col-sm-6">
                        <p class="form-control-plaintext"><?php echo $row['email']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des évaluations des trois dernières années -->
        <h3>Résultats des évaluations (3 dernières années)</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Année 1</th>
                    <th>Année 2</th>
                    <th>Année 3</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    foreach ($evaluations as $evaluation) {
                        echo "<td>" . $evaluation['ANNEE'] . " : " . $evaluation['NOTE_GLOBALE'] . "</td>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
