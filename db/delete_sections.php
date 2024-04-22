<?php
include('connect.php');

if(isset($_GET['id'])) {
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "DELETE FROM sections WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: section.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "No ID specified for deletion.";
}
?>