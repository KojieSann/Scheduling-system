<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['selected'])) {

    $selectedRows = $_POST['selected'];

    $conn->begin_transaction();

    try {
        foreach ($selectedRows as $id) {
            $sql_fetch = "SELECT section FROM schedule_again WHERE id = ?";
            $stmt_fetch = $conn->prepare($sql_fetch);
            $stmt_fetch->bind_param("i", $id);
            $stmt_fetch->execute();
            $result = $stmt_fetch->get_result();
            $row = $result->fetch_assoc();
            $stmt_fetch->close();

            if ($row) {
                $section = $row['section'];

                $sql_delete_schedules = "DELETE FROM schedules WHERE section = ?";
                $stmt_delete_schedules = $conn->prepare($sql_delete_schedules);
                $stmt_delete_schedules->bind_param("s", $section);
                $stmt_delete_schedules->execute();
                $stmt_delete_schedules->close();
            }

            $sql_delete_schedule = "DELETE FROM schedule_again WHERE id = ?";
            $stmt_delete_schedule = $conn->prepare($sql_delete_schedule);
            $stmt_delete_schedule->bind_param("i", $id);
            $stmt_delete_schedule->execute();
            $stmt_delete_schedule->close();
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    header("Location: dashboard.php");
    exit();
}

$conn->close();
?>