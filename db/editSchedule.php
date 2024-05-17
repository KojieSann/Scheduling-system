<?php
include('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rowData'])) {
    $rowData = $_POST['rowData'];
    $stmt = $conn->prepare("INSERT INTO schedules (section, strand, day, subject, timeIn, timeOut, instructor) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $rowData[1], $rowData[2], $rowData[3], $rowData[4], $rowData[5], $rowData[6], $rowData[7]);
    if ($stmt->execute()) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
