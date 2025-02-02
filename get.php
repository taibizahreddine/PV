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

if (isset($_GET['module'])) {
    $selectedModule = $_GET['module'];

    // Effectuez une requête SQL pour récupérer le code et le coefficient du module sélectionné
    // Assurez-vous de traiter cette requête de manière sécurisée pour éviter les injections SQL

    // Exemple de requête SQL :
    $query = "SELECT code_module, coefficient FROM modules WHERE NomModule = ?";
    
    // Préparez la requête
    $stmt = $connexion->prepare($query);
    
    if ($stmt) {
        // Liez le paramètre
        $stmt->bind_param("s", $selectedModule);
        
        // Exécutez la requête
        $stmt->execute();
        
        // Liez les résultats
        $stmt->bind_result($code, $coefficient);
        
        // Récupérez les résultats
        if ($stmt->fetch()) {
            // Créez un tableau associatif avec les détails du module
            $moduleDetails = array('code' => $code, 'coefficient' => $coefficient);
            
            // Renvoyez les détails du module au format JSON
            header('Content-Type: application/json');
            echo json_encode($moduleDetails);
        } else {
            echo "Module non trouvé.";
        }
        
        // Fermez la requête préparée
        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de la requête : " . $connexion->error;
    }
}

// Fermez la connexion à la base de données
$connexion->close();
?>
