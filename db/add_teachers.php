<?php
include('connect.php');

$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$time = $_POST['time'];
$strand = $_POST['strand'];
$days = isset($_POST['day']) ? implode(", ", $_POST['day']) : '';
$subjects = isset($_POST['subject']) ? implode(", ", $_POST['subject']) : '';

if (!empty($days)) {
    $day = $days;
} else {
    $day = 'No days selected';
}

if (!empty($subjects)) {
    $subject = $subjects;
} else {
    $subject = 'No subjects selected';
}

$stmt = $conn->prepare("INSERT INTO teachers (first_name, middle_name, last_name, time, day, strand, subject) VALUES (?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssss", $first_name, $middle_name, $last_name, $time, $day, $strand, $subject);
$stmt->execute();
$stmt->close();

header('Location: teachers.php');
