<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["days"]) && !empty($_POST["days"]) &&
        isset($_POST["timeIn"]) && !empty($_POST["timeIn"]) &&
        isset($_POST["timeOut"]) && !empty($_POST["timeOut"]) &&
        isset($_POST["modalSubjectName"]) &&
        isset($_POST["instructorSelect"])
    ) {

        $subjectName = $_POST["modalSubjectName"];

        $inputSection = $_POST['inputSection'];
        $inputStrand = $_POST['inputStrand'];

        $selectedInstructor = $_POST["instructorSelect"];

        $query = "SELECT first_name, last_name FROM teachers WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $selectedInstructor);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $instructorName = $row['first_name'] . ' ' . $row['last_name'];

            $stmt = $conn->prepare("INSERT INTO schedules (section, strand, subject, instructor, day, timeIn, timeOut) VALUES (?, ?, ?, ?, ?, ?, ?)");


            $numDays = count($_POST["days"]);


            for ($i = 0; $i < $numDays; $i++) {
                $selectedDay = $_POST["days"][$i];
                $timeIn = date("h:i A", strtotime($_POST["timeIn"][$i]));
                $timeOut = date("h:i A", strtotime($_POST["timeOut"][$i]));

                $stmt->bind_param("sssssss", $inputSection, $inputStrand, $subjectName, $instructorName, $selectedDay, $timeIn, $timeOut);

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
    header("Location: generate.php");
}
