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

// Requête SQL pour récupérer tous les enregistrements de la table "notes"
$query = "SELECT * FROM utilisateur";
$resultat = $connexion->query($query);

if ($resultat) {
    if ($resultat->num_rows > 0) {
        echo "<h2>Liste complète des utilisateurs' :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>email</th><th>mdp</th><th>types</th>";

        while ($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['mdp'] . "</td>";
            echo "<td>" . $row['types'] . "</td>";
           
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Aucun enregistrement trouvé dans la table 'utilisateur'.</p>";
    }
} else {
    echo "<p>Erreur dans la requête : " . $connexion->error . "</p>";
}

$connexion->close();
?>
