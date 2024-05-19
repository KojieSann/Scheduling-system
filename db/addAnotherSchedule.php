<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
<<<<<<< Updated upstream

    $sem = $_POST['sem'];
    $school_year = $_POST['sy'];
=======
    $sem = filter_input(INPUT_POST, 'sem', FILTER_SANITIZE_STRING);
    $school_year = filter_input(INPUT_POST, 'school_year', FILTER_SANITIZE_STRING);
>>>>>>> Stashed changes
    $advisers = isset($_POST['adviser']) ? $_POST['adviser'] : array();
    $inputSection = filter_input(INPUT_POST, 'inputSection', FILTER_SANITIZE_STRING);
    $inputStrand = filter_input(INPUT_POST, 'inputStrand', FILTER_SANITIZE_STRING);

<<<<<<< Updated upstream
    $inputSection = isset($_POST['inputSection']) ? $_POST['inputSection'] : '';
    $inputStrand = isset($_POST['inputStrand']) ? $_POST['inputStrand'] : '';


    $stmt = $conn->prepare("INSERT INTO schedule_again (section, strand ,sem, school_year, adviser) VALUES (?, ?, ?, ?, ?)");
=======
    $stmt = $conn->prepare("INSERT INTO schedule_again (section, strand, sem, school_year, adviser) VALUES (?, ?, ?, ?, ?)");
>>>>>>> Stashed changes
    $stmt->bind_param("sssss", $inputSection, $inputStrand, $sem, $school_year, $adviser);

    foreach ($advisers as $adviser) {
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
    header("Location: generate.php");
    exit();
}
