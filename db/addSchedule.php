<?php
include('connect.php');

function checkScheduleConflict($newSchedule, $existingSchedules)
{
    foreach ($existingSchedules as $schedule) {
        $existingStart = strtotime($schedule['timeIn']);
        $existingEnd = strtotime($schedule['timeOut']);
        $newStart = strtotime($newSchedule['timeIn']);
        $newEnd = strtotime($newSchedule['timeOut']);

        if ($newSchedule['section'] == $schedule['section'] && $newStart < $existingEnd && $newEnd > $existingStart) {
            return true;
        }
    }

    return false;
}

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
            $stmt = $conn->prepare("SELECT timeIn, timeOut FROM schedules WHERE instructor = ?");
            $stmt->bind_param("s", $instructorName);
            $stmt->execute();
            $existingSchedules = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            $stmt = $conn->prepare("INSERT INTO schedules (section, strand, subject, instructor, day, timeIn, timeOut) VALUES (?, ?, ?, ?, ?, ?, ?)");


            $numDays = count($_POST["days"]);

            for ($i = 0; $i < $numDays; $i++) {
                $selectedDay = $_POST["days"][$i];

                $timeIn = date("H:i", strtotime($_POST["timeIn"][$i]));
                $timeOut = date("H:i", strtotime($_POST["timeOut"][$i]));

                $newSchedule = array(
                    'timeIn' => $timeIn,
                    'timeOut' => $timeOut
                );

                if (checkScheduleConflict($newSchedule, $existingSchedules)) {
                    echo "<script>alert('Schedule conflict detected for $selectedDay in section $inputSection.');</script>";
                    exit();
                }

                $stmt->bind_param("sssssss", $inputSection, $inputStrand, $subjectName, $instructorName, $selectedDay, $timeIn, $timeOut);

                if (!$stmt->execute()) {
                    echo "Error inserting schedule for $selectedDay: " . $stmt->error;
                    exit();
                }
            }
            echo "Schedule added successfully.";
            header("Location: generate.php");
            exit();
        } else {
            echo "Instructor not found.";
            exit();
        }
    } else {

        echo "Please provide all required information.";
    }
}
