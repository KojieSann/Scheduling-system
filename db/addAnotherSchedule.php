<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sem = $_POST['sem'];
    $school_year1 = $_POST['sy'];
    $school_year2 = $_POST['sy2'];
    $advisers = isset($_POST['adviser']) ? $_POST['adviser'] : array();

    $inputSection = isset($_POST['inputSection']) ? $_POST['inputSection'] : '';
    $inputStrand = isset($_POST['inputStrand']) ? $_POST['inputStrand'] : '';

    $combined_school_year = $school_year1 . '-' . $school_year2;

    $stmt = $conn->prepare("INSERT INTO schedule_again (section, strand ,sem, school_year, adviser) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $inputSection, $inputStrand, $sem, $combined_school_year, $adviser);

    foreach ($advisers as $adviser) {
        $stmt->execute();
    }
    header("Location: generate.php");
    $stmt->close();

    exit();
}
?>
