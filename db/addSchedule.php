<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["days"]) && !empty($_POST["days"]) &&
        isset($_POST["modalSubjectName"]) && !empty($_POST["modalSubjectName"]) &&
        isset($_POST["instructorSelect"]) && !empty($_POST["instructorSelect"]) &&
        isset($_POST['inputSection']) && !empty($_POST['inputSection']) &&
        isset($_POST['inputStrand']) && !empty($_POST['inputStrand'])
    ) {
        $subjectName = htmlspecialchars($_POST["modalSubjectName"]);
        $inputSection = htmlspecialchars($_POST['inputSection']);
        $inputStrand = htmlspecialchars($_POST['inputStrand']);
        $selectedInstructor = (int) $_POST["instructorSelect"];

        $query = "SELECT first_name, last_name FROM teachers WHERE id = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $selectedInstructor);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $instructorName = $row['first_name'] . ' ' . $row['last_name'];
                $stmt->close();

                $insertQuery = "INSERT INTO schedules (section, strand, subject, instructor, day, duration, time) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);

                if ($stmt) {
                    foreach ($_POST["days"] as $day) {
                        $selectedDay = htmlspecialchars($day);
                        $timeInArray = $_POST["timeIn" . $selectedDay];
                        $timeOutArray = $_POST["timeOut" . $selectedDay];

                        for ($i = 0; $i < count($timeInArray); $i++) {
                            $timeIn = strtotime($timeInArray[$i]);
                            $timeOut = strtotime($timeOutArray[$i]);

                            if ($timeIn !== false && $timeOut !== false) {

                                $timeDiffInSeconds = $timeOut - $timeIn;
                                $timeDiffInMinutes = round($timeDiffInSeconds / 60); // Convert to minutes

                                // Concatenate "minutes" with the duration
                                $durationWithUnit = $timeDiffInMinutes . " Minutes";

                                $time = date("h:i A", $timeIn) . ' - ' . date("h:i A", $timeOut);

                                $stmt->bind_param("sssssss", $inputSection, $inputStrand, $subjectName, $instructorName, $selectedDay, $durationWithUnit, $time);
                                if (!$stmt->execute()) {
                                    echo "Failed to add schedule for $selectedDay at $time: " . $stmt->error . "<br>";
                                }
                            } else {
                                echo "Error parsing time for $selectedDay.<br>";
                            }
                        }
                    }

                    echo "Schedules processed successfully.";
                    $stmt->close();
                } else {
                    echo "Error preparing insert statement: " . $conn->error;
                }
            } else {
                echo "Instructor not found.";
            }
        } else {
            echo "Error preparing select statement: " . $conn->error;
        }
    } else {
        echo "Please provide all required information.";
    }

    header("Location: generate.php");
    exit();
}
