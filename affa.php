<?php


require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;




// Connexion à la base de données (à adapter avec vos paramètres)
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "tppaw";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

// Requête SQL pour calculer les moyennes des étudiants (similaire à votre code)
$query = "SELECT f.nom, f.prenom, f.fil, AVG(n.Note) as moyenne 
          FROM formulaire f 
          LEFT JOIN notes n ON f.id = n.Num_Etudiant 
          GROUP BY f.id";

$result = $connexion->query($query);

if ($result) {
    // Construct the HTML table for PV
    $pvTable = "<h2>Liste des etudiants et leurs moyennes :</h2>";
    $pvTable .= "<table border='1'>";
    $pvTable .= "<tr><th>Nom</th><th>Prénom</th><th>Filière</th><th>Moyenne</th></tr>";

    while ($row = $result->fetch_assoc()) {
        $pvTable .= "<tr>";
        $pvTable .= "<td>" . $row['nom'] . "</td>";
        $pvTable .= "<td>" . $row['prenom'] . "</td>";
        $pvTable .= "<td>" . $row['fil'] . "</td>";
        $pvTable .= "<td>" . round($row['moyenne'], 2) . "</td>"; // Arrondir la moyenne à deux décimales
        $pvTable .= "</tr>";
    }

    $pvTable .= "</table>";

    // Requête SQL pour la moyenne maximale
    $maxQuery = "SELECT MAX(moyenne) as moyenne_max FROM (SELECT AVG(n.Note) as moyenne 
                 FROM formulaire f 
                 LEFT JOIN notes n ON f.id = n.Num_Etudiant 
                 GROUP BY f.id) as moyennes";

    $maxResult = $connexion->query($maxQuery);
    $maxRow = $maxResult->fetch_assoc();
    $pvTable .= "<p>Moyenne maximale : " . round($maxRow['moyenne_max'], 2) . "</p>";

    // Requête SQL pour la moyenne minimale
    $minQuery = "SELECT MIN(moyenne) as moyenne_min FROM (SELECT AVG(n.Note) as moyenne 
                 FROM formulaire f 
                 LEFT JOIN notes n ON f.id = n.Num_Etudiant 
                 GROUP BY f.id) as moyennes";

    $minResult = $connexion->query($minQuery);
    $minRow = $minResult->fetch_assoc();
    $pvTable .= "<p>Moyenne minimale : " . round($minRow['moyenne_min'], 2) . "</p>";

    // Ajout du bouton Envoyer
    $pvTable .= "<form method='post' action=''>";
    $pvTable .= "<input type='submit' name='envoyer' value='Envoyer'>";
    $pvTable .= "</form>";

    // Afficher le PV
    echo $pvTable;

    // Fermer le résultat de la requête pour libérer les ressources
    $result->close();

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['envoyer'])) {
        // Include PHPMailer autoload.php file
     

        // Create a new PHPMailer instance
        $mail = new PHPMailer;
        $mail->SMTPDebug = 0;
        // Set up SMTP (adjust these settings according to your email server)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kylianzahro@gmail.com';
        $mail->Password = 'sipa hfxw kotq tkjc';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Set email content type to HTML
        $mail->isHTML(true);

        // Enable debugging
     

        // Set sender and subject
        $mail->setFrom('kylianzahro@gmail.com', 'zahro22');
        $mail->Subject = 'Subject of the email';

        // Requête SQL pour récupérer les emails des professeurs
        $emailQuery = "SELECT email FROM informations WHERE gra = 'PROF'";
        $emailResult = $connexion->query($emailQuery);

        $profEmails = array(); // Array to store professor emails

        if ($emailResult) {
            while ($emailRow = $emailResult->fetch_assoc()) {
                $profEmails[] = $emailRow['email'];
            }
        } else {
            echo "Erreur dans la requête pour récupérer les emails : " . $connexion->error;
        }

        // Send the email with PV table
        $mail->Body = "Hello Professors,\n\n$pvTable";

        // Iterate through professor emails and add them as recipients
        foreach ($profEmails as $email) {
            $mail->addAddress($email);
        }

        // Send the email
        if (!$mail->send()) {
            echo 'Erreur lors de l\'envoi du courriel : ' . $mail->ErrorInfo;
        } else {
            echo 'Courriel envoyé avec succès!';
        }
    }

} else {
    echo "Erreur dans la requête : " . $connexion->error;
}

// Fermer la connexion à la base de données
$connexion->close();
?>
