<?php
include('connect.php');

function checkForConflicts($conn, $section, $strand, $instructor, $day, $startTime, $endTime)
{
    $startTime = date("H:i:s", strtotime($startTime));
    $endTime = date("H:i:s", strtotime($endTime));
    
    // Corrected SQL query with time conditions for both section and instructor
    $conflictQuery = "SELECT * FROM schedules WHERE 
        (
            section = ? AND strand = ? AND day = ? 
            AND (
                (SUBSTRING_INDEX(time, ' - ', 1) < ? AND ADDTIME(SUBSTRING_INDEX(time, ' - ', 1), SEC_TO_TIME(duration * 60)) > ?) 
                OR 
                (SUBSTRING_INDEX(time, ' - ', 1) < ? AND ADDTIME(SUBSTRING_INDEX(time, ' - ', 1), SEC_TO_TIME(duration * 60)) > ?)
            )
        ) 
        OR 
        (
            instructor = ? AND day = ? 
            AND (
                (SUBSTRING_INDEX(time, ' - ', 1) < ? AND ADDTIME(SUBSTRING_INDEX(time, ' - ', 1), SEC_TO_TIME(duration * 60)) > ?) 
                OR 
                (SUBSTRING_INDEX(time, ' - ', 1) < ? AND ADDTIME(SUBSTRING_INDEX(time, ' - ', 1), SEC_TO_TIME(duration * 60)) > ?)
            )
        )";
    
    $stmt = $conn->prepare($conflictQuery);
    
    $stmt->bind_param("sssssssssssss", 
        $section, $strand, $day, 
        $endTime, $startTime, $endTime, $startTime,
        $instructor, $day,
        $endTime, $startTime, $endTime, $startTime
    );
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    return $result->num_rows > 0;
}
// Function to insert a new schedule
function insertSchedule($conn, $section, $strand, $subject, $instructor, $day, $duration, $time)
{
    $insertQuery = "INSERT INTO schedules (section, strand, subject, instructor, day, duration, time) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssssss", $section, $strand, $subject, $instructor, $day, $duration, $time);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subjectName = filter_input(INPUT_POST, "modalSubjectName", FILTER_SANITIZE_STRING);
    $inputSection = filter_input(INPUT_POST, "inputSection", FILTER_SANITIZE_STRING);
    $inputStrand = filter_input(INPUT_POST, "inputStrand", FILTER_SANITIZE_STRING);
    $selectedInstructor = filter_input(INPUT_POST, "instructorSelect", FILTER_VALIDATE_INT);

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

            foreach ($_POST["days"] as $day) {
                $timeInArray = $_POST["timeIn" . $day];
                $timeOutArray = $_POST["timeOut" . $day];

                for ($i = 0; $i < count($timeInArray); $i++) {
                    $timeIn = strtotime($timeInArray[$i]);
                    $timeOut = strtotime($timeOutArray[$i]);
                    $startTime = date("H:i", $timeIn);
                    $endTime = date("H:i", $timeOut);
                    $duration = ($timeOut - $timeIn) / 60;

                    // Check for conflicts
                    if (!checkForConflicts($conn, $inputSection, $inputStrand, $instructorName, $day, $startTime, $endTime)) {
                        insertSchedule($conn, $inputSection, $inputStrand, $subjectName, $instructorName, $day, $duration . ' minutes', $startTime . ' - ' . $endTime);
                    } else {
                        http_response_code(409); 
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
