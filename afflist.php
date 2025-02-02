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
$query = "SELECT * FROM notes";
$resultat = $connexion->query($query);

if ($resultat) {
    if ($resultat->num_rows > 0) {
        echo "<h2>Liste complète des notes' :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Num_Etudiant</th><th>Nom_module</th><th>fil</th><th>code_module</th><th>coefficient</th><th>Note</th></tr>";

        while ($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Num_Etudiant'] . "</td>";
            echo "<td>" . $row['Nom_module'] . "</td>";
            echo "<td>" . $row['fil'] . "</td>";
            echo "<td>" . $row['code_module'] . "</td>";
            echo "<td>" . $row['coefficient'] . "</td>";
            echo "<td>" . $row['Note'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Aucun enregistrement trouvé dans la table 'notes'.</p>";
    }
} else {
    echo "<p>Erreur dans la requête : " . $connexion->error . "</p>";
}

$connexion->close();
?>
