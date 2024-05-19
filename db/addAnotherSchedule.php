<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sem = $_POST['sem'];
    $school_year = $_POST['sy'];
    $advisers = isset($_POST['adviser']) ? $_POST['adviser'] : array();

    $inputSection = isset($_POST['inputSection']) ? $_POST['inputSection'] : '';
    $inputStrand = isset($_POST['inputStrand']) ? $_POST['inputStrand'] : '';


    $stmt = $conn->prepare("INSERT INTO schedule_again (section, strand ,sem, school_year, adviser) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $inputSection, $inputStrand, $sem, $school_year, $adviser);

    foreach ($advisers as $adviser) {
        $stmt->execute();
    }
    header("Location: generate.php");
    $stmt->close();

    exit();
}
