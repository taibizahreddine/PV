<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection (adjust with your parameters)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tppaw";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id_to_modify = $_GET['id'];

    // Ensure that the ID to modify is valid (e.g., it exists in the database)

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modifier'])) {
        // Get the new values of the fields from the form
        $nouveau_code_module = $conn->real_escape_string($_POST['nouveau_code_module']);
        $nouvelle_designation_module = $conn->real_escape_string($_POST['nouvelle_designation_module']);
        $nouveau_coefficient = floatval($_POST['nouveau_coefficient']);
        $nouveau_volume_horaire = intval($_POST['nouveau_volume_horaire']);
        $nouvelle_filiere = $conn->real_escape_string($_POST['nouvelle_filiere']);

        // Update the record in the database
        $modification_query = "UPDATE modules SET 
            code_module = '$nouveau_code_module', 
            designation_module = '$nouvelle_designation_module', 
            coefficient = $nouveau_coefficient, 
            volume_horaire = $nouveau_volume_horaire, 
            filiere = '$nouvelle_filiere' 
            WHERE id = $id_to_modify";

        if ($conn->query($modification_query) === TRUE) {
            echo "Record with ID $id_to_modify has been successfully modified.";
        } else {
            echo "Error modifying the record: " . $conn->error;
        }
    } else {
        // Display the modification form
        $query = "SELECT * FROM modules WHERE id = $id_to_modify";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Display the modification form with the fields pre-filled
            echo "<h2>Modify Record:</h2>";
            echo "<form method='post'>";
            echo "Code Module: <input type='text' name='nouveau_code_module' value='" . $row['code_module'] . "'><br>";
            echo "Designation Module: <input type='text' name='nouvelle_designation_module' value='" . $row['designation_module'] . "'><br>";
            echo "Coefficient: <input type='text' name='nouveau_coefficient' value='" . $row['coefficient'] . "'><br>";
            echo "Volume Horaire: <input type='text' name='nouveau_volume_horaire' value='" . $row['volume_horaire'] . "'><br>";
            echo "Filiere: <select name='nouvelle_filiere'>";
            $filiere_options = ['TC', '2SC', '3ISIL', '3SI', 'M1', 'M2ISI', 'M2WIC', 'M2RSSI', '1ING', '2ING'];
            foreach ($filiere_options as $option) {
                echo "<option value='$option' " . ($row['filiere'] == $option ? 'selected' : '') . ">$option</option>";
            }
            echo "</select><br>";
            echo "<input type='submit' name='modifier' value='Modifier'>";
            echo "</form>";
        } else {
            echo "Invalid ID.";
        }
    }
}

$conn->close();
?>
