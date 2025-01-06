<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évaluation des Employés</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #667eea, #764ba2);
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            box-shadow: 0 12px 28px rgba(31, 38, 135, 0.37);
            padding: 30px;
            width: 100%;
            max-width: 1100px;
            margin-top: 20px;
        }

        h1 {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
            font-size: 2.5rem;
            margin-bottom: 30px;
            text-align: center;
            color: #4a4a4a;
        }

        .form-inline .form-group {
            margin-bottom: 20px;
        }

        .table-container {
            margin-top: 30px;
            overflow-x: auto;
        }

        table {
            background-color: rgba(255, 255, 255, 0.95);
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: #764ba2;
            color: #fff;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            font-weight: bold;
            position: sticky;
            top: 0;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn-primary:hover {
            background-color: #5555c1;
        }

        .custom-select {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Évaluation des Employés</h1>
        <form id="filterForm" class="form-inline justify-content-center">
            <div class="form-group mx-sm-3 mb-2">
                <label for="categorie" class="mr-2"><i class="fas fa-filter"></i> Catégorie :</label>
                <select class="custom-select" id="categorie">
                    <option value="tache principale">Tâche Principale</option>
                    <option value="performance quotidienne">Performance Quotidienne</option>
                    <option value="competence ">Compétence</option>
                </select>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <label for="unite" class="mr-2"><i class="fas fa-building"></i> Unité :</label>
                <select class="custom-select" id="unite">
                    <option value="">Toutes les unités</option>
                    <!-- Remplir avec les unités réelles de votre base de données -->
                </select>
            </div>
            <button type="button" class="btn btn-primary mb-2" onclick="fetchEvaluations()"><i class="fas fa-search"></i> Filtrer</button>
        </form>

        <div class="table-container">
            <table id="evaluationTable" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr id="tableHeader">
                        <!-- En-têtes dynamiques remplis par JavaScript -->
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Corps de tableau dynamique rempli par JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
         $(document).ready(function() {
        // Charger les unités lors du chargement de la page
        $.get('get_units.php', function(data) {
            const units = JSON.parse(data);
            let options = '<option value="">Toutes les unités</option>';
            units.forEach(unit => {
                options += `<option value="${unit.id}">${unit.nom}</option>`;
            });
            $('#unite').html(options);
        });

        // 
    });
        function fetchEvaluations() {
            const categorie = $('#categorie').val();
            const unite = $('#unite').val();

            $.get('filter_evaluation.php', { categorie: categorie, unite: unite }, function (data) {
                const evaluations = JSON.parse(data);
                renderTable(categorie, evaluations);
            });
        }

        function renderTable(categorie, evaluations) {
            let headerHtml = '';
            let bodyHtml = '';

            if (categorie === 'tache principale') {
                headerHtml = `
                    <th>MATRICULE</th>
                    <th>Description</th>
                    <th>Indicateur de Performance</th>
                    <th>Pondération</th>
                    <th>Date de Réalisation</th>
                    <th>Auto-évaluation</th>
                    <th>Note de l'Évaluateur</th>
                    <th>Catégorie</th>
                    <th>Unité</th>
                `;
                evaluations.forEach(ev => {
                    bodyHtml += `
                        <tr>
                            <td>${ev.MATRICULE}</td>
                            <td>${ev.description}</td>
                            <td>${ev.indicateur_performance}</td>
                            <td>${ev.ponderation}</td>
                            <td>${ev.date_realisation}</td>
                            <td>${ev.autoevaluation_objectif}</td>
                            <td>${ev.note_objectif}</td>
                            <td>${ev.categorie}</td>
                            <td>${ev.nom_unite}</td>
                        </tr>
                    `;
                });
            } else if (categorie === 'performance quotidienne') {
                headerHtml = `
                    <th>MATRICULE</th>
                    <th>Description</th>
                    <th>Pondération</th>
                    <th>Auto-évaluation</th>
                    <th>Note de l'Évaluateur</th>
                    <th>Catégorie</th>
                    <th>Unité</th>
                `;
                evaluations.forEach(ev => {
                    bodyHtml += `
                        <tr>
                            <td>${ev.MATRICULE}</td>
                            <td>${ev.description}</td>
                            <td>${ev.ponderation}</td>
                            <td>${ev.AUTO_EVALUATION_PERFORM}</td>
                            <td>${ev.note_evaluateur}</td>
                            <td>${ev.categorie}</td>
                            <td>${ev.nom_unite}</td>
                        </tr>
                    `;
                });
            } else if (categorie === 'competence ') {
                headerHtml = `
                    <th>MATRICULE</th>
                    <th>Description</th>
                    <th>Niveau Requis</th>
                    <th>Niveau de Capacité</th>
                    <th>Commentaire</th>
                    <th>Capacité et Lacunes</th>
                    <th>Catégorie</th>
                    <th>Unité</th>
                `;
                evaluations.forEach(ev => {
                    bodyHtml += `
                        <tr>
                            <td>${ev.MATRICULE}</td>
                            <td>${ev.description}</td>
                            <td>${ev.niveau_requis}</td>
                            <td>${ev.niveau_capacite}</td>
                            <td>${ev.commentaire}</td>
                            <td>${ev.capacite_lacune}</td>
                            <td>${ev.categorie}</td>
                            <td>${ev.nom_unite}</td>
                        </tr>
                    `;
                });
            }

            $('#tableHeader').html(headerHtml);
            $('#tableBody').html(bodyHtml);
        }
    </script>
</body>

</html>
