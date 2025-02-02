<?php

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;





function rechercheEtudiant($connexion, $recherche_id) {
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
            echo "Filiere : <input type='text' name='nouvelle_fil' value='" . $row['fil'] . "'><br><br>";

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

            echo "Note : <input type='text' size='5' name='nouvelle_Note'><br><br>";
            echo "<input type='submit' name='Enregistrer' value='Enregistrer'>";
            echo "</form>";
        } else {
            echo "Aucune information trouvée pour l'ID $recherche_id dans la table 'formulaire'.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}


function affichageBulletin($connexion, $recherche_id) {
    $query = "SELECT Nom_module, coefficient, code_module, Note FROM notes WHERE Num_Etudiant = $recherche_id";
    $resultat = $connexion->query($query);

    if ($resultat) {
        if ($resultat->num_rows > 0) {
            echo "<h2>Liste des notes de l'étudiant $recherche_id :</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Nom module</th><th>Coefficient</th><th>Code module</th><th>Note</th></tr>";

            $totalPoints = 0;
            $totalCoefficients = 0;

            while ($row = $resultat->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['Nom_module'] . "</td>";
                echo "<td>" . $row['coefficient'] . "</td>";
                echo "<td>" . $row['code_module'] . "</td>";
                echo "<td>" . $row['Note'] . "</td>";
                echo "</tr>";

                $totalPoints += $row['Note'] * $row['coefficient'];
                
                $totalCoefficients += $row['coefficient'];
            }

            echo "<tr>";
            echo "<td colspan='2'>Somme des coefficients</td>";
            echo "<td colspan='2'>$totalCoefficients</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td colspan='2'>Somme des notes</td>";
            echo "<td colspan='2'>$totalPoints</td>";
            echo "</tr>";

            echo "<tr>";
            echo "<td colspan='2'>Moyenne</td>";
            if ($totalCoefficients > 0) {
                $moyenne = $totalPoints / $totalCoefficients;
                echo "<td colspan='2'>$moyenne</td>";
            } else {
                echo "<td colspan='2'>N/A</td>";
            }
            echo "</tr>";

            echo "</table>";
        } else {
            echo "Aucune note trouvée dans la base de données.";
        }
    } else {
        echo "Erreur dans la requête : " . $connexion->error;
    }
}




$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "tppaw";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Enregistrer'])) {
    $nouveau_id = $_POST['nouveau_id'];
    $nouveau_Nom_module = $_POST['nouveau_Nom_module'];
    $nouveau_coefficient = $_POST['nouveau_coefficient'];
    $nouveau_code_module = $_POST['nouveau_code_module'];
    $nouvelle_Note = $_POST['nouvelle_Note'];

    $queryInsert = "INSERT INTO notes (Num_Etudiant, Nom_module, coefficient, code_module, Note) 
                    VALUES ('$nouveau_id', '$nouveau_Nom_module', '$nouveau_coefficient', '$nouveau_code_module', '$nouvelle_Note')";
    $resultInsert = $connexion->query($queryInsert);

    if ($resultInsert) {
        echo "Note enregistrée avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de la note : " . $connexion->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['recherche_id'])) {
    $recherche_id = $_POST['recherche_id'];

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'rechE') {
            rechercheEtudiant($connexion, $recherche_id);
        } elseif ($action === 'affo') {
            affichageBulletin($connexion, $recherche_id);
            echo "<form method='post'>";
            echo "<input type='hidden' name='recherche_id' value='$recherche_id'>";
            echo "<input type='hidden' name='action' value='affo'>";
            echo "<input type='submit' name='imprimer' value='Imprimer'>";
            echo "<input type='submit' name='envoyer_sans_phpmailer' value='Envoyer sans PHPMailer'>";
            echo "<input type='submit' name='envoyer_avec_phpmailer' value='Envoyer avec PHPMailer'>";
            echo "</form>";
        } else {
            echo "Action non reconnue";
        }
    } else {
        echo "Action non spécifiée";
    }
}
// ... Your existing code ...

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['envoyer_avec_phpmailer'])) {
    // Retrieve the student's email address (adjust the query based on your database structure)
    $queryEmail = "SELECT email FROM formulaire WHERE id = $recherche_id";
    $resultEmail = $connexion->query($queryEmail);

    if ($resultEmail && $resultEmail->num_rows == 1) {
        $rowEmail = $resultEmail->fetch_assoc();
        $toEmail = $rowEmail['email'];

        // Get the content of the bulletin
        ob_start();
        affichageBulletin($connexion, $recherche_id);
        $bulletinContent = ob_get_clean();

        // Setup PHPMailer
        $mail = new PHPMailer(true);

    
       
       
$mail->isSMTP();$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'kylianzahro@gmail.com';
$mail->Password = 'sipa hfxw kotq tkjc';
   $mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('kylianzahro@gmail.com', 'zahro22');
$mail->addAddress($toEmail, 'Recipient Name');

        $mail->isHTML(true);
        $mail->Subject = 'Bulletin de notes';
        $mail->Body = $bulletinContent;

        // Send the email
        if ($mail->send()) {
            echo "Le bulletin a été envoyé par e-mail avec succès à $toEmail.";
        } else {
            echo "Erreur lors de l'envoi de l'e-mail : " . $mail->ErrorInfo;
        }
    } else {
        echo "Adresse e-mail non trouvée pour l'étudiant.";
    }
}




$connexion->close();
?>
