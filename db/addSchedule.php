<?php
include('connect.php');

// Function to check for schedule conflicts
function checkForConflicts($conn, $section, $strand, $instructor, $day, $startTime, $endTime) {
    // Ensure times are in 24-hour format
    $startTime = date("H:i:s", strtotime($startTime));
    $endTime = date("H:i:s", strtotime($endTime));

    $conflictQuery = "SELECT * FROM schedules WHERE 
        (section = ? AND strand = ? AND day = ?) OR 
        (instructor = ? AND day = ?) AND (
        (time <= ? AND ADDTIME(time, SEC_TO_TIME(duration * 60)) > ?) OR
        (time < ? AND ADDTIME(time, SEC_TO_TIME(duration * 60)) >= ?)
    )";
    $stmt = $conn->prepare($conflictQuery);
    // Bind parameters for both section/strand and instructor
    $stmt->bind_param("sssssssss", $section, $strand, $day, $instructor, $day, $startTime, $startTime, $endTime, $endTime);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    return $result->num_rows > 0;
}

// Function to insert a new schedule
function insertSchedule($conn, $section, $strand, $subject, $instructor, $day, $duration, $time) {
    $insertQuery = "INSERT INTO schedules (section, strand, subject, instructor, day, duration, time) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssssss", $section, $strand, $subject, $instructor, $day, $duration, $time);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $subjectName = filter_input(INPUT_POST, "modalSubjectName", FILTER_SANITIZE_STRING);
    $inputSection = filter_input(INPUT_POST, "inputSection", FILTER_SANITIZE_STRING);
    $inputStrand = filter_input(INPUT_POST, "inputStrand", FILTER_SANITIZE_STRING);
    $selectedInstructor = filter_input(INPUT_POST, "instructorSelect", FILTER_VALIDATE_INT);

    // Check if all required fields are filled
    if ($subjectName && $inputSection && $inputStrand && $selectedInstructor) {
        // Get instructor name
        $instructorQuery = "SELECT first_name, last_name FROM teachers WHERE id = ?";
        $stmt = $conn->prepare($instructorQuery);
        $stmt->bind_param("i", $selectedInstructor);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $instructorName = $row['first_name'] . ' ' . $row['last_name'];

            // Process each day's schedule
            foreach ($_POST["days"] as $day) {
                $timeInArray = $_POST["timeIn" . $day];
                $timeOutArray = $_POST["timeOut" . $day];

                for ($i = 0; $i < count($timeInArray); $i++) {
                    $timeIn = strtotime($timeInArray[$i]);
                    $timeOut = strtotime($timeOutArray[$i]);
                    $startTime = date("H:i ", $timeIn);
                    $endTime = date("H:i ", $timeOut);
                    $duration = ($timeOut - $timeIn) / 60;

                    // Check for conflicts
                    if (!checkForConflicts($conn, $inputSection, $inputStrand, $instructorName, $day, $startTime, $endTime)) {
                        // Insert schedule if no conflict
                        insertSchedule($conn, $inputSection, $inputStrand, $subjectName, $instructorName, $day, $duration . ' minutes', $startTime . ' - ' . $endTime);
                    } else {
                        http_response_code(409); // Conflict
                        echo "Conflict detected. Check theTable";
                        exit();
                    }
                }
            }
            echo "Schedules processed successfully.";
        } else {
            echo "Instructor not found.";
        }
        $stmt->close();
    } else {
        echo "Please provide all required information.";
    }
}
?>
