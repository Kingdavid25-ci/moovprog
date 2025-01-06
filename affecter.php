<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// matricule de l'utilisateur connecté
$matricule = $_SESSION['user_name'];


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
  

.assignment-container {
            margin-top: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        .custom-select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            position: relative;
        }
        .custom-select .item {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 5px;
            cursor: pointer;
            position: relative;
        }
        .custom-select .selected {
            background-color: #e6f7ff;
            border-color: #007bff;
        }
        .custom-select .selected::after {
            content: '\f00c';
            font-family: 'FontAwesome';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: green;
            font-size: 18px;
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
        .error-message {
            color: red;
            font-weight: bold;
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
        <h1>Affectation des objectifs</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main-menu.html">Acceuil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestion des evaluations</li>
                <li class="breadcrumb-item active" aria-current="page">Affectation  des objectifs</li>
            </ol>
        </nav>
        <div class="assignment-container">
    <div id="error-message" class="error-message" style="display:none;"></div>
    <form id="assignForm" action="submit_assignments.php" method="POST">
        <div class="form-group">
            <label for="employees">Sélectionnez des salariés</label>
            <div id="employee-select" class="custom-select"></div>
        </div>
        <div class="form-group">
            <label for="objectives">Sélectionnez des objectifs</label>
            <table id="objective-table" class="table">
                <thead>
                    <tr>
                        <th>Sélectionner</th>
                        <th>Description</th>
                        <th>Pondération</th>
                        <th>Date de réalisation</th>
                    </tr>
                </thead>
                <tbody id="objective-select"></tbody>
            </table>
        </div>
        <button type="submit">Affecter</button>
    </form>
</div>


    </div>
    <script>
 $(document).ready(function() {
    $.ajax({
        url: 'fetch_employees_and_objectives.php',
        method: 'GET',
        success: function(data) {
            try {
                var result = JSON.parse(data);
                var employees = result.employees;
                var objectives = result.objectives;

                if (!Array.isArray(employees) || !Array.isArray(objectives)) {
                    throw new Error('Données des employés ou des objectifs non valides.');
                }

                // Remplir la liste déroulante des employés
                employees.forEach(function(employee) {
                    $('#employee-select').append('<div class="item" data-value="'+ employee.matricule +'">'+ employee.nom + ' ' + employee.prenom +'</div>');
                });

                // Remplir le tableau des objectifs
                objectives.forEach(function(objective) {
                    $('#objective-select').append(
                        '<tr data-id="'+ objective.id +'">' +
                            '<td><input type="checkbox" class="objective-checkbox" value="'+ objective.id +'"></td>' +
                            '<td>' + objective.description + '</td>' +
                            '<td><input type="number" name="ponderation[]" value="'+ objective.ponderation +'" step="0.01" min="0" max="100" class="ponderation-input"></td>' +
                            '<td><input type="date" name="date_realisation[]" value="'+ objective.date_realisation +'"></td>' +
                        '</tr>'
                    );
                });

                // Ajouter des événements de clic pour sélectionner les éléments
                $('.item').on('click', function() {
                    $(this).toggleClass('selected');
                });

                // Fonction de validation des pondérations
                function validatePonderation() {
                    var totalPonderation = 0;
                    $('#objective-select .objective-checkbox:checked').each(function() {
                        var row = $(this).closest('tr');
                        var ponderation = parseFloat(row.find('input[name="ponderation[]"]').val());
                        totalPonderation += isNaN(ponderation) ? 0 : ponderation;
                    });

                    return totalPonderation === 100;
                }

                // Manipuler les soumissions de formulaire
                $('#assignForm').on('submit', function(e) {
                    e.preventDefault();

                    if (!validatePonderation()) {
                        $('#error-message').text('La somme totale des pondérations doit être égale à 100.').show();
                        return false;
                    }

                    var selectedEmployees = [];
                    var selectedObjectives = [];

                    // Récupérer les valeurs sélectionnées des employés
                    $('#employee-select .selected').each(function() {
                        selectedEmployees.push($(this).data('value'));
                    });

                    // Récupérer les objectifs sélectionnés
                    $('#objective-select .objective-checkbox:checked').each(function() {
                        var row = $(this).closest('tr');
                        var id = $(this).val();
                        var ponderation = row.find('input[name="ponderation[]"]').val();
                        var dateRealisation = row.find('input[name="date_realisation[]"]').val();
                        if (id) {
                            selectedObjectives.push({ id: id, ponderation: ponderation, date_realisation: dateRealisation });
                        }
                    });

                    // Créer des champs cachés pour soumettre les valeurs
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'employees',
                        value: JSON.stringify(selectedEmployees)
                    }).appendTo('#assignForm');
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'objectives',
                        value: JSON.stringify(selectedObjectives)
                    }).appendTo('#assignForm');

                    this.submit();
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
</body>
</html>
