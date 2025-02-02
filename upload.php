<?php
if (isset($_POST["submit"])) {
    // Vérifiez si un fichier a été téléchargé
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $db = new mysqli("localhost", "root", "", "chatgpt");

        if ($db->connect_error) {
            die("La connexion à la base de données a échoué : " . $db->connect_error);
        }

        $image = $_FILES["image"]["tmp_name"];
        $nom_fichier = $_FILES["image"]["name"];
        $type_mime = $_FILES["image"]["type"];

        $image_binaire = file_get_contents($image);

        $stmt = $db->prepare("INSERT INTO formulaire (nom_fichier, type_mime, donnees_image) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nom_fichier, $type_mime, $image_binaire);

        if ($stmt->execute()) {
            echo "L'image a été téléchargée et insérée dans la base de données avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'insertion de l'image dans la base de données : " . $stmt->error;
        }

        $stmt->close();
        $db->close();
    } else {
        echo "Veuillez sélectionner une image à télécharger.";
    }
}
?>
