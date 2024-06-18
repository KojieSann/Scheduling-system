<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $section = $_POST['section'];
    $strand = $_POST['strand'];
    $day = $_POST['day'];
    $subject = $_POST['subject'];
    $time = $_POST['time'];
    $instructor = $_POST['instructor'];

    $update_query = "UPDATE schedules SET section='$section', strand='$strand', day='$day', subject='$subject', time='$time', instructor='$instructor' WHERE id='$id'";

    if (mysqli_query($conn, $update_query)) {
        echo "Schedule updated successfully!";
    } else {
        echo "Error updating schedule: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request method!";
}
