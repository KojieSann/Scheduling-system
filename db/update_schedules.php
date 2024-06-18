<?php
include('connect.php');

$data = json_decode(file_get_contents('php://input'), true);

foreach ($data as $schedule) {
  $id = $schedule['id'];
  $section = $schedule['section'];
  $strand = $schedule['strand'];
  $day = $schedule['day'];
  $subject = $schedule['subject'];
  $time = $schedule['time'];
  $duration = $schedule['duration'];
  $instructor = $schedule['instructor'];

  $query = "UPDATE schedules SET section = '$section', strand = '$strand', day = '$day', subject = '$subject', time = '$time', duration = '$duration', instructor = '$instructor' WHERE id = '$id'";
  $conn->query($query);
}

$conn->close();
?>