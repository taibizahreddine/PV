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

// Requête SQL pour calculer les moyennes des étudiants
$query = "SELECT f.nom, f.prenom, AVG(n.Note) as moyenne 
          FROM formulaire f 
          LEFT JOIN notes n ON f.id = n.Num_Etudiant 
          GROUP BY f.id";

$result = $connexion->query($query);

if ($result) {
    $statsData = array('admis' => 0, 'ajourné' => 0);

    while ($row = $result->fetch_assoc()) {
        $moyenne = round($row['moyenne'], 2); // Arrondir la moyenne à deux décimales

        // Comparer la moyenne à 10 et classer l'étudiant comme 'admis' ou 'ajourné'
        if ($moyenne >= 10) {
            $statsData['admis']++;
        } else {
            $statsData['ajourné']++;
        }
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
