
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
    $query = "SELECT nom, prenom, fil,id FROM formulaire WHERE id = $recherche_id";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows == 1) {
            $row = $resultat->fetch_assoc();

            // Affichez le formulaire de modification du bulletin
            echo "<h2>Modifier le bulletin de l'étudiant :</h2>";
           
            echo "<form method='post'>";
            
            echo "Num_Etudiant : <input type='text' name='nouveau_id' value='" . $row['id'] . "'><br><br>";
            echo "Nom : <input type='text' name='nouveau_nom' value='" . $row['nom'] . "'><br><br>";
            echo "Prénom : <input type='text' name='nouveau_prenom' value='" . $row['prenom'] . "'><br><br>";
            echo "filiere : <input type='text' name='nouvelle_fil' value='" . $row['fil'] . "'><br><br>";
            echo "Nom du module : <select name='nouveau_Nom_module'>
                    <option value='BDD'>Base de données</option>
                    <option value='ARCHI'>Architecture</option>
                    <option value='ANA'>Analyse</option>
                    <option value='ENG'>Anglais</option>
                 </select><br><br>";

            echo "Code du module : <input type='text' size='5' name='nouveau_code_module'><br><br>";
            echo "Coefficient : <input type='text' size='5' name='nouveau_coefficient'><br><br>";
            echo "Note : <input type='text'  size='5' name='nouvelle_Note'><br><br>";
            echo "<input type='submit' name='Enregistrer' value='Enregistrer'>";
            echo "</form>";
        
        
        } 
        else {
            echo "Aucune information trouvée pour l'ID $recherche_id dans la table 'formulaire'.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Enregistrer'])) {
    $fil = $connexion->real_escape_string($_POST['nouvelle_fil']);
    
    $Num_Etudiant = $connexion->real_escape_string($_POST['nouveau_id']);

    $nouveau_coefficient = $connexion->real_escape_string($_POST['nouveau_coefficient']);
    $code_module = $connexion->real_escape_string($_POST['nouveau_code_module']);
    $Note = $connexion->real_escape_string($_POST['nouvelle_Note']);
    $Nom_module = $connexion->real_escape_string($_POST['nouveau_Nom_module']);

    // Requête SQL pour enregistrer les informations du bulletin dans la table "notes"
    // Requête SQL pour enregistrer les informations du bulletin dans la table "notes"
$query = "INSERT INTO notes (Num_Etudiant,Nom_module,fil, code_module, coefficient, Note) 
VALUES ('$Num_Etudiant','$Nom_module','$fil', '$code_module', '$nouveau_coefficient', '$Note')";

    if ($connexion->query($query) === TRUE) {
        echo "Les informations du bulletin ont été enregistrées avec succès pour l'étudiant : " . $row['nom'];
    } else {
        echo "Erreur lors de l'enregistrement : " . $connexion->error;
    }
}


$connexion->close();
?>



,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rechercher'])) {
    $recherche_id = $_POST['recherche_id'];

    // Requête SQL pour rechercher l'étudiant par ID
    $query = "SELECT nom, prenom, fil FROM formulaire WHERE id = $recherche_id";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows == 1) {
            $row = $resultat->fetch_assoc();
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $fil = $row['fil'];

            echo "<p>Nom/Prénom : $nom $prenom</p>";
            echo "<p>Filière : $fil</p>";

            // Requête pour obtenir les modules correspondants à la filière
            $query_modules = "SELECT Nom_module FROM modules WHERE fil = '$fil'";
            $resultat_modules = $connexion->query($query_modules);

            if ($resultat_modules) {
                echo "<form method='post' action='modfi.php'>";
                echo "<label for='Nom_module'>Choisissez un module :</label>";
                echo "<select id='Nom_module' name='Nom_module'>";
                while ($row_module = $resultat_modules->fetch_assoc()) {
                    echo "<option value='" . $row_module['Nom_module'] . "'>" . $row_module['Nom_module'] . "</option>";
                }
                echo "</select>";
                echo "<input type='submit' value='Valider le module' name='valider_module'>";
                echo "</form>";
            } else {
                echo "Aucun module trouvé pour la filière $fil.";
            }
        } else {
            echo "Aucun étudiant trouvé pour l'ID $recherche_id.";
        }
    } else {
        echo "Erreur dans la requête SQL : " . $connexion->error;
    }
}
$connexion->close();
?>
