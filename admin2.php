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
      </div>
    </nav>
    <div class="background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 800px;
    margin: 0 auto;">
    <div class="container">
        <h1> Création des élements de base </h1>
      
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main-menu.html">Acceuil</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gestion des evaluation</li>
                <li class="breadcrumb-item active" aria-current="page">Creation  des objectifs</li>
            </ol>
        </nav>
         <!-- Section Objectifs Transversaux -->
         <div id="section1" class="section active">
            <h3>Objectifs Transversaux</h3>
            <form id="addObjectiveForm" class="form-inline">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" id="objectiveDescription" class="form-control">
                </div>
                <div class="form-group">
                    <label>Indicateur de performance</label>
                    <input type="text" id="performanceIndicator" class="form-control">
                </div>
                <div class="form-group">
                    <label>Pondération</label>
                    <input type="number" id="objectiveWeighting" class="form-control">
                </div>
                <button type="button" class="btn btn-primary" onclick="addObjective()">Ajouter</button>
            </form>
            <br>
            <table class="table table-bordered" id="transversalObjectivesTable">
                <thead>
                    <tr>
                        <th>ID Objectif</th>
                        <th>Description</th>
                        <th>Indicateur de performance</th>
                        <th>Pondération</th>
                        <th>Etat</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="navigation-buttons">
                <button class="btn btn-primary" onclick="nextSection(2)">Suivant</button>
            </div>
        </div>
        
        <!-- Section Performances Quotidiennes -->
        <div id="section2" class="section">
            <h3>Performances Quotidiennes</h3>
            <form id="addPerformanceForm" class="form-inline">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" id="performanceDescription" class="form-control">
                </div>
                <div class="form-group">
                    <label>Pondération</label>
                    <input type="number" id="performanceWeighting" class="form-control">
                </div>
                <button type="button" class="btn btn-primary" onclick="addPerformance()">Ajouter Performance</button>
            </form>
            <br>
            <table class="table table-bordered" id="dailyPerformanceTable">
                <thead>
                    <tr>
                        <th>ID Performance</th>
                        <th>Description</th>
                        <th>Pondération</th>
                        <th>Etat</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="navigation-buttons">
                <button class="btn btn-secondary" onclick="previousSection(1)">Précedent</button>
                <button class="btn btn-primary" onclick="nextSection(3)">Suivant</button>
            </div>
        </div>

        <!-- Section Compétences -->
        <div id="section3" class="section">
            <h3>Compétences</h3>
            <form id="addCompetencyForm" class="form-inline">
                <div class="form-group">
                    <label>Description</label>
                    <input type="text" id="competencyDescription" class="form-control">
                </div>
                <div class="form-group">
                    <label>Niveau Requis</label>
                    <input type="text" id="requiredLevel" class="form-control">
                </div>
                <button type="button" class="btn btn-primary" onclick="addCompetency()">Ajouter Compétence</button>
            </form>
            <br>
            <table class="table table-bordered" id="competenciesTable">
                <thead>
                    <tr>
                        <th>ID Compétence</th>
                        <th>Description</th>
                        <th>Niveau Requis</th>
                        <th>Etat</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="navigation-buttons">
                <button class="btn btn-secondary" onclick="previousSection(2)">Précedent</button>
                <button class="btn btn-primary" onclick="previousSection(4)">Suivant</button>
            </div>
        </div>
        <!-- Section Développement des Performances -->
<div id="section4" class="section">
    <h3>Développement des Performances</h3>
    <form id="addDevelopmentQuestionForm" class="form-inline">
        <div class="form-group">
            <label>Question</label>
            <input type="text" id="developmentQuestion" class="form-control" placeholder="Entrez votre question">
        </div>
        <button type="button" class="btn btn-primary" onclick="addDevelopmentQuestion()">Ajouter Question</button>
    </form>
    <br>
    <table class="table table-bordered" id="developmentQuestionsTable">
        <thead>
            <tr>
                <th>ID Question</th>
                <th>Question</th>
                <th>Etat</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="navigation-buttons">
        <button class="btn btn-secondary" onclick="previousSection(3)">Précedent</button>
        <button class="btn btn-success" onclick="saveAll()">Enregistrer</button>
    </div>
</div>

    </div>

    <script>
        let objectiveId = 1;
        let performanceId = 1;
        let competencyId = 1;
        let questionId = 1;

function addDevelopmentQuestion() {
    const question = document.getElementById('developmentQuestion').value;

    if (!question) {
        alert("Veuillez remplir le champ de la question.");
        return;
    }

    const table = document.getElementById('developmentQuestionsTable').getElementsByTagName('tbody')[0];
    const row = table.insertRow();
    row.insertCell(0).innerText = questionId++;
    row.insertCell(1).innerText = question;
    row.insertCell(2).innerHTML = '<select class="form-control"><option>Actif</option><option>Inactif</option></select>';
    row.insertCell(3).innerHTML = '<button class="btn btn-warning" onclick="updateQuestion(this)">Update</button>';
    row.insertCell(4).innerHTML = '<button class="btn btn-danger" onclick="deleteQuestion(this)">Delete</button>';

    document.getElementById('developmentQuestion').value = '';
}

