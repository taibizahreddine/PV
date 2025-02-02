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

// Récupération de l'ID de recherche depuis l'URL
if (isset($_GET['recherche_id'])) {
    $recherche_id = $_GET['recherche_id'];

    // Requête SQL pour récupérer le nom, prénom et filière de l'étudiant depuis la table "formulaire"
    $query = "SELECT Nom_module, coefficient, code_module, Note FROM notes ";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows > 0) {
            echo "<h2>Liste des notes de l'étudiant $recherche_id :</h2>";

            // Initialisation des totaux
            $totalCoefficients = 0;
            $totalNotes = 0;

            // Affichage du tableau
            echo "<table border='1'>";
            echo "<tr><th>Nom module</th><th>Coefficient</th><th>Code module</th><th>Note</th></tr>";

            while ($row = $resultat->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Nom_module'] . "</td>";
                echo "<td>" . $row['coefficient'] . "</td>";
                echo "<td>" . $row['code_module'] . "</td>";
                echo "<td>" . $row['Note'] . "</td>";
                echo "</tr>";

                // Ajouter la note et le coefficient aux totaux
                $totalCoefficients += $row['coefficient'];
                $totalNotes += $row['Note'];
            }

            // Ajouter une ligne pour la somme des coefficients et des notes
            echo "<tr>";
            echo "<td colspan='3'>Somme des coefficients</td>";
            echo "<td>$totalCoefficients</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td colspan='3'>Somme des notes</td>";
            echo "<td>$totalNotes</td>";
            echo "</tr>";

            // Calculer et afficher la moyenne
            $nombreNotes = $resultat->num_rows;
            if ($nombreNotes > 0) {
                $moyenne = $totalNotes / $nombreNotes;
                echo "<tr><td colspan='3'>Moyenne</td><td>$moyenne</td></tr>";
            } else {
                echo "<tr><td colspan='4'>Aucune note disponible pour calculer la moyenne.</td></tr>";
            }

            // Fermeture du tableau
            echo "</table>";
        } else {
            echo "<p>Aucune note trouvée dans la base de données.</p>";
        }
    } else {
        echo "<p>Erreur dans la requête : " . $connexion->error . "</p>";
    }
}

$connexion->close();
?>
