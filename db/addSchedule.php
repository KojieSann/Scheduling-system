<?php
include('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["days"]) && !empty($_POST["days"])) {

        $stmt = $conn->prepare("INSERT INTO schedules (day) VALUES (?)");
        $stmt->bind_param("s", $selected_day);
        foreach ($_POST["days"] as $selected_day) {
            $stmt->execute();
        }

        exit();
    } else {
        echo "Please select at least one date.";
    }
}
