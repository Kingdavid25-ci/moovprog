<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Récapitulatif des Évaluations</title>
    <style>
        .container {
            margin-top: 20px;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Récapitulatif des Évaluations</h2>
        <div class="form-group">
            <label for="uniteFilter">Filtrer par Unité :</label>
            <select id="uniteFilter" class="form-control">
                <option value="">Toutes les Unités</option>
                <!-- Remplir avec les unités disponibles -->
                <option value="unite1">Unité 1</option>
                <option value="unite2">Unité 2</option>
                <!-- Ajoutez d'autres unités ici -->
            </select>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID Objectif</th>
                        <th>Description</th>
                        <th>Indicateur de Performance</th>
                        <th>Pondération</th>
                        <th>Statut</th>
                        <th>Commentaires</th>
                        <th>Unité</th>
                    </tr>
                </thead>
                <tbody id="evaluationTableBody">
                    <!-- Les lignes de la table seront générées dynamiquement -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Exemple de données
        const evaluations = [
            { id: 1, description: 'Objectif 1', indicateur: 'Indicateur 1', ponderation: 20, statut: 'Actif', commentaires: 'Commentaire 1', unite: 'unite1' },
            { id: 2, description: 'Objectif 2', indicateur: 'Indicateur 2', ponderation: 30, statut: 'Non Applicable', commentaires: 'Commentaire 2', unite: 'unite2' },
            // Ajoutez d'autres évaluations ici
        ];

        function afficherEvaluations(filtreUnite = '') {
            const tableBody = document.getElementById('evaluationTableBody');
            tableBody.innerHTML = ''; // Vider le contenu précédent

            evaluations.forEach(evaluation => {
                if (filtreUnite === '' || evaluation.unite === filtreUnite) {
                    const row = `<tr>
                        <td>${evaluation.id}</td>
                        <td>${evaluation.description}</td>
                        <td>${evaluation.indicateur}</td>
                        <td>${evaluation.ponderation}</td>
                        <td>${evaluation.statut}</td>
                        <td>${evaluation.commentaires}</td>
                        <td>${evaluation.unite}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                }
            });
        }

        document.getElementById('uniteFilter').addEventListener('change', function() {
            afficherEvaluations(this.value);
        });

        // Initialisation
        afficherEvaluations();
    </script>
</body>
</html>
