<?php
include('connect.php');

// Assuming there is a database connection established

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected'])) {
    // Retrieve the selected row IDs
    $selectedRows = $_POST['selected'];

    // Loop through the selected rows and delete them from the database
    foreach ($selectedRows as $id) {
        // Perform deletion operation in the database
        $sql = "DELETE FROM schedules WHERE id = $id";
        if ($conn->query($sql) === FALSE) {
            echo "Error deleting record: " . $conn->error;
        }
    }
    header("Location: generate.php");
}

// Close the database connection
$conn->close();