function updateQuestion(button) {
    const row = button.parentElement.parentElement;
    const cells = row.getElementsByTagName('td');

    if (button.innerText === 'Update') {
        cells[1].innerHTML = `<input type="text" value="${cells[1].innerText}" class="form-control">`;
        cells[2].innerHTML = `<select class="form-control">
            <option ${cells[2].innerText === 'Actif' ? 'selected' : ''}>Actif</option>
            <option ${cells[2].innerText === 'Inactif' ? 'selected' : ''}>Inactif</option>
        </select>`;
        button.innerText = 'Save';
    } else {
        cells[1].innerText = cells[1].getElementsByTagName('input')[0].value;
        cells[2].innerText = cells[2].getElementsByTagName('select')[0].value;
        button.innerText = 'Update';
    }
}

function deleteQuestion(button) {
    const row = button.parentElement.parentElement;
    row.parentElement.removeChild(row);
}


        function nextSection(sectionNumber) {
            document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
            document.getElementById(`section${sectionNumber}`).classList.add('active');
        }

        function previousSection(sectionNumber) {
            document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
            document.getElementById(`section${sectionNumber}`).classList.add('active');
        }

        function addObjective() {
            const description = document.getElementById('objectiveDescription').value;
            const indicator = document.getElementById('performanceIndicator').value;
            const weighting = parseFloat(document.getElementById('objectiveWeighting').value);

            if (!description || !indicator || isNaN(weighting)) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            const table = document.getElementById('transversalObjectivesTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.insertCell(0).innerText = objectiveId++;
            row.insertCell(1).innerText = description;
            row.insertCell(2).innerText = indicator;
            row.insertCell(3).innerText = weighting;
            row.insertCell(4).innerHTML = '<select class="form-control"><option>Actif</option><option>Inactif</option></select>';
            row.insertCell(5).innerHTML = '<button class="btn btn-warning" onclick="updateObjective(this)">Update</button>';
            row.insertCell(6).innerHTML = '<button class="btn btn-danger" onclick="deleteObjective(this)">Delete</button>';

            document.getElementById('objectiveDescription').value = '';
            document.getElementById('performanceIndicator').value = '';
            document.getElementById('objectiveWeighting').value = '';
        }

        function deleteObjective(button) {
            const row = button.parentElement.parentElement;
            row.parentElement.removeChild(row);
        }

        function updateObjective(button) {
            const row = button.parentElement.parentElement;
            const cells = row.getElementsByTagName('td');

            if (button.innerText === 'Update') {
                cells[1].innerHTML = `<input type="text" value="${cells[1].innerText}" class="form-control">`;
                cells[2].innerHTML = `<input type="text" value="${cells[2].innerText}" class="form-control">`;
                cells[3].innerHTML = `<input type="number" value="${cells[3].innerText}" class="form-control">`;
                cells[4].innerHTML = `<select class="form-control">
                    <option ${cells[4].innerText === 'Actif' ? 'selected' : ''}>Actif</option>
                    <option ${cells[4].innerText === 'Inactif' ? 'selected' : ''}>Inactif</option>
                </select>`;
                button.innerText = 'Save';
            } else {
                cells[1].innerText = cells[1].getElementsByTagName('input')[0].value;
                cells[2].innerText = cells[2].getElementsByTagName('input')[0].value;
                cells[3].innerText = cells[3].getElementsByTagName('input')[0].value;
                cells[4].innerText = cells[4].getElementsByTagName('select')[0].value;
                button.innerText = 'Update';
            }
        }

        function addPerformance() {
            const description = document.getElementById('performanceDescription').value;
            const weighting = parseFloat(document.getElementById('performanceWeighting').value);

            if (!description || isNaN(weighting)) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            const table = document.getElementById('dailyPerformanceTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.insertCell(0).innerText = performanceId++;
            row.insertCell(1).innerText = description;
            row.insertCell(2).innerText = weighting;
            row.insertCell(3).innerHTML = '<select class="form-control"><option>Actif</option><option>Inactif</option></select>';
            row.insertCell(4).innerHTML = '<button class="btn btn-warning" onclick="updatePerformance(this)">Update</button>';
            row.insertCell(5).innerHTML = '<button class="btn btn-danger" onclick="deletePerformance(this)">Delete</button>';

            document.getElementById('performanceDescription').value = '';
            document.getElementById('performanceWeighting').value = '';
        }

        function deletePerformance(button) {
            const row = button.parentElement.parentElement;
            row.parentElement.removeChild(row);
        }

        function updatePerformance(button) {
            const row = button.parentElement.parentElement;
            const cells = row.getElementsByTagName('td');

            if (button.innerText === 'Update') {
                cells[1].innerHTML = `<input type="text" value="${cells[1].innerText}" class="form-control">`;
                cells[2].innerHTML = `<input type="number" value="${cells[2].innerText}" class="form-control">`;
                cells[3].innerHTML = `<select class="form-control">
                    <option ${cells[3].innerText === 'Actif' ? 'selected' : ''}>Actif</option>
                    <option ${cells[3].innerText === 'Inactif' ? 'selected' : ''}>Inactif</option>
                </select>`;
                button.innerText = 'Save';
            } else {
                cells[1].innerText = cells[1].getElementsByTagName('input')[0].value;
                cells[2].innerText = cells[2].getElementsByTagName('input')[0].value;
                cells[3].innerText = cells[3].getElementsByTagName('select')[0].value;
                button.innerText = 'Update';
            }
        }

        function addCompetency() {
            const description = document.getElementById('competencyDescription').value;
            const level = document.getElementById('requiredLevel').value;

            if (!description || !level) {
                alert("Veuillez remplir tous les champs.");
                return;
            }

            const table = document.getElementById('competenciesTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.insertCell(0).innerText = competencyId++;
            row.insertCell(1).innerText = description;
            row.insertCell(2).innerText = level;
            row.insertCell(3).innerHTML = '<select class="form-control"><option>Actif</option><option>Inactif</option></select>';
            row.insertCell(4).innerHTML = '<button class="btn btn-warning" onclick="updateCompetency(this)">Update</button>';
            row.insertCell(5).innerHTML = '<button class="btn btn-danger" onclick="deleteCompetency(this)">Delete</button>';

            document.getElementById('competencyDescription').value = '';
            document.getElementById('requiredLevel').value = '';
        }

        function deleteCompetency(button) {
            const row = button.parentElement.parentElement;
            row.parentElement.removeChild(row);
        }

        function updateCompetency(button) {
            const row = button.parentElement.parentElement;
            const cells = row.getElementsByTagName('td');

            if (button.innerText === 'Update') {
                cells[1].innerHTML = `<input type="text" value="${cells[1].innerText}" class="form-control">`;
                cells[2].innerHTML = `<input type="text" value="${cells[2].innerText}" class="form-control">`;
                cells[3].innerHTML = `<select class="form-control">
                    <option ${cells[3].innerText === 'Actif' ? 'selected' : ''}>Actif</option>
                    <option ${cells[3].innerText === 'Inactif' ? 'selected' : ''}>Inactif</option>
                </select>`;
                button.innerText = 'Save';
            } else {
                cells[1].innerText = cells[1].getElementsByTagName('input')[0].value;
                cells[2].innerText = cells[2].getElementsByTagName('input')[0].value;
                cells[3].innerText = cells[3].getElementsByTagName('select')[0].value;
                button.innerText = 'Update';
            }
        }

       
        function saveAll() {
    const objectiveRows = Array.from(document.querySelectorAll('#transversalObjectivesTable tbody tr'));
    const performanceRows = Array.from(document.querySelectorAll('#dailyPerformanceTable tbody tr'));
    const competencyRows = Array.from(document.querySelectorAll('#competenciesTable tbody tr'));
    const developmentQuestionRows = Array.from(document.querySelectorAll('#developmentQuestionsTable tbody tr'));

    let totalObjectiveWeighting = 0;
    let totalPerformanceWeighting = 0;

    const objectives = [];
    const performances = [];
    const competencies = [];
    const development = [];

    objectiveRows.forEach(row => {
        totalObjectiveWeighting += parseFloat(row.cells[3].innerText);
        objectives.push({
            description: row.cells[1].innerText,
            indicator: row.cells[2].innerText,
            weighting: parseFloat(row.cells[3].innerText),
            etat: row.cells[4].innerText
        });
    });

    performanceRows.forEach(row => {
        totalPerformanceWeighting += parseFloat(row.cells[2].innerText);
        performances.push({
            description: row.cells[1].innerText,
            weighting: parseFloat(row.cells[2].innerText),
            etat: row.cells[3].innerText
        });
    });

    competencyRows.forEach(row => {
        competencies.push({
            description: row.cells[1].innerText,
            requiredLevel: row.cells[2].innerText,
            etat: row.cells[3].innerText
        });
    });

    developmentQuestionRows.forEach(row => {
        development.push({
            description: row.cells[1].innerText,
            etat: row.cells[2].innerText
        });
    });

    if (totalObjectiveWeighting !== 100) {
        alert(`La somme des pondérations des objectifs transversaux doit être égale à 100%. Actuellement: ${totalObjectiveWeighting}%`);
        return;
    }

    if (totalPerformanceWeighting !== 100) {
        alert(`La somme des pondérations des performances quotidiennes doit être égale à 100%. Actuellement: ${totalPerformanceWeighting}%`);
        return;
    }

    const data = {
        objectives,
        performances,
        competencies,
        development
    };

    fetch('save_data.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            alert('Données sauvegardées avec succès !');
        } else {
            alert(`Erreur lors de la sauvegarde des données: ${result.message}\nErreurs: ${result.errors.join(', ')}`);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert(`Erreur lors de la sauvegarde des données.`);
    });
}
 
        
</script>

</body>
</html>