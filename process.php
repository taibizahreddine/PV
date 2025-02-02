<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Establish a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tppaw";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve data from the form
    $code_module = $conn->real_escape_string($_POST['code_module']);
    $Nom_module = $conn->real_escape_string($_POST['Nom_module']);
    $coefficient = floatval($_POST['coefficient']);
    $volume_horaire = intval($_POST['volume_horaire']);
    $fil = $conn->real_escape_string($_POST['fil']);

    // Insert data into the database
    $sql = "INSERT INTO modules (code_module, Nom_module, coefficient, volume_horaire, fil) VALUES ('$code_module', '$Nom_module', $coefficient, $volume_horaire, '$fil')";

    if ($conn->query($sql) === TRUE) {
        echo "Module information has been successfully saved.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
