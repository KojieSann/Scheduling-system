<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

include('connect.php');

function sendData($data) {
    echo "data: " . json_encode($data) . "\n\n";
    ob_flush();
    flush();
}

while (true) {
    $query = "SELECT * FROM schedules ORDER BY id DESC";
    $result = $conn->query($query);
    $schedules = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $schedules[] = $row;
        }
    }

    sendData($schedules);   

    sleep(2);
}
?>