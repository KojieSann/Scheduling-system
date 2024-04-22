<?php
include ('connect.php');

$section_name = $_POST['section_name'];
$grade_level = $_POST['grade_level'];
$strand = $_POST['strand'];

$stmt = $conn->prepare("INSERT INTO sections (section_name, grade_level, strand) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $section_name, $grade_level, $strand);
$stmt->execute();

header('Location: section.php');
$stmt->close();
$conn->close();
?>