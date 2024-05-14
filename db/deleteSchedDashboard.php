<?php
include('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected'])) {

    $selectedRows = $_POST['selected'];

    foreach ($selectedRows as $id) {

        $sql = "DELETE FROM schedule_again WHERE id = $id";
        if ($conn->query($sql) === FALSE) {
            echo "Error deleting record: " . $conn->error;
        }
    }
    header("Location: dashboard.php");
}

$conn->close();
