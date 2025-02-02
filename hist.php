<?php
// Connexion à la base de données
$servername = "localhost"; // Remplacez par votre serveur MySQL
$username = "root"; // Remplacez par votre nom d'utilisateur MySQL
$password = ""; // Remplacez par votre mot de passe MySQL
$dbname = "tppaw"; // Remplacez par le nom de votre base de données

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Requête SQL pour récupérer les nationalités et le nombre d'enseignants par nationalité
$sql = "SELECT nationalite, COUNT(*) AS effectif FROM informations GROUP BY nationalite";

$result = $conn->query($sql);

$nationalites = [];
$effectifParNationalite = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nationalites[] = $row["nationalite"];
        $effectifParNationalite[] = $row["effectif"];
    }
}

$conn->close();
?>