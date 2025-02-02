<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "tppaw";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['module'])) {
    $selectedModule = $connexion->real_escape_string($_POST['module']);
    
    $query = "SELECT coefficient, code_module, Note FROM notes WHERE Nom_module = '$selectedModule'";

    $result = $connexion->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $moduleInfo = array(
            'coefficient' => $row['coefficient'],
            'code_module' => $row['code_module'],
            'Note' => $row['Note']
        );
        echo json_encode($moduleInfo);
        exit;
    }
}




if (isset($_GET['recherche_id'])) {
    $recherche_id = $_GET['recherche_id'];

    $query = "SELECT nom, prenom, fil, id FROM formulaire WHERE id = $recherche_id";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows == 1) {
            $row = $resultat->fetch_assoc();

            echo "<h2>Modifier le bulletin de l'étudiant :</h2>";

            echo "<form method='post'>";

            echo "Num_Etudiant : <input type='text' name='nouveau_id' value='" . $row['id'] . "'><br><br>";
            echo "Nom : <input type='text' name='nouveau_nom' value='" . $row['nom'] . "'><br><br>";
            echo "Prénom : <input type='text' name='nouveau_prenom' value='" . $row['prenom'] . "'><br><br>";
            echo "filiere : <input type='text' name='nouvelle_fil' value='" . $row['fil'] . "'><br><br>";

            $fil = $row['fil'];

            $queryModules = "SELECT Nom_Module FROM modules WHERE fil = '$fil'";
            $resultModules = $connexion->query($queryModules);

            echo "Nom du module : <select name='nouveau_Nom_module' id='selected_module'>";
            while ($moduleRow = $resultModules->fetch_assoc()) {
                echo "<option value='" . $moduleRow['Nom_Module'] . "'>" . $moduleRow['Nom_Module'] . "</option>";
            }
            echo "</select><br><br>";

            echo "Code du module : <input type='text' size='5' name='nouveau_code_module' id='code_module'><br><br>";
            echo "Coefficient : <input type='text' size='5' name='nouveau_coefficient' id='coefficient'><br><br>";
            echo "Note : <input type='text' size='5' name='nouvelle_Note' id='Note'><br><br>";

            echo "<input type='submit' name='Enregistrer' value='Enregistrer'>";
            echo "</form>";

          
            echo "<span id='module_info'></span>";

           
            echo "<script>
                document.getElementById('selected_module').addEventListener('change', function() {
                    var selectedModule = this.value;
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            var moduleInfo = JSON.parse(xhr.responseText);
                            document.getElementById('code_module').value = moduleInfo.code_module;
                            document.getElementById('coefficient').value = moduleInfo.coefficient;
                            document.getElementById('Note').value = moduleInfo.Note;
                        }
                    };
                    xhr.open('POST', 'your_ajax_handler.php', true);
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhr.send('module=' + selectedModule);
                });
            </script>";
        } else {
            echo "Aucune information trouvée pour l'ID $recherche_id dans la table 'formulaire'.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Enregistrer'])) {
    $Num_Etudiant = $connexion->real_escape_string($_POST['nouveau_id']);
    $Nom_module = $connexion->real_escape_string($_POST['nouveau_Nom_module']);
    $code_module = $connexion->real_escape_string($_POST['nouveau_code_module']);
    $nouveau_coefficient = $connexion->real_escape_string($_POST['nouveau_coefficient']);
    $Note = $connexion->real_escape_string($_POST['nouvelle_Note']);
   

    $updateQuery = "UPDATE notes SET coefficient = '$nouveau_coefficient', code_module = '$code_module', Note = '$Note' 
                    WHERE Num_Etudiant = '$Num_Etudiant' AND Nom_module = '$Nom_module'";

    if ($connexion->query($updateQuery) === TRUE) {
        echo "La note a été mise à jour avec succès pour l'étudiant : " . $Num_Etudiant;
    } else {
        echo "Erreur lors de la mise à jour : " . $connexion->error;
    }
}

$connexion->close();
?>
