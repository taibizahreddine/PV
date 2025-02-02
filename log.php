<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    
    // Récupérer les valeurs du formulaire
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $mdp = isset($_POST["mdp"]) ? $_POST["mdp"] : "";
    $userType = "";

    // Dans un environnement de production, utilisez une connexion sécurisée à la base de données
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "tppaw";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password_db, $database);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Échapper les valeurs pour éviter les attaques par injection SQL (à faire correctement dans un environnement de production)
    $email = $conn->real_escape_string($email);
    $mdp = $conn->real_escape_string($mdp);

    if ($_POST["action"] === "register") {
        // Récupérer le type d'utilisateur depuis le formulaire
        $userType = isset($_POST["user_type"]) ? $_POST["user_type"] : 'User';
        
        // Échapper également le type
        $userType = $conn->real_escape_string($userType);

        // Insérer un nouvel utilisateur dans la base de données avec le type spécifié
        $sql = "INSERT INTO utilisateur (email, mdp, types) VALUES ('$email', '$mdp', '$userType')";
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful. Welcome, $email!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif ($_POST["action"] === "login") {
        // Supposez que vous avez une logique pour déterminer le type d'utilisateur, vous pouvez remplacer cela par votre propre logique
        // Par exemple, en fonction des données dans votre base de données
        $userType = getUserType($conn, $email, $mdp);
    
        // Vérifier le type d'utilisateur
        if ($userType === "Admin") {
            // Inclure le code du menu Admin
            include('menu.html');
        } elseif ($userType === "User") {
            // Inclure le code du bulletin de notes
            include('bultin.html');
        } else {
            // Afficher un message d'accès non autorisé
            echo '<p>Accès non autorisé.</p>';
        }
    }

    // Fermer la connexion
    $conn->close();
}

// Fonction fictive pour récupérer le type d'utilisateur à partir de la base de données
function getUserType($conn, $email, $mdp) {
    $sql = "SELECT email, mdp, types FROM utilisateur WHERE email = '$email' AND mdp = '$mdp'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['types'];
    } else {
        return false;
    }
}
?>
