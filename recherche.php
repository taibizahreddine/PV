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

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modifier'])) {
        // Récupérer les valeurs du formulaire
        $nouveau_nom = $_POST['nouveau_nom'];
        $nouveau_prenom = $_POST['nouveau_prenom'];
        $nouvelle_adresse = $_POST['nouvelle_adresse'];
        $nouveau_lieu_naissance = $_POST['nouveau_lieu_naissance'];
        $nouvelle_fil = $_POST['nouvelle_fil'];
        $nouveau_cod_post = $_POST['nouveau_cod_post'];
        $nouvelle_nat = $_POST['nouvelle_nat'];
        $nouvelle_situ = $_POST['nouvelle_situ'];
        $nouveau_systeme = implode(", ", $_POST['nouveau_systeme']);
        $nouveau_cod = $_POST['nouveau_cod'];
        $nouvelles_applications = implode(", ", $_POST['nouvelles_applications']);
        $nouveau_sexe = $_POST['nouveau_sexe'];

        // Requête SQL pour mettre à jour les informations
        $query = "UPDATE formulaire SET nom = '$nouveau_nom', prenom = '$nouveau_prenom', adresse = '$nouvelle_adresse', lieu_naissance = '$nouveau_lieu_naissance', fil = '$nouvelle_fil', cod_post = '$nouveau_cod_post', nat = '$nouvelle_nat', situ = '$nouvelle_situ', systeme = '$nouveau_systeme', cod = '$nouveau_cod', applications = '$nouvelles_applications', sexe = '$nouveau_sexe' WHERE id = $recherche_id";

        if ($connexion->query($query) === TRUE) {
            echo "Les modifications ont été enregistrées avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . $connexion->error;
        }
    }

    // Requête SQL pour rechercher les informations par ID
    $query = "SELECT * FROM formulaire WHERE id = $recherche_id";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows == 1) {
            $row = $resultat->fetch_assoc();
            // Affichez le formulaire de modification avec les champs pré-remplis
            echo "<h2>Modifier l'enregistrement :</h2>";
            echo "<form method='post'>";
            echo "Nom : <input type='text' name='nouveau_nom' value='" . $row['nom'] . "'><br>";
            echo "Prénom : <input type='text' name='nouveau_prenom' value='" . $row['prenom'] . "'><br>";
            echo "Adresse : <input type='text' name='nouvelle_adresse' value='" . $row['adresse'] . "'><br>";

            echo "Ville : <input type='text' name='nouveau_lieu_naissance' value='" . $row['lieu_naissance'] . "'><br>";
            echo "filiere : <select name='nouvelle_fil'>";
            echo "<option value='TC' " . ($row['fil'] == 'TC' ? 'selected' : '') . ">TC</option>";
            echo "<option value='1ING' " . ($row['fil'] == '1ING' ? 'selected' : '') . ">1ING</option>";
            echo "<option value='M1' " . ($row['fil'] == 'M1' ? 'selected' : '') . ">MI</option>";
            echo "<option value='2ING' " . ($row['fil'] == '2ING' ? 'selected' : '') . ">2ING</option>";
            echo "<option value='3ISIL' " . ($row['fil'] == '3ISIL' ? 'selected' : '') . ">3ISIL</option>";
            echo "</select><br>";
            
            echo "Code Postal : <input type='text' name='nouveau_cod_post' value='" . $row['cod_post'] . "'><br>";
            echo "Nationalité : <select name='nouvelle_nat'>";
            echo "<option value='DZ' " . ($row['nat'] == 'DZ' ? 'selected' : '') . ">Algerie</option>";
            echo "<option value='FR' " . ($row['nat'] == 'FR' ? 'selected' : '') . ">France</option>";
            echo "<option value='BLG' " . ($row['nat'] == 'BLG' ? 'selected' : '') . ">Belgique</option>";
            echo "<option value='ARG' " . ($row['nat'] == 'ARG' ? 'selected' : '') . ">Argentine</option>";
            echo "</select><br>";

            echo "Situation matrimoniale :<br>";
            echo "<input type='radio' name='nouvelle_situ' value='marie' " . ($row['situ'] == 'marie' ? 'checked' : '') . "> Marié<br>";
            echo "<input type='radio' name='nouvelle_situ' value='divorce' " . ($row['situ'] == 'divorce' ? 'checked' : '') . "> Divorcé<br>";
            echo "Système :<br>";
            $systeme = explode(", ", $row['systeme']);
            echo "<input type='checkbox' name='nouveau_systeme[]' value='Unix' " . (in_array('Unix', $systeme) ? 'checked' : '') . "> Unix<br>";
            echo "<input type='checkbox' name='nouveau_systeme[]' value='Windows' " . (in_array('Windows', $systeme) ? 'checked' : '') . "> Windows<br>";
            echo "<input type='checkbox' name='nouveau_systeme[]' value='Android' " . (in_array('Android', $systeme) ? 'checked' : '') . "> Android<br>";
            echo "Pays : <select name='nouveau_cod'>";
            echo "<option value='DZ' " . ($row['cod'] == 'DZ' ? 'selected' : '') . ">Algérie</option>";
            echo "<option value='FR' " . ($row['cod'] == 'FR' ? 'selected' : '') . ">France</option>";
            echo "<option value='BLG' " . ($row['cod'] == 'BLG' ? 'selected' : '') . ">Belgique</option>";
            echo "<option value='ARG' " . ($row['cod'] == 'ARG' ? 'selected' : '') . ">Argentine</option>";
            echo "</select><br>";
            echo "Applications :<br>";
            $applications = explode(", ", $row['applications']);
            echo "<input type='checkbox' name='nouvelles_applications[]' value='PUBG' " . (in_array('PUBG', $applications) ? 'checked' : '') . "> PUBG<br>";
            echo "<input type='checkbox' name='nouvelles_applications[]' value='FIFA 24' " . (in_array('FIFA 24', $applications) ? 'checked' : '') . "> FIFA 24<br>";
            echo "<input type='checkbox' name='nouvelles_applications[]' value='Fortnite' " . (in_array('Fortnite', $applications) ? 'checked' : '') . "> Fortnite<br>";
            echo "Sexe :<br>";
            echo "<input type='radio' name='nouveau_sexe' value='male' " . ($row['sexe'] == 'male' ? 'checked' : '') . "> Masculin<br>";
            echo "<input type='radio' name='nouveau_sexe' value='female' " . ($row['sexe'] == 'female' ? 'checked' : '') . "> Féminin<br>";
            echo "<input type='submit' name='modifier' value='Modifier'>";
            echo "</form>";
        }else {
            echo "Aucune information trouvée pour l'ID $recherche_id.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}

$connexion->close();
?>
