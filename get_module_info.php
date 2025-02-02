<?php
// Connexion à la base de données (à adapter avec vos paramètres)
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "tppaw";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['module'])) {
    $selectedModule = $connexion->real_escape_string($_POST['module']);

    // Requête SQL pour récupérer les informations du module depuis la table "notes"
    $query = "SELECT coefficient, code_module FROM notes WHERE Nom_module = '$selectedModule'";
    $result = $connexion->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $moduleInfo = array(
            'coefficient' => $row['coefficient'],
            'code_module' => $row['code_module']
        );
        echo json_encode($moduleInfo);
        exit;
    }
}

$connexion->close();
?>
