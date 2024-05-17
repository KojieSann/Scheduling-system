<?php
include('connect.php');

$subject_name = $_POST['subject_name'];
$subject_code = $_POST['subject_code'];
$grade_level = $_POST['grade_level'];
$strand = isset($_POST['strand']) ? implode(", ", $_POST['strand']) : '';

$stmt = $conn->prepare("INSERT INTO subjects (subject_name, subject_code,  grade_level, strand) VALUES (?,?,?,?)");

$stmt->bind_param("ssss", $subject_name, $subject_code, $grade_level, $strand);
$stmt->execute();

$stmt->close();
$conn->close();


header('Location: subject.php');
exit();
