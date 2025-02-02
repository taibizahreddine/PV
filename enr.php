<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Paramètres de connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "root";
    $mot_de_passe = ""; // Laissez le mot de passe vide, à moins qu'il ne soit configuré dans votre base de données
    $base_de_donnees = "tppaw";

    // Connexion à la base de données
    $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

    if ($connexion->connect_error) {
        die("La connexion à la base de données a échoué : " . $connexion->connect_error);
    }

    // Récupération des données du formulaire
    $nom = $connexion->real_escape_string($_POST['nom']);
    $prenom = $connexion->real_escape_string($_POST['prenom']);
    $date_naissance = $connexion->real_escape_string($_POST['date_naissance']);   
     $lieu_naissance = $connexion->real_escape_string($_POST['lieu_naissance']);
    $gra= $connexion->real_escape_string($_POST['gra']);
    $spec= $connexion->real_escape_string($_POST['spec']);
    $adresse = $connexion->real_escape_string($_POST['adresse']);
    $email = $connexion->real_escape_string($_POST['email']);


    $cod_post= $connexion->real_escape_string($_POST['cod_post']);
    $nat= $connexion->real_escape_string($_POST['nat']);
    $cod= $connexion->real_escape_string($_POST['cod']);
        $systeme = implode(", ", $_POST['systeme']);
    $situ = $connexion->real_escape_string($_POST['situ']);

    $applications = implode(", ", $_POST['applications']);
    $sexe = $connexion->real_escape_string($_POST['sexe']);

    // Requête SQL pour insérer les données
    $insert_query = "INSERT INTO informations (nom, prenom, date_naissance, lieu_naissance, emai,gra, spec, adresse, cod_post, nat, cod, systeme, situ, applications, sexe) VALUES ('$nom', '$prenom', '$date_naissance', '$lieu_naissance', '$email','$gra', '$spec', '$adresse', '$cod_post', '$nat', '$cod', '$systeme', '$situ', '$applications', '$sexe')";

    if ($connexion->query($insert_query) === TRUE) {
        echo "Les données ont été enregistrées avec succès dans la base de données.";
    } else {
        echo "Erreur lors de l'insertion des données : " . $connexion->error;
    }

    $connexion->close();
}
?>
