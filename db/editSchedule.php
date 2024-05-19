<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rowData'])) {
    $rowData = $_POST['rowData'];

    // Check if $rowData is an array and has at least 7 elements
    if (is_array($rowData) && count($rowData) >= 6) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("UPDATE schedules SET section=?, strand=?, day=?, subject=?, instructor=?, time=? WHERE id=?");

        // Bind parameters by reference
        $stmt->bind_param("ssssssi", $rowData[1], $rowData[2], $rowData[3], $rowData[4], $rowData[5], $rowData[6], $rowData[0]);

        if ($stmt->execute()) {
            echo "Data updated successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Invalid input data.";
    }

    $conn->close();
}
?>