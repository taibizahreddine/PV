<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "chatgpt";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("La connexion à la base de données a échoué : " . $connexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['supprimer'])) {
        // Traitement de la suppression ici
        $id_a_supprimer = $_POST['id_a_supprimer'];
        $suppression_query = "DELETE FROM formulaire WHERE id = $id_a_supprimer";
        if ($connexion->query($suppression_query) === TRUE) {
            echo "L'enregistrement avec l'ID $id_a_supprimer a été supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'enregistrement : " . $connexion->error;
        }
    }
}
?>