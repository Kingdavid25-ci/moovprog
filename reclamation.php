<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <!-- Card container -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Formulaire de Réclamation</h4>
            </div>
            <div class="card-body">
                <p class="card-text">Veuillez remplir les détails de votre réclamation ci-dessous :</p>
                
                <form action="traiter_reclamation.php" method="POST">
                    <!-- Réclamation textarea -->
                    <div class="mb-4">
                        <label for="reclamation" class="form-label">Votre Réclamation :</label>
                        <textarea class="form-control" id="reclamation" name="reclamation" rows="4" required></textarea>
                    </div>
                    
                    <!-- Submit button -->
                    <button type="submit" class="btn btn-success w-100">Envoyer la Réclamation</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
