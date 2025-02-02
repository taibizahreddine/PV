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

    // Requête SQL pour rechercher les informations par ID
    $query = "SELECT * FROM informations WHERE id = $recherche_id";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows > 0) {
            // Afficher les informations trouvées
            while ($row = $resultat->fetch_assoc()) {
                echo "Informations trouvées pour l'ID $recherche_id :<br>";
                echo "Nom : " . $row['nom'] . "<br>";
                echo "Prénom : " . $row['prenom'] . "<br>";
                echo "Adresse : " . $row['adresse'] . "<br>";
                echo "email : " . $row['email'] . "<br>";
                echo "lieu de naissance : " . $row['lieu_naissance'] . "<br>";
                echo "Date de naissance : " . $row['date_naissance'] . "<br>";
                echo "Grade : " . $row['gra'] . "<br>";
                echo "Specialite: " . $row['spec'] . "<br>";
                echo "Code Postal : " . $row['cod_post'] . "<br>";
                echo "Nationalité : " . $row['nat'] . "<br>";
                echo "Situation : " . $row['situ'] . "<br>";
                echo "Système : " . $row['systeme'] . "<br>";
                echo "Pays : " . $row['cod'] . "<br>";
                echo "Applications : " . $row['applications'] . "<br>";
                echo "Sexe : " . $row['sexe'] . "<br>";
                echo "<tr><a href='modif.php?id=" . $row['id'] . "'>Modifier</a></tr><br><br>";
                echo "<tr><a href='supp.php?id=" . $row['id'] . "'>Supprimer</a></tr>";
              
                
            }
        } else {
            echo "Aucune information trouvée pour l'ID $recherche_id.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}

$connexion->close();
?>
