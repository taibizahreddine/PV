<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Establish a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "modulo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize the Id from the query string
    $id = $conn->real_escape_string($_GET['id']);

    // Search for the module with the specified Id
    $sql = "SELECT * FROM modules WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Module found, display its information
        $row = $result->fetch_assoc();
        echo "<h2>Module Information</h2>";
        echo "Id: " . $row["id"] . "<br>";
        echo "Code Module: " . $row["code_module"] . "<br>";
        echo "Designation Module: " . $row["designation_module"] . "<br>";
        echo "Coefficient: " . $row["coefficient"] . "<br>";
        echo "Volume Horaire: " . $row["volume_horaire"] . "<br>";
        echo "Filiere: " . $row["filiere"] . "<br>";
        echo "<tr><a href='modif1.php?id=" . $row['id'] . "'>Modifier</a></tr><br><br>";
        echo "<tr><a href='supp1.php?id=" . $row['id'] . "'>Supprimer</a></tr>";
    } else {
        echo "Module with Id $id not found.";
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
