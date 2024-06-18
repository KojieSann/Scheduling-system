<?php

include('connect.php');

$inputSection = mysqli_real_escape_string($conn, $_POST['inputSection']);
$inputStrand = mysqli_real_escape_string($conn, $_POST['inputStrand']);
$inputGradeLevel = mysqli_real_escape_string($conn, $_POST['inputGradeLevel']);
$schoolYear = mysqli_real_escape_string($conn, $_POST['school_year']);
$semester = mysqli_real_escape_string($conn, $_POST['sem']);
$adviser = mysqli_real_escape_string($conn, $_POST['adviser']);
$sql = "INSERT INTO schedule_again (section, strand, grade_level, school_year, sem, adviser) 
            VALUES ('$inputSection', '$inputStrand', '$inputGradeLevel', '$schoolYear', '$semester', '$adviser')";

if (mysqli_query($conn, $sql)) {
    echo "Records inserted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
header("location: generate.php");
mysqli_close($conn);
