<?php
session_start();

// Paramètres de connexion à la base de données
include('db_connection.php');

// Initialiser la variable $units en tant que tableau vide
$units = [];

// Récupérer toutes les unités organisationnelles
$sql = "SELECT id, nom, type, parent_id FROM sructure_entreprise"; // Suppression de la colonne responsable_id
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $units[] = $row;
        }
    }
} else {
    echo "Erreur lors de la récupération des unités : " . $conn->error;
}

// Traiter la soumission du formulaire pour ajouter une nouvelle unité
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nom = $_POST['new-unit-name'];
    $type = $_POST['new-unit-type'];
    $parent_id = $_POST['parent-unit'] ?? null;

    // Préparer et exécuter la requête SQL pour insérer la nouvelle unité
    $sql = "INSERT INTO sructure_entreprise (nom, type, parent_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nom, $type, $parent_id);

    if ($stmt->execute()) {
        echo "Unité ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'unité : " . $conn->error;
    }

    $stmt->close();

    // Redirection après l'insertion
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Traiter la mise à jour d'une unité existante
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['unit-id'];
    $nom = $_POST['unit-name'];
    $type = $_POST['unit-type'];
    $parent_id = $_POST['unit-parent'] ?? null;

    // Préparer et exécuter la requête SQL pour mettre à jour l'unité
    $sql = "UPDATE sructure_entreprise SET nom=?, type=?, parent_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $nom, $type, $parent_id, $id);

    if ($stmt->execute()) {
        echo "Unité mise à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour de l'unité : " . $conn->error;
    }

    $stmt->close();

    // Redirection après la mise à jour
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Traiter la suppression d'une unité existante
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['unit-id'];

    // Préparer et exécuter la requête SQL pour supprimer l'unité
    $sql = "DELETE FROM sructure_entreprise WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Unité supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'unité : " . $conn->error;
    }

    $stmt->close();

    // Redirection après la suppression
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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


<div class="container">
    <h1>Gestion des directions/divisions/services</h1>
    
    <!-- Button to show form for adding a new unit -->
    <button type="button" id="add-unit" class="btn btn-secondary">Ajoutez une unité</button>

    <div id="new-unit-form" style="display: none; margin-top: 20px;">
        <h3>Ajouter une nouvelle unité organisationnelle</h3>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-inline">
            <input type="hidden" name="action" value="add">
            <div class="form-group">
                <label for="new-unit-name">Nom </label>
                <input type="text" id="new-unit-name" name="new-unit-name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="new-unit-type">Type </label>
                <select id="new-unit-type" name="new-unit-type" class="form-control" required>
                    <option value="direction">Direction</option>
                    <option value="sous-direction">Sous-Direction</option>
                    <option value="division">Division</option>
                    <option value="service">Service</option>
                </select>
            </div>
            <div class="form-group">
                <label for="parent-unit">Unité parente</label>
                <select id="parent-unit" name="parent-unit" class="form-control">
                    <option value="">Sélectionner l'unité parente</option>
                    <?php foreach ($units as $unit): ?>
                        <option value="<?php echo $unit['id']; ?>"><?php echo $unit['nom']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer l'unité</button>
        </form>
    </div>

    <h3>Liste des Unités</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Unité Parente</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($units as $unit): ?>
            <tr>
                <td class="editable" data-id="<?php echo $unit['id']; ?>" data-field="nom"><?php echo $unit['nom']; ?></td>
                <td class="editable" data-id="<?php echo $unit['id']; ?>" data-field="type"><?php echo $unit['type']; ?></td>
                <td>
                    <?php 
                    if ($unit['parent_id']) {
                        $parent_name = array_filter($units, function($u) use ($unit) {
                            return $u['id'] === $unit['parent_id'];
                        });
                        echo reset($parent_name)['nom'] ?? '';
                    } else {
                        echo 'N/A';
                    }
                    ?>
                </td>
                <td>
                    <button class="btn btn-warning edit-btn" data-id="<?php echo $unit['id']; ?>">Modifier</button>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="unit-id" value="<?php echo $unit['id']; ?>">
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById('add-unit').addEventListener('click', function() {
        var form = document.getElementById('new-unit-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });

    // JavaScript to toggle between edit and save
    document.querySelectorAll('.edit-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            var id = this.getAttribute('data-id');
            var cells = document.querySelectorAll('tr > td.editable[data-id="' + id + '"]');
            
            if (this.textContent === 'Modifier') {
                // Change text to 'Enregistrer' for saving
                this.textContent = 'Enregistrer';

                cells.forEach(function(cell) {
                    var input = document.createElement('input');
                    input.type = 'text';
                    input.value = cell.textContent;
                    input.setAttribute('data-id', cell.getAttribute('data-id'));
                    input.setAttribute('data-field', cell.getAttribute('data-field'));
                    cell.innerHTML = '';
                    cell.appendChild(input);
                });
            } else {
                // Save changes
                this.textContent = 'Modifier';
                var formData = new FormData();
                formData.append('action', 'update');
                formData.append('unit-id', id);

                cells.forEach(function(cell) {
                    var input = cell.querySelector('input');
                    var value = input.value;
                    var field = input.getAttribute('data-field');
                    formData.append(field, value);
                });

                fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    cells.forEach(function(cell) {
                        var input = cell.querySelector('input');
                        cell.textContent = input.value;
                    });
                });
            }
        });
    });
</script>
</body>
</html>
