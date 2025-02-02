<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tppaw";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the module information from the database
$sql = "SELECT * FROM modules";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>List of Modules</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Code Module</th><th>Designation Module</th><th>Coefficient</th><th>Volume Horaire</th><th>Filiere</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["code_module"] . "</td>";
        echo "<td>" . $row["Nom_module"] . "</td>";
        echo "<td>" . $row["coefficient"] . "</td>";
        echo "<td>" . $row["volume_horaire"] . "</td>";
        echo "<td>" . $row["fil"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No modules found in the database.";
}

$conn->close();
?>
