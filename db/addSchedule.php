<?php
include ('connect.php');

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

                $insertQuery = "INSERT INTO schedules (section, strand, subject, instructor, day, time) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);
                if ($stmt) {
                    $numDays = count($_POST["days"]);
                    for ($i = 0; $i < $numDays; $i++) {
                        $selectedDay = filter_var($_POST["days"][$i], FILTER_SANITIZE_STRING);
                        $timeInRaw = $_POST["timeIn"][$i];
                        $timeOutRaw = $_POST["timeOut"][$i];
                        $timeIn = strtotime($timeInRaw);
                        $timeOut = strtotime($timeOutRaw);

                        if ($timeIn === false || $timeOut === false) {
                            echo "Error parsing time: Time In: $timeInRaw, Time Out: $timeOutRaw";
                        } else {
                            $timeInFormatted = date("h:i A", $timeIn);
                            $timeOutFormatted = date("h:i A", $timeOut);
                            $time = $timeInFormatted . ' - ' . $timeOutFormatted;
                        }

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
    } else {
        echo "Please provide all required information.";
    }

    header("Location: generate.php");
    exit();
}
?>