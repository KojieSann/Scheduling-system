<?php
include('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["days"]) && !empty($_POST["days"])) {

        $stmt = $conn->prepare("INSERT INTO schedules (day) VALUES (?)");

        // Bind parameters and execute the statement for each selected date
        $stmt->bind_param("s", $selected_day);
        foreach ($_POST["days"] as $selected_day) {
            $stmt->execute();
        }

        // Optionally, you can redirect the user to a success page after insertion

        exit();
    } else {
        // Handle case where no dates were selected
        echo "Please select at least one date.";
    }
}
