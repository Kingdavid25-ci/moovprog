<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_name'])) {
    header('Location: login.php');
    exit();
}

// MATRICULE de l'utilisateur connecté
$MATRICULE = $_SESSION['user_name'];

// Récupérer l'ID du poste de l'utilisateur connecté depuis la table `affectation`
$sql = "SELECT id_poste FROM affectation WHERE matricule = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MATRICULE);
$stmt->execute();
$stmt->bind_result($id_poste);
$stmt->fetch();
$stmt->close();

if (!$id_poste) {
    die("Erreur : ID du poste non trouvé pour l'utilisateur connecté.");
}

// Fonction pour récupérer les subordonnés directs
if (!function_exists('getSubordinatesDirect')) {
    function getSubordinatesDirect($conn, $superior) {
        $subordinates = [];
        $sql = "SELECT s.matricule, s.nom, s.prenom 
                FROM salarie s
                JOIN affectation a ON s.matricule = a.matricule
                WHERE s.superieur_hierarchique = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $superior);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $subordinates[] = $row;
        }
        $stmt->close();
        return $subordinates;
    }
}

// Fonction pour récupérer uniquement les subordonnés indirects
if (!function_exists('getSubordinates')) {
    function getSubordinates($conn, $superior) {
        $indirect_subordinates = [];
        
        // Récupérer d'abord les subordonnés directs
        $direct_subordinates = getSubordinatesDirect($conn, $superior);
        
        // Pour chaque subordonné direct, récupérer leurs subordonnés
        foreach ($direct_subordinates as $subordinate) {
            // Récupérer l'id_poste du subordonné
            $sql = "SELECT id_poste FROM affectation WHERE matricule = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $subordinate['matricule']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            
            if ($row) {
                // Récupérer uniquement les subordonnés directs de ce subordonné
                $sub_subordinates = getSubordinatesDirect($conn, $row['id_poste']);
                $indirect_subordinates = array_merge($indirect_subordinates, $sub_subordinates);
            }
        }
        
        return $indirect_subordinates;
    }
}

// Récupérer les subordonnés des subordonnés de l'utilisateur connecté
$subordinates = getSubordinates($conn, $id_poste);
?>

<?php if (!empty($subordinates)): ?>
<div class="container">
    <h3>Liste des subordonnés</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subordinates as $subordinate): ?>
                <tr>
                    <td><?php echo htmlspecialchars($subordinate['matricule']); ?></td>
                    <td><a href="details_evaluation.php?matricule=<?php echo htmlspecialchars($subordinate['matricule']); ?>"><?php echo htmlspecialchars($subordinate['nom']); ?></a></td>
                    <td><?php echo htmlspecialchars($subordinate['prenom']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>