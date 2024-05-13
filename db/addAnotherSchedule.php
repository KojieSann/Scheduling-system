<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $section = $_POST['section'] ?? '';
    $strand = $_POST['strand'] ?? '';
    $schoolYear = $_POST['sy'] . '-' . $_POST['sy2'] ?? '';
    $semester = $_POST['sem'] ?? '';
    $advisers = $_POST['advisers'] ?? [];

    $advisersJson = json_encode($advisers);
    if ($advisersJson === false) {
        echo "Error encoding advisers data";
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO schedule_again (section, strand, school_year, sem, advisers) VALUES (:section, :strand, :schoolYear, :semester, :advisers)");
    $stmt->bindParam(':section', $section);
    $stmt->bindParam(':strand', $strand);
    $stmt->bindParam(':schoolYear', $schoolYear);
    $stmt->bindParam(':semester', $semester);
    $stmt->bindParam(':advisers', $advisersJson);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "Form data inserted successfully!";
    } else {
        echo "Error inserting form data";
    }
} else {
    echo "Invalid request";
}
?>
