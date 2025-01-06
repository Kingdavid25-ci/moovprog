<?php
// Démarre une nouvelle session ou reprend une session existante
session_start();

// Inclut le fichier de connexion à la base de données
include('db_connection.php');

// Vérifie si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère les valeurs des champs 'matricule' et 'nom' envoyés par le formulaire
    $matricule = $_POST['matricule'];
    $nom = $_POST['nom'];

    // Prépare une requête SQL pour vérifier les identifiants de l'utilisateur
    $query = "SELECT * FROM salarie WHERE matricule = ? AND nom = ?";
    $stmt = $conn->prepare($query); // Prépare la requête SQL
    $stmt->bind_param("ss", $matricule, $nom); // Lie les paramètres de la requête avec les valeurs des champs
    $stmt->execute(); // Exécute la requête
    $result = $stmt->get_result(); // Récupère le résultat de la requête

    // Vérifie si un utilisateur correspondant aux identifiants est trouvé
    if ($result->num_rows == 1) {
       // Stocke le nom et le matricule de l'utilisateur dans les variables de session
    
        $_SESSION['user_name'] = $matricule;
        // Redirige l'utilisateur vers la page principale
        header('Location: main.php');
        exit(); // Termine l'exécution du script
    } else {
        // Définit un message d'erreur si les identifiants sont incorrects
        $error_msg = "Matricule ou nom incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"> <!-- Définit l'encodage des caractères -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Définit la vue et l'échelle pour les appareils mobiles -->
    <title>Évaluation | Connexion</title> <!-- Titre de la page -->
    <link rel="icon" type="image/png" href="images/logo48.png"> <!-- Lien vers l'icône de la page -->
    <!-- Lien vers les fichiers CSS de Bootstrap et FontAwesome -->
    <link rel="stylesheet" href="third-party/bootstrap/bootstrap-3.3.6-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="third-party/font-awesome/font-awesome-4.5.0/css/font-awesome.min.css">
    <style>
        /* Styles CSS pour la mise en page et les éléments de la page */
        body {
            background: url('img/moov-africa.jpg') no-repeat center center fixed; 
            background-size: cover;
            color: rgb(255, 255, 255);
        }
        .navbar {
            background-color: #005BA4;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-logo {
            width: 80px;
            height: 50px;
            margin-right: 10px;
        }
        .panel, .breadcrumb {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
        }
        .page-header, .panel-title, .form-horizontal, .form-control, .btn {
            color: rgb(16, 15, 20);
        }
        .input-group-addon {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .form-control::placeholder {
            color: rgb(10, 7, 9);
        }
        .btn-default {
            background-color: #005BA4;
            border-color: #005BA4;
        }
        .btn-default:hover {
            background-color: #003C7A;
            border-color: #003C7A;
        }
        .alert-warning {
            background-color: rgba(255, 193, 7, 0.5);
            color: black;
        }
        #footer {
            color: white;
        }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        .login-form {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">
                <!-- Logo et titre du système d'évaluation -->
                <a class="navbar-brand" href="#">
                    <img src="https://th.bing.com/th/id/OIP.rN9kss5qfhfxiSxeF1qH_gAAAA?rs=1&pid=ImgDetMain" alt="Moov Africa" class="navbar-logo">
                    Système d'Évaluation Moov-Africa
                </a>
            </div>
        </div>
    </nav>

    <!-- Conteneur pour le formulaire de connexion -->
    <div class="login-container">
        <div class="login-form col-md-4">
            <h2 class="text-center">Connexion</h2>
            <!-- Formulaire de connexion -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nom">Nom</label> <!-- Étiquette pour le champ nom -->
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre nom..." required> <!-- Champ de saisie pour le nom -->
                </div>
                <div class="form-group">
                    <label for="matricule">Matricule</label> <!-- Étiquette pour le champ matricule -->
                    <input type="password" class="form-control" id="matricule" name="matricule" placeholder="Entrez votre matricule..." required> <!-- Champ de saisie pour le matricule -->
                </div>
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button> <!-- Bouton de soumission du formulaire -->
            </form>
            <!-- Affiche un message d'erreur si les identifiants sont incorrects -->
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?= htmlspecialchars($error_msg) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Inclusion des fichiers JavaScript de jQuery et Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
