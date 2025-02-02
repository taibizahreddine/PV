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
    $email = $connexion->real_escape_string($_POST['email']);
    $date_naissance = $connexion->real_escape_string($_POST['date_naissance']);   
     $lieu_naissance = $connexion->real_escape_string($_POST['lieu_naissance']);
    $fil= $connexion->real_escape_string($_POST['fil']);
    $adresse = $connexion->real_escape_string($_POST['adresse']);

    
    $nat= $connexion->real_escape_string($_POST['nat']);
    $cod= $connexion->real_escape_string($_POST['cod']);
    $cod_post= $connexion->real_escape_string($_POST['cod_post']);
    $situ = $connexion->real_escape_string($_POST['situ']);
    $systeme = implode(", ", $_POST['systeme']);
    $applications = implode(", ", $_POST['applications']);
    $sexe = $connexion->real_escape_string($_POST['sexe']);

    // Requête SQL pour insérer les données
    $insert_query = "INSERT INTO formulaire (nom, prenom,email, adresse, lieu_naissance, cod_post, nat, cod, situ, systeme, applications, sexe, date_naissance,fil) VALUES ('$nom', '$prenom','$email', '$adresse', '$lieu_naissance', '$cod_post', '$nat', '$cod', '$situ', '$systeme', '$applications', '$sexe', '$date_naissance','$fil')";

    if ($connexion->query($insert_query) === TRUE) {
        echo "Les données ont été enregistrées avec succès dans la base de données.";
    } else {
        echo "Erreur lors de l'insertion des données : " . $connexion->error;
    }

    $connexion->close();
}
?>
