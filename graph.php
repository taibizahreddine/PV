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

// Requête SQL pour récupérer les statistiques (nombre d'étudiants par sexe)
$query = "SELECT sexe, COUNT(*) AS count FROM formulaire GROUP BY sexe";
$resultat = $connexion->query($query);

if ($resultat) {
    $statsData = array();

    // Parcourir les résultats de la requête
    while ($row = $resultat->fetch_assoc()) {
        $statsData[$row['sexe']] = (int)$row['count'];
    }

    // Envoie des données au format JSON
    echo json_encode($statsData);
} else {
    // Gérer les erreurs de requête
    echo "Erreur dans la requête : " . $connexion->error;
}

// Fermer la connexion à la base de données
$connexion->close();
?>
