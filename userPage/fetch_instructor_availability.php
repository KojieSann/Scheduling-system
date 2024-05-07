<?php
include('connect.php');

if (isset($_GET['id'])) {
    $instructorId = $_GET['id'];
  
    $sql = "SELECT day, time FROM teachers WHERE id = $instructorId";
    $result = mysqli_query($conn, $sql);
  
    $availability = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $days = explode(', ', $row['day']);
      foreach ($days as $day) {
        $availability['days'][] = strtolower($day);
      }
      $availability['time'] = $row['time'];
    }
  
    echo json_encode($availability);
} else {
    echo json_encode([]);
}
?>