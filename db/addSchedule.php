<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["days"]) && !empty($_POST["days"]) &&
        isset($_POST["timeIn"]) && !empty($_POST["timeIn"]) &&
        isset($_POST["timeOut"]) && !empty($_POST["timeOut"]) &&
        isset($_POST["modalSubjectName"]) && !empty($_POST["modalSubjectName"]) &&
        isset($_POST["instructorSelect"]) && !empty($_POST["instructorSelect"]) &&
        isset($_POST['inputSection']) && !empty($_POST['inputSection']) &&
        isset($_POST['inputStrand']) && !empty($_POST['inputStrand'])
    ) {
        $subjectName = htmlspecialchars($_POST["modalSubjectName"]);
        $inputSection = htmlspecialchars($_POST['inputSection']);
        $inputStrand = htmlspecialchars($_POST['inputStrand']);
        $selectedInstructor = (int)$_POST["instructorSelect"];

        // Check for schedule conflicts
        $conflict = false;
        $conflictingSchedules = [];

        $numDays = count($_POST["days"]);
        for ($i = 0; $i < $numDays; $i++) {
            $selectedDay = filter_var($_POST["days"][$i], FILTER_SANITIZE_STRING);
            $timeIn = date("H:i:s", strtotime($_POST["timeIn"][$i]));
            $timeOut = date("H:i:s", strtotime($_POST["timeOut"][$i]));

            $query = "SELECT * FROM schedules 
                      WHERE day = ? 
                      AND ((time_in BETWEEN ? AND ?) OR (time_out BETWEEN ? AND ?))";

            $stmt = $conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param("sssss", $selectedDay, $timeIn, $timeOut, $timeIn, $timeOut);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $conflict = true;
                    while ($row = $result->fetch_assoc()) {
                        $conflictingSchedules[] = "Conflict with " . $row['subject'] . " on " . $row['day'] . " from " . $row['time'];
                    }
                }
                $stmt->close();
            }
        }

        if ($conflict) {
            echo "<script>alert('Conflicts found:\\n" . implode("\\n", $conflictingSchedules) . "');</script>";
        }if (!$conflict) {

            $query = "SELECT first_name, last_name FROM teachers WHERE id = ?";
            $stmt = $conn->prepare($query);
            if ($stmt) {
                $stmt->bind_param("i", $selectedInstructor);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    $instructorName = $row['first_name'] . ' ' . $row['last_name'];
        
                    $insertQuery = "INSERT INTO schedules (section, strand, subject, instructor, day, time) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($insertQuery);
                    if ($stmt) {
                        for ($i = 0; $i < $numDays; $i++) {
                            $selectedDay = filter_var($_POST["days"][$i], FILTER_SANITIZE_STRING);
                            $timeIn = date("H:i A", strtotime($_POST["timeIn"][$i]));
                            $timeOut = date("H:i A", strtotime($_POST["timeOut"][$i]));
                            $time = $timeIn . ' - ' . $timeOut;
        
                            $stmt->bind_param("ssssss", $inputSection, $inputStrand, $subjectName, $instructorName, $selectedDay, $time);
                            $stmt->execute();
                        }
        
                        echo "Schedule added successfully.";
                    } else {
                        echo "Error preparing insert statement.";
                    }
                } else {
                    echo "Instructor not found.";
                }
                $stmt->close();
            } else {
                echo "Error preparing select statement.";
            }
        }
    }
}
?>