<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Interface</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Styles pour les sections, les rendre visibles ou non selon leur état actif */
        .section { display: none; }
        .section.active { display: block; }
        /* Styles pour les boutons de navigation */
        .navigation-buttons { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Section pour les Objectifs Transversaux -->
        <div id="section1" class="section active">
            <h2>Objectifs Transversaux</h2>
            <div class="form-group">
                <!-- Champs de formulaire pour ajouter un objectif transversal -->
                <label>Description</label>
                <input type="text" id="objectiveDescription" class="form-control">
                <label>Indicateur de performance</label>
                <input type="text" id="performanceIndicator" class="form-control">
                <label>Pondération</label>
                <input type="number" id="objectiveWeighting" class="form-control">
                <button class="btn btn-primary" onclick="addObjective()">Ajouter Objectif</button>
            </div>
            <!-- Tableau pour afficher les objectifs transversaux -->
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
            <!-- Boutons de navigation pour passer à la section suivante -->
            <div class="navigation-buttons">
                <button class="btn btn-primary" onclick="nextSection(2)">Next</button>
            </div>
        </div>
        
        <!-- Section pour les Performances Quotidiennes -->
        <div id="section2" class="section">
            <h2>Performances Quotidiennes</h2>
            <div class="form-group">
                <!-- Champs de formulaire pour ajouter une performance quotidienne -->
                <label>Description</label>
                <input type="text" id="performanceDescription" class="form-control">
                <label>Pondération</label>
                <input type="number" id="performanceWeighting" class="form-control">
                <button class="btn btn-primary" onclick="addPerformance()">Ajouter Performance</button>
            </div>
            <!-- Tableau pour afficher les performances quotidiennes -->
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
            <!-- Boutons de navigation pour revenir à la section précédente ou passer à la suivante -->
            <div class="navigation-buttons">
                <button class="btn btn-secondary" onclick="previousSection(1)">Back</button>
                <button class="btn btn-primary" onclick="nextSection(3)">Next</button>
            </div>
        </div>

        <!-- Section pour les Compétences -->
        <div id="section3" class="section">
            <h2>Compétences</h2>
            <div class="form-group">
                <!-- Champs de formulaire pour ajouter une compétence -->
                <label>Description</label>
                <input type="text" id="competencyDescription" class="form-control">
                <label>Niveau Requis</label>
                <input type="text" id="requiredLevel" class="form-control">
                <button class="btn btn-primary" onclick="addCompetency()">Ajouter Compétence</button>
            </div>
            <!-- Tableau pour afficher les compétences -->
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
            <!-- Boutons de navigation pour revenir à la section précédente ou enregistrer toutes les données -->
            <div class="navigation-buttons">
                <button class="btn btn-secondary" onclick="previousSection(2)">Back</button>
                <button class="btn btn-success" onclick="saveAll()">Enregistrer</button>
            </div>
        </div>
    </div>

    <script>
        // ID initial pour les objectifs, performances et compétences
        let objectiveId = 1;
        let performanceId = 1;
        let competencyId = 1;

        // Fonction pour passer à la section suivante
        function nextSection(sectionNumber) {
            // Masquer toutes les sections
            document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
            // Afficher la section spécifiée
            document.getElementById(`section${sectionNumber}`).classList.add('active');
        }

        // Fonction pour revenir à la section précédente
        function previousSection(sectionNumber) {
            // Masquer toutes les sections
            document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
            // Afficher la section spécifiée
            document.getElementById(`section${sectionNumber}`).classList.add('active');
        }

        // Fonction pour ajouter un objectif transversal
        function addObjective() {
            const description = document.getElementById('objectiveDescription').value;
            const indicator = document.getElementById('performanceIndicator').value;
            const weighting = document.getElementById('objectiveWeighting').value;

            // Ajouter une nouvelle ligne au tableau des objectifs transversaux
            const table = document.getElementById('transversalObjectivesTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.insertCell(0).innerText = objectiveId++; // ID Objectif
            row.insertCell(1).innerText = description; // Description
            row.insertCell(2).innerText = indicator; // Indicateur de performance
            row.insertCell(3).innerText = weighting; // Pondération
            row.insertCell(4).innerHTML = '<select class="form-control"><option>Actif</option><option>Inactif</option></select>'; // Etat initial
            row.insertCell(5).innerHTML = '<button class="btn btn-warning" onclick="updateObjective(this)">Update</button>'; // Bouton Update
            row.insertCell(6).innerHTML = '<button class="btn btn-danger" onclick="deleteObjective(this)">Delete</button>'; // Bouton Delete
        }

        // Fonction pour supprimer un objectif transversal
        function deleteObjective(button) {
            const row = button.parentElement.parentElement;
            row.parentElement.removeChild(row); // Supprimer la ligne du tableau
        }

        // Fonction pour mettre à jour un objectif transversal
        function updateObjective(button) {
            const row = button.parentElement.parentElement;
            const cells = row.getElementsByTagName('td');

            // Passer en mode édition
            if (button.innerText === 'Update') {
                cells[1].innerHTML = `<input type="text" value="${cells[1].innerText}" class="form-control">`;
                cells[2].innerHTML = `<input type="text" value="${cells[2].innerText}" class="form-control">`;
                cells[3].innerHTML = `<input type="number" value="${cells[3].innerText}" class="form-control">`;
                cells[4].innerHTML = `<select class="form-control">
                    <option ${cells[4].innerText === 'Actif' ? 'selected' : ''}>Actif</option>
                    <option ${cells[4].innerText === 'Inactif' ? 'selected' : ''}>Inactif</option>
                </select>`;
                button.innerText = 'Save'; // Changer le texte du bouton en "Save"
            } else {
                // Enregistrer les modifications
                cells[1].innerText = cells[1].getElementsByTagName('input')[0].value;
                cells[2].innerText = cells[2].getElementsByTagName('input')[0].value;
                cells[3].innerText = cells[3].getElementsByTagName('input')[0].value;
                cells[4].innerText = cells[4].getElementsByTagName('select')[0].value;
                button.innerText = 'Update'; // Revenir à "Update"
            }
        }

        // Fonction pour ajouter une performance quotidienne
        function addPerformance() {
            const description = document.getElementById('performanceDescription').value;
            const weighting = document.getElementById('performanceWeighting').value;

            // Ajouter une nouvelle ligne au tableau des performances quotidiennes
            const table = document.getElementById('dailyPerformanceTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.insertCell(0).innerText = performanceId++; // ID Performance
            row.insertCell(1).innerText = description; // Description
            row.insertCell(2).innerText = weighting; // Pondération
            row.insertCell(3).innerHTML = '<select class="form-control"><option>Actif</option><option>Inactif</option></select>'; // Etat initial
            row.insertCell(4).innerHTML = '<button class="btn btn-warning" onclick="updatePerformance(this)">Update</button>'; // Bouton Update
            row.insertCell(5).innerHTML = '<button class="btn btn-danger" onclick="deletePerformance(this)">Delete</button>'; // Bouton Delete
        }

        // Fonction pour supprimer une performance quotidienne
        function deletePerformance(button) {
            const row = button.parentElement.parentElement;
            row.parentElement.removeChild(row); // Supprimer la ligne du tableau
        }

        // Fonction pour mettre à jour une performance quotidienne
        function updatePerformance(button) {
            const row = button.parentElement.parentElement;
            const cells = row.getElementsByTagName('td');

            // Passer en mode édition
            if (button.innerText === 'Update') {
                cells[1].innerHTML = `<input type="text" value="${cells[1].innerText}" class="form-control">`;
                cells[2].innerHTML = `<input type="number" value="${cells[2].innerText}" class="form-control">`;
                cells[3].innerHTML = `<select class="form-control">
                    <option ${cells[3].innerText === 'Actif' ? 'selected' : ''}>Actif</option>
                    <option ${cells[3].innerText === 'Inactif' ? 'selected' : ''}>Inactif</option>
                </select>`;
                button.innerText = 'Save'; // Changer le texte du bouton en "Save"
            } else {
                // Enregistrer les modifications
                cells[1].innerText = cells[1].getElementsByTagName('input')[0].value;
                cells[2].innerText = cells[2].getElementsByTagName('input')[0].value;
                cells[3].innerText = cells[3].getElementsByTagName('select')[0].value;
                button.innerText = 'Update'; // Revenir à "Update"
            }
        }

        // Fonction pour ajouter une compétence
        function addCompetency() {
            const description = document.getElementById('competencyDescription').value;
            const level = document.getElementById('requiredLevel').value;

            // Ajouter une nouvelle ligne au tableau des compétences
            const table = document.getElementById('competenciesTable').getElementsByTagName('tbody')[0];
            const row = table.insertRow();
            row.insertCell(0).innerText = competencyId++; // ID Compétence
            row.insertCell(1).innerText = description; // Description
            row.insertCell(2).innerText = level; // Niveau Requis
            row.insertCell(3).innerHTML = '<select class="form-control"><option>Actif</option><option>Inactif</option></select>'; // Etat initial
            row.insertCell(4).innerHTML = '<button class="btn btn-warning" onclick="updateCompetency(this)">Update</button>'; // Bouton Update
            row.insertCell(5).innerHTML = '<button class="btn btn-danger" onclick="deleteCompetency(this)">Delete</button>'; // Bouton Delete
        }

        // Fonction pour supprimer une compétence
        function deleteCompetency(button) {
            const row = button.parentElement.parentElement;
            row.parentElement.removeChild(row); // Supprimer la ligne du tableau
        }

        // Fonction pour mettre à jour une compétence
        function updateCompetency(button) {
            const row = button.parentElement.parentElement;
            const cells = row.getElementsByTagName('td');

            // Passer en mode édition
            if (button.innerText === 'Update') {
                cells[1].innerHTML = `<input type="text" value="${cells[1].innerText}" class="form-control">`;
                cells[2].innerHTML = `<input type="text" value="${cells[2].innerText}" class="form-control">`;
                cells[3].innerHTML = `<select class="form-control">
                    <option ${cells[3].innerText === 'Actif' ? 'selected' : ''}>Actif</option>
                    <option ${cells[3].innerText === 'Inactif' ? 'selected' : ''}>Inactif</option>
                </select>`;
                button.innerText = 'Save'; // Changer le texte du bouton en "Save"
            } else {
                // Enregistrer les modifications
                cells[1].innerText = cells[1].getElementsByTagName('input')[0].value;
                cells[2].innerText = cells[2].getElementsByTagName('input')[0].value;
                cells[3].innerText = cells[3].getElementsByTagName('select')[0].value;
                button.innerText = 'Update'; // Revenir à "Update"
            }
        }

        // Fonction pour enregistrer toutes les données (simulé ici)
        function saveAll() {
    if (!validateWeightings()) return;

    const transversalObjectives = collectTableData('transversalObjectivesTable').map(item => ({ ...item, category: 'tache principale' }));
    const dailyPerformance = collectTableData('dailyPerformanceTable').map(item => ({ ...item, category: 'performance quotidienne' }));
    const competencies = collectTableData('competenciesTable').map(item => ({ ...item, category: 'competence' }));

    const data = {
        transversalObjectives,
        dailyPerformance,
        competencies
    };

    console.log('Données envoyées:', JSON.stringify(data)); // Ajout d'un message de débogage

    fetch('saveData.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        console.log('Réponse du serveur:', result);
        alert(result.message);
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue. Veuillez vérifier la console pour plus de détails.');
    });
}
    </script>
</body>
</html>
