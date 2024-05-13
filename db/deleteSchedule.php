<?php
include('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected'])) {

    $selectedRows = $_POST['selected'];

    foreach ($selectedRows as $id) {

        $sql = "DELETE FROM schedules WHERE id = $id";
        if ($conn->query($sql) === FALSE) {
            echo "Error deleting record: " . $conn->error;
        }
    }
    header("Location: generate.php");
}

$conn->close();
