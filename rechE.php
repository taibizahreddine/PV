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

// Votre script qui récupère les informations du module
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
        exit; // Fin du script après l'envoi des informations du module
    }
}

// Récupération de l'ID de recherche depuis l'URL
if (isset($_GET['recherche_id'])) {
    $recherche_id = $_GET['recherche_id'];

    // Requête SQL pour récupérer le nom, prénom et filière de l'étudiant depuis la table "formulaire"
    $query = "SELECT nom, prenom, fil, id FROM formulaire WHERE id = $recherche_id";
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

            // Récupérez la filière de l'étudiant
            $fil = $row['fil'];

            // Requête SQL pour récupérer les modules disponibles pour la filière
            $queryModules = "SELECT Nom_Module FROM modules WHERE fil = '$fil'";
            $resultModules = $connexion->query($queryModules);

            echo "Nom du module : <select name='nouveau_Nom_module' id='selected_module'>";
            while ($moduleRow = $resultModules->fetch_assoc()) {
                echo "<option value='" . $moduleRow['Nom_Module'] . "'>" . $moduleRow['Nom_Module'] . "</option>";
            }
            echo "</select><br><br>";

            // Ajoutez les champs pour le code du module et le coefficient (remplis via AJAX)
            echo "Code du module : <input type='text' size='5' name='nouveau_code_module' id='code_module'><br><br>";
            echo "Coefficient : <input type='text' size='5' name='nouveau_coefficient' id='coefficient'><br><br>";

            echo "Note : <input type='text' size='5' name='nouvelle_Note'><br><br>";
            echo "<input type='submit' name='Enregistrer' value='Enregistrer'>";
            echo "</form";
        } else {
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
    $query = "INSERT INTO notes (Num_Etudiant, Nom_module, fil, code_module, coefficient, Note) 
    VALUES ('$Num_Etudiant', '$Nom_module', '$fil', '$code_module', '$nouveau_coefficient', '$Note')";

    if ($connexion->query($query) === TRUE) {
        echo "Les informations du bulletin ont été enregistrées avec succès pour l'étudiant : " . $row['nom'];
    } else {
        echo "Erreur lors de l'enregistrement : " . $connexion->error;
    }
}

$connexion->close();
?>
