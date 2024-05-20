<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $requiredFields = ['days', 'timeIn', 'timeOut', 'modalSubjectName', 'instructorSelect', 'inputSection', 'inputStrand'];
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            die("Please provide all required information.");
        }
    }

    $subjectName = htmlspecialchars($_POST["modalSubjectName"]);
    $inputSection = htmlspecialchars($_POST['inputSection']);
    $inputStrand = htmlspecialchars($_POST['inputStrand']);
    $selectedInstructor = (int) $_POST["instructorSelect"];
    
    // Fetch instructor details
    $query = "SELECT first_name, last_name FROM teachers WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error preparing select statement.");
    }
    
    $stmt->bind_param("i", $selectedInstructor);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows !== 1) {
        die("Instructor not found.");
    }
    
    $row = $result->fetch_assoc();
    $instructorName = $row['first_name'] . ' ' . $row['last_name'];
    
    $stmt->close();

    // Prepare the insert statement
    $insertQuery = "INSERT INTO schedules (section, strand, subject, instructor, day, time) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    if (!$stmt) {
        die("Error preparing insert statement.");
    }
    
    // Begin transaction
    $conn->begin_transaction();

    try {
        $numDays = count($_POST["days"]);
        for ($i = 0; $i < $numDays; $i++) {
            $selectedDay = filter_var($_POST["days"][$i], FILTER_SANITIZE_STRING);
            $timeIn = date("h:i:A", strtotime($_POST["timeIn"][$i]));
            $timeOut = date("h:i:A", strtotime($_POST["timeOut"][$i]));
            $time = $timeIn . ' - ' . $timeOut;

            // Check for time conflicts for the same section, subject, and instructor
            $conflictQuery = "SELECT COUNT(*) FROM schedules WHERE
                                (section = ? OR subject = ? OR instructor = ?) AND
                                day = ? AND (
                                    (time >= ? AND time < ?) OR
                                    (time >= ? AND time < ?) OR
                                    (? >= time AND ? < time)
                                )";
            $conflictStmt = $conn->prepare($conflictQuery);
            $conflictStmt->bind_param("sssssssssss", $inputSection, $subjectName, $instructorName, $selectedDay, $timeIn, $timeOut, $timeIn, $timeOut, $timeIn, $timeOut);
            $conflictStmt->execute();
            $conflictStmt->bind_result($conflictCount);
            $conflictStmt->fetch();
            $conflictStmt->close();

            if ($conflictCount > 0) {
                $conn->rollback();
                die("Conflict detected: Time slot overlaps with another schedule for the same section, subject, or instructor.");
            }

            // Insert the schedule
            $stmt->bind_param("ssssss", $inputSection, $inputStrand, $subjectName, $instructorName, $selectedDay, $time);
            $stmt->execute();
        }
        
        // Commit transaction
        $conn->commit();
        echo "Schedule added successfully."; // Return success message
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        die("Error inserting schedule: " . $e->getMessage());
    }

    $stmt->close();
    $conn->close();
    exit(); // Exit after sending response
}
?>
