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

            echo "Nom du module : <select name='nouveau_Nom_module'>";
            while ($moduleRow = $resultModules->fetch_assoc()) {
                echo "<option value='" . $moduleRow['Nom_Module'] . "'>" . $moduleRow['Nom_Module'] . "</option>";
            }
            echo "</select><br><br>";

            echo "Code du module : <input type='text' size='5' name='nouveau_code_module'><br><br>";
            echo "Coefficient : <input type='text' size='5' name='nouveau_coefficient'><br><br>";
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
:::::::::::::::::::::::::::::::::::::::::::


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



$query = "SELECT * FROM notes ";
$resultat = $connexion->query($query);

if ($resultat) {
    if ($resultat->num_rows > 0) {
        echo "<h2>Liste des notes :</h2>";
        echo "<table border='1'>";
        echo "<tr><th>nom module</th><th>coifficient</th><th>code module</th><th>note</th>";
        while ($row = $resultat->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Nom_module'] . "</td>";
            echo "<td>" . $row['coefficient'] . "</td>";
            echo "<td>" . $row['code_module'] . "</td>";
            echo "<td>" . $row['Note'] . "</td>";
         
         
           
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
,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,




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
    $query = "SELECT Nom_module, coefficient,code_module, Note FROM notes WHERE Num_Etudiant = $recherche_id";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows > 0) {
            echo "<h2>Liste des notes de l'etudiant $recherche_id :</h2>";
            echo "<table border='1'>";
            echo "<tr><th>nom module</th><th>coifficient</th><th>code module</th><th>note</th>";
            while ($row = $resultat->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Nom_module'] . "</td>";
                echo "<td>" . $row['coefficient'] . "</td>";
                echo "<td>" . $row['code_module'] . "</td>";
                echo "<td>" . $row['Note'] . "</td>";
             
             
               
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucunne note trouvé dans la base de données.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}



$connexion->close();
?>(te3 etudiant waèed)

:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
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
    $query = "SELECT Nom_module, coefficient, code_module, Note FROM notes WHERE Num_Etudiant = $recherche_id";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows > 0) {
            echo "<h2>Liste des notes de l'étudiant $recherche_id :</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Nom module</th><th>Coefficient</th><th>Code module</th><th>Note</th></tr>";

            $totalNotes = 0;
            $nombreNotes = 0;

            while ($row = $resultat->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Nom_module'] . "</td>";
                echo "<td>" . $row['coefficient'] . "</td>";
                echo "<td>" . $row['code_module'] . "</td>";
                echo "<td>" . $row['Note'] . "</td>";
                echo "</tr>";

                // Ajouter la note au total
                $totalNotes += $row['Note'];
                $nombreNotes++;
            }

            // Calculer et afficher la moyenne
            if ($nombreNotes > 0) {
                $moyenne = $totalNotes / $nombreNotes;
                echo "<tr><td colspan='3'>Moyenne</td><td>$moyenne</td></tr>";
            }

            echo "</table>";
        } else {
            echo "Aucune note trouvée dans la base de données.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}

$connexion->close();
?>
 ((((yaffichi tableau bih bla moyenne))))





 <form action="calcul_moyenne.php" method="post">
    <label for="recherche_id_moyenne">Calculer la moyenne de l'étudiant par ID :</label>
    <input type="text" id="recherche_id_moyenne" name="recherche_id_moyenne">
    <input type="submit" value="Calculer Moyenne"><br><br>
</form>//////////////////////////////////////////////////////////////////////////////////////////////////////:
    ///////////////////////////////////////////////////////////////////






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
        $note = $_POST['Note'];
        $code_module = $_POST['code_module'];
        $coefficient = $_POST['coefficient'];
        $Nom_module = $_POST['Nom_module'];

        // Requête SQL pour mettre à jour les informations dans la table "notes"
        $updateQuery = "UPDATE notes 
                        SET Note = '$note', code_module = '$code_module', coefficient = '$coefficient', Nom_module = '$Nom_module' 
                        WHERE Num_Etudiant = $recherche_id AND code_module = '$code_module'";

        if ($connexion->query($updateQuery) === TRUE) {
            echo "Les modifications ont été enregistrées avec succès.";
        } else {
            echo "Erreur lors de la mise à jour : " . $connexion->error;
        }
    }

    // Requête SQL pour rechercher les informations par ID dans la table "formulaire"
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
            echo "Filiere : <select name='nouvelle_fil'>";
            $filieres = array('TC', '1ING', 'M1', '2ING', '3ISIL');
            foreach ($filieres as $filiere) {
                echo "<option value='$filiere' " . ($row['fil'] == $filiere ? 'selected' : '') . ">$filiere</option>";
            }
            echo "</select><br>";

            // Requête SQL pour rechercher les informations par ID dans la table "notes"
            $notesQuery = "SELECT * FROM notes WHERE Num_Etudiant = $recherche_id";
            $notesResult = $connexion->query($notesQuery);

            if ($notesResult->num_rows > 0) {
                $notesRow = $notesResult->fetch_assoc();
                // Integrate fields from the "notes" table into the form
                echo "Note : <input type='text' size='5' name='Note' value='" . $notesRow['Note'] . "'><br>";
                echo "Code module : <input type='text' size='5' name='code_module' value='" . $notesRow['code_module'] . "'><br>";
                echo "Coefficient : <input type='text' size='5' name='coefficient' value='" . $notesRow['coefficient'] . "'><br>";
                echo "Nom module : <input type='text' name='Nom_module' value='" . $notesRow['Nom_module'] . "'><br>";
            } else {
                echo "Aucune note trouvée pour l'ID $recherche_id dans la table 'notes'.";
            }

            echo "<input type='submit' name='modifier' value='Modifier'>";
            echo "</form>";
        } else {
            echo "Aucune information trouvée pour l'ID $recherche_id dans la table 'formulaire'.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}

$connexion->close();
?>
