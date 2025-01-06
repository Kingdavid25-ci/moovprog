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
$MATRICULE =isset($_SESSION['user_name'])? $_SESSION['user_name']:'';

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
$sql = "SELECT id, description, ponderation, statut FROM objectif WHERE categorie = 'performance quotidienne'";
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
<title>Evaluation_main | Main Menu</title>
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
table.table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
}
table.table th, table.table td {
    padding: 8px;
    border: 1px solid #ddd;
}
</style>
<script type="text/javascript">
function validatePonderations() {
    var totalPonderation = 0;
    var inputs = document.querySelectorAll('input[type="number"]');
    for (var i = 0; i < inputs.length; i++) {
        totalPonderation += parseFloat(inputs[i].value);
    }
    if (totalPonderation !== 100) {
        alert("Le total des pondérations doit être égal à 100. Le total actuel est de " + totalPonderation + ".");
        return false;
    }
    return true;
}
</script>
</head>
<body ng-app="myApp">
    <div id="top">
      <div id="topBar"></div>
    </div>

    <div class="container">
      <h1>Evaluation des Performances</h1>
     
      <form id="statutForm" action="update_statut.php" method="POST" onsubmit="return validatePonderations();">
        <h4>Objectifs de Performance Quotidienne</h4>
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
</body>
</html>
