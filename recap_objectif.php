<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Objective Summary</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Récapitulatif des Objectifs</h2>
    
    <!-- Filter Section -->
    <div class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <label for="unitSelect">Unité:</label>
                <select class="form-control" id="unitSelect">
                    <option value="">Toutes les unités</option>
                    <option value="Department 1">Department 1</option>
                    <option value="Division A">Division A</option>
                    <option value="Service X">Service X</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="dateRange">Période:</label>
                <input type="text" class="form-control" id="dateRange" placeholder="Select date range">
            </div>
        </div>
    </div>

    <!-- Objectives Table -->
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>ID Objectif</th>
                <th>Description</th>
                <th>Indicateur de Performance</th>
                <th>Pondération</th>
                <th>Unité</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Sample Data Row -->
            <tr>
                <td>1</td>
                <td>Améliorer la satisfaction client</td>
                <td>NPS</td>
                <td>20%</td>
                <td>Department 1</td>
                <td>Applicable</td>
                <td><button class="btn btn-primary btn-sm">Voir</button></td>
            </tr>
            <!-- More rows can be added dynamically -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
