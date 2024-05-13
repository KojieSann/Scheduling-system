<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if days, timeIn, timeOut, subjectName, and selectedSubject are set and not empty
    if (isset($_POST["days"]) && !empty($_POST["days"]) &&
        isset($_POST["timeIn"]) && !empty($_POST["timeIn"]) &&
        isset($_POST["timeOut"]) && !empty($_POST["timeOut"]) &&
        isset($_POST["modalSubjectName"])&&
        isset($_POST["instructorSelect"])) {

        // Retrieve subject name
        $subjectName = $_POST["modalSubjectName"];

        $inputSection = $_POST['inputSection'];
        $inputStrand = $_POST['inputStrand'];

        $selectedInstructor = $_POST["instructorSelect"];

        $query = "SELECT first_name, last_name FROM teachers WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $selectedInstructor);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if instructor exists
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $instructorName = $row['first_name'] . ' ' . $row['last_name'];

            // Prepare the SQL statement for inserting schedule
            $stmt = $conn->prepare("INSERT INTO schedules (section, strand, subject, instructor, day, timeIn, timeOut) VALUES (?, ?, ?, ?, ?, ?, ?)");

            // Get the number of selected days
            $numDays = count($_POST["days"]);

            // Loop through each selected day
            for ($i = 0; $i < $numDays; $i++) {
                $selectedDay = $_POST["days"][$i];
                $timeIn = date("h:i A", strtotime($_POST["timeIn"][$i])); // Format includes AM/PM
                $timeOut = date("h:i A", strtotime($_POST["timeOut"][$i])); // Format includes AM/PM

                // Bind parameters and execute the statement for each selected day
                $stmt->bind_param("sssssss",$inputSection, $inputStrand, $subjectName, $instructorName, $selectedDay, $timeIn, $timeOut);

                // Execute the SQL statement
                $stmt->execute();
            }

            echo "Schedule added successfully.";
            exit();
        } else {
            echo "Instructor not found.";
            exit();
        }
    } else {
        echo "Please provide all required information.";
    }
}
?>
