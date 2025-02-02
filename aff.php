<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "tppaw";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

function afficherFormulaireModification($id, $nom, $prenom, $situ) {
    echo "<h2>Modifier l'enregistrement :</h2>";
    echo "<form method='post'>";
    echo "Nom : <input type='text' name='nouveau_nom' value='" . $nom . "' required><br>";
    echo "Prénom : <input type='text' name='nouveau_prenom' value='" . $prenom . "' required><br>";
    echo "Situation : <input type='text' name='nouvelle_situ' value='" . $situ . "' required><br>";
    
    echo "<input type='submit' name='modifier' value='Modifier'>";
    echo "</form>";
}

if (isset($_GET['id'])) {
    $id_a_modifier = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
        $nouveau_nom = $connexion->real_escape_string($_POST['nouveau_nom']);
        $nouveau_prenom = $connexion->real_escape_string($_POST['nouveau_prenom']);
        $nouvelle_situ = $connexion->real_escape_string($_POST['nouvelle_situ']);

        $modification_query = "UPDATE informations SET nom = '$nouveau_nom', prenom = '$nouveau_prenom', situ = '$nouvelle_situ' WHERE id = $id_a_modifier";

        if ($connexion->query($modification_query) === TRUE) {
            echo "L'enregistrement avec l'ID $id_a_modifier a été modifié avec succès.";
        } else {
            echo "Erreur lors de la modification de l'enregistrement : " . $connexion->error;
        }
    } else {
        $query = "SELECT * FROM informations WHERE id = $id_a_modifier";
        $resultat = $connexion->query($query);

        if ($resultat->num_rows == 1) {
            $row = $resultat->fetch_assoc();
            afficherFormulaireModification($id_a_modifier, $row['nom'], $row['prenom'], $row['situ']);
        } else {
            echo "ID non valide.";
        }
    }
}

$query = "SELECT * FROM informations";
$resultat = $connexion->query($query);

if ($resultat) {
    if ($resultat->num_rows > 0) {
        echo "<h2>Liste des enregistrements :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Prénom</th><th>date_naissance</th><th>lieu_naissance</th><th>Adresse</th><th>grade</th><th>specialite</th><th>Code Postal</th><th>Nationalité</th><th>Situation</th><th>Système</th><th>Pays</th><th>Applications</th><th>Sexe</th></tr>";
        while ($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nom'] . "</td>";
            echo "<td>" . $row['prenom'] . "</td>";
            echo "<td>" . $row['date_naissance'] . "</td>";
            echo "<td>" . $row['lieu_naissance'] . "</td>";
           
            echo "<td>" . $row['adresse'] . "</td>";
            echo "<td>" . $row['gra'] . "</td>";
           
            echo "<td>" . $row['spec'] . "</td>";
            
            echo "<td>" . $row['cod_post'] . "</td>";
            echo "<td>" . $row['nat'] . "</td>";
            echo "<td>" . $row['situ'] . "</td>";
            echo "<td>" . $row['systeme'] . "</td>";
            echo "<td>" . $row['cod'] . "</td>";
            echo "<td>" . $row['applications'] . "</td>";
            echo "<td>" . $row['sexe'] . "</td>";
         
           
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucun enregistrement trouvé dans la base de données.";
    }
} else {
    echo "Erreur dans la requête : " . $connexion->error;
}

$connexion->close();
?>
