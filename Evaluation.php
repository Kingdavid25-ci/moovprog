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
        <h1>Evaluation de fin d'année</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main-menu.html">Acceuil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestion des evaluation</li>
                <li class="breadcrumb-item active" aria-current="page">evaluer un subalterne</li>
            </ol>
        </nav>


        
        <h1> Section 1.Évaluation des Objectifs</h1>
        <div id="error-message" class="error-message" style="display:none;"></div>
        <form id="evaluationForm" action="submit_evaluations.php" method="POST">
          <div id="evaluation-container"></div>
    
            <button type="submit">Soumettre les Évaluations</button>
        </form>
        
    </div>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'fetch_evaluation_data.php',
                method: 'GET',
                success: function(data) {
                    try {
                        var result = JSON.parse(data);
                        var employees = result.employees;
                        var objectives = result.objectives;

                        if (!Array.isArray(employees) || typeof objectives !== 'object') {
                            throw new Error('Données des employés ou des objectifs non valides.');
                        }

                        employees.forEach(function(employee) {
                            var employeeContainer = $('<div>').addClass('employee-container');
                            employeeContainer.append('<h2>' + employee.nom + ' ' + employee.prenom + '</h2>');

                            if (objectives[employee.matricule]) {
                                objectives[employee.matricule].forEach(function(objective) {
                                    var objectiveContainer = $('<div>').addClass('objective-container');
                                    objectiveContainer.append('<p><strong>Objectif:</strong> ' + objective.description + '</p>');
                                    objectiveContainer.append('<p><strong>Indicateur de Performance:</strong> ' + objective.indicateur_performance + '</p>');
                                    objectiveContainer.append('<p><strong>Date de Réalisation:</strong> ' + objective.date_realisation + '</p>');
                                    objectiveContainer.append('<p><strong>Auto-évaluation:</strong> ' + objective.autoevaluation_objectif + '</p>');
                                    objectiveContainer.append('<p><strong>Pondération:</strong> ' + objective.ponderation + '%</p>');
                                    objectiveContainer.append('<label for="note-' + objective.id + '">Note:</label>');
                                    objectiveContainer.append('<input type="number" name="notes[' + employee.matricule + '][' + objective.id + ']" min="0" max="10" step="0.1" required>');

                                    employeeContainer.append(objectiveContainer);
                                });
                            }

                            $('#evaluation-container').append(employeeContainer);
                        });
                    } catch (error) {
                        $('#error-message').text(error.message).show();
                    }
                },
                error: function(error) {
                    $('#error-message').text('Erreur de récupération des données.').show();
                    console.log(error);
                }
            });
        });
    </script>
        
        
    </div>
    

</body>
</html>