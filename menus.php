<?php
session_start();

// Vérifier si l'utilisateur est connecté et le type d'utilisateur est défini
if(isset($_SESSION['user_type']) && isset($_SESSION['email'])) {
    $userType = $_SESSION['user_type'];
    $email = $_SESSION['email'];

    // Afficher le menu en fonction du type d'utilisateur
    echo '<h1>Welcome, ' . ucfirst($userType) . ' ' . $email . '!</h1>'; // ucfirst pour mettre en majuscule la première lettre

    echo '<ul>';
    if ($userType === "Admin") {
        echo '<h1>Menu de navigation</h1>';
        echo '<p>Selectionnez une section :</p>';
        echo '<input type="button" value="Etudiant" onclick="navigateTo(\'tp.html\')">';
        echo '<input type="button" value="Enseignant" onclick="chargerSmenu()">';
        echo '<input type="button" value="Module" onclick="navigateTo(\'module.html\')">';
        echo '<input type="button" value="bulletin de notes" onclick="navigateTo(\'bull.html\')">';
        echo '<input type="button" value="pv" onclick="navigateTo(\'pv.html\')">';
        echo '<input type="button" value="stats" onclick="navigateTo(\'graph.html\')">';
        echo '<input type="button" value="stats2" onclick="navigateTo(\'statu.html\')">';
    
        echo '<script>';
        echo 'function navigateTo(url) {';
        echo 'window.location.href = url;';
        echo '}';
    
        echo 'function chargerSmenu() {';
        echo 'var xhr = new XMLHttpRequest();';
        echo 'xhr.open("GET", "smenu.html", true);';
        echo 'xhr.onreadystatechange = function () {';
        echo 'if (xhr.readyState === 4 && xhr.status === 200) {';
        echo 'document.getElementById("smenuContent").innerHTML = xhr.responseText;';
        echo '}';
        echo '};';
        echo 'xhr.send();';
        echo '}';
        echo '</script>';
    
        echo '<div id="smenuContent">';
        echo '<!-- Le contenu de smenu.html sera affiché ici sous le bouton "Enseignant" -->';
        echo '</div>';
    } elseif ($userType === 'User') {
        // Afficher le menu pour l'utilisateur standard
        echo '<li><a href="user_dashboard.php">Dashboard</a></li>';
        echo '<li><a href="user_grades.php">Grades</a></li>';
        // ... autres liens pour l'utilisateur standard
    } else {
        echo 'Error: Unknown user type.';
    }
    echo '</ul>';
} else {
    echo 'Error: User not logged in.';
}
?>
