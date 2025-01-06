<?php
// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
//$dbname = "moov_africa_test";
$dbname = "moovprog";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Récupérer le matricule du salarié sélectionné
$matricule = $_GET['matricule'];

$tachePrincipaleData = "";
$performanceQuotidienneData = "";
$competenceData = "";

// Fetch Tâche Principale data
$tachePrincipale = $conn->prepare("SELECT o.id, o.description, o.indicateur_performance, e.ponderation, e.AUTO_EVALUATION_PERFORM FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'tache principale'");
$tachePrincipale->bind_param("i", $matricule);
$tachePrincipale->execute();
$tachePrincipaleResult = $tachePrincipale->get_result();

while ($row = $tachePrincipaleResult->fetch_assoc()) {
    $tachePrincipaleData .= "<tr>
                                <td>{$row['description']}</td>
                                <td>{$row['indicateur_performance']}</td>
                                <td>{$row['ponderation']}</td>
                                <td>{$row['AUTO_EVALUATION_PERFORM']}</td>
                                <td><input type='text' name='note[{$row['id']}]'></td>
                             </tr>";
}

$tachePrincipale->close();

// Fetch Performance Quotidienne data
$performanceQuotidienne = $conn->prepare("SELECT o.id, o.description, o.ponderation, e.AUTO_EVALUATION_PERFORM FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'performance quotidienne'");
$performanceQuotidienne->bind_param("i", $matricule);
$performanceQuotidienne->execute();
$performanceQuotidienneResult = $performanceQuotidienne->get_result();

while ($row = $performanceQuotidienneResult->fetch_assoc()) {
    $performanceQuotidienneData .= "<tr>
                                        <td>{$row['description']}</td>
                                        <td>{$row['ponderation']}</td>
                                        <td>{$row['AUTO_EVALUATION_PERFORM']}</td>
                                        <td><input type='text' name='note[{$row['id']}]'></td>
                                    </tr>";
}

$performanceQuotidienne->close();


// Fetch Compétence data
$competence = $conn->prepare("SELECT o.id, o.description, o.niveau_requis, e.AUTO_EVALUATION_PERFORM FROM objectif o JOIN evaluation e ON o.id = e.ID_OBJECTIF WHERE e.MATRICULE = ? AND o.categorie = 'competence '");
$competence->bind_param("s", $matricule);
$competence->execute();
$competenceResult = $competence->get_result();

while ($row = $competenceResult->fetch_assoc()) {
    $competenceData .= "<tr>
                            <td>{$row['description']}</td>
                            <td class='niveau-requis'>{$row['niveau_requis']}</td>
                            <td><input type='number' class='form-control niveau-capacite' name='capacite[{$row['id']}]' oninput='calculateCapacityLacunes(this.closest(\"tr\"))'></td>
                            <td class='capacite-lacunes'>0</td>
                            <td><input type='text' name='commentaire[{$row['id']}]' class='form-control'></td>
                        </tr>";
}

$competence->close();
$conn->close();

// Return the data as a JSON object
echo json_encode([
    "tachePrincipale" => $tachePrincipaleData,
    "performanceQuotidienne" => $performanceQuotidienneData,
    "competence" => $competenceData,
]);
?> 