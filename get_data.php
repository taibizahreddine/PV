<?php
// Connectez-vous à votre base de données

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Effectuez une requête SQL pour récupérer les données en fonction de l'ID
    $query = "SELECT * FROM formulaire WHERE id = $id"; // Assurez-vous d'adapter cette requête à votre schéma de base de données

    // Exécutez la requête et récupérez les données

    // Renvoyez les données au format JSON
    echo json_encode($data);
}
?>
