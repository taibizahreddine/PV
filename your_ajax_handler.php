<?php
// your_ajax_handler.php

// Connexion à la base de données (à adapter avec vos paramètres)
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
    
    // Check if the 'note' parameter is set in the POST request
    if (isset($_POST['note'])) {
        // Get the modified note value
        $modifiedNote = $connexion->real_escape_string($_POST['note']);
        
        // Update the 'Note' in the 'notes' table
        $updateQuery = "UPDATE notes SET Note = '$modifiedNote' WHERE Nom_module = '$selectedModule'";
        $updateResult = $connexion->query($updateQuery);
        
        if ($updateResult) {
            // If the update was successful, return success message or any other data you need
            echo json_encode(['status' => 'success']);
        } else {
            // If the update failed, return an error message or any other data you need
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
        
        exit;
    }
    
    // If the 'note' parameter is not set, proceed with retrieving module information
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

$connexion->close();
?>
