<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit;
}

include('connect.php');

// Get section name from POST request
$section_name = $_POST['section'] ?? null;

if ($section_name) {
    // Prepare SQL to delete from schedules where the section name matches
    $sql1 = "DELETE FROM schedules WHERE section = ?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("s", $section_name);
    $stmt1->execute();

    // Prepare SQL to delete from schedule_again where the section name matches
    $sql2 = "DELETE FROM schedule_again WHERE section = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("s", $section_name);
    $stmt2->execute();

    // Check for errors
    if ($stmt1->error || $stmt2->error) {
        echo "<script>alert('Error deleting record: " . $conn->error . "'); window.location.href='dashboard.php';</script>";
        $stmt1->close();
        $stmt2->close();
        $conn->close();
        exit;
    } else {
        echo "<script>alert('Records deleted successfully'); window.location.href='dashboard.php';</script>";
        $stmt1->close();
        $stmt2->close();
        $conn->close();
        exit;
    }
} else {
    echo "<script>alert('No Section deleted'); window.location.href='dashboard.php';</script>";
    exit;
}
?>