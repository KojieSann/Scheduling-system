<?php
include('connect.php');

if(isset($_GET['id'])){
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "DELETE FROM teachers WHERE id = '$id'";
    
    if(mysqli_query($conn, $sql)) {
        header("Location: teachers.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "No ID specified for deletion.";
}
?>