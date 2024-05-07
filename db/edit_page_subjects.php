<?php
include('connect.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $conn->prepare("SELECT * FROM subjects WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
  } else {
    header("Location: subject.php");
    exit();
  }
} else {
  header("Location: subject.php");
  exit();
}

function searchSubjects($conn, $searchTerm)
{
  $stmt = $conn->prepare("SELECT * FROM subjects WHERE subject_name LIKE ? OR subject_code LIKE ? OR school_year LIKE ? OR grade_level LIKE ?");
  $searchTerm = "%$searchTerm%";
  $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
  $stmt->execute();
  $result = $stmt->get_result();
  return $result;
}

if (isset($_GET['search'])) {
  $searchTerm = $_GET['search'];
  $result = searchSubjects($conn, $searchTerm);
} else {
  $sql = "SELECT * FROM subjects";
  $result = $conn->query($sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['id'], $_POST['subject_name'], $_POST['subject_code'], $_POST['school_year'], $_POST['grade_level'],  $_POST['strand'])) {
    $id = $_POST['id'];
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $school_year = $_POST['school_year'];
    $grade_level = $_POST['grade_level'];
    $strand = isset($_POST['strand']) ? implode(", ", $_POST['strand']) : '';

    $stmt = $conn->prepare("UPDATE subjects SET subject_name=?, subject_code=?, school_year=?, grade_level=?, strand=? WHERE id=?");
    $stmt->bind_param("sssssi", $subject_name, $subject_code, $school_year, $grade_level, $strand, $id);
    if ($stmt->execute()) {
      header("Location: edit_page_subjects.php?id=$id");
      exit();
    } else {
      echo "Error updating record: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olivarez College Tagaytay</title>
  <link rel="stylesheet" href="subject.css" />
  <link rel="icon" type="x-icon" href="./img/olivarez-college-tagaytay-logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container">
    <nav>
      <div class="logo">
        <img src="./img/olivarez-college-tagaytay-logo.png" alt="" />
        <span>Olivarez College <br />
          Tagaytay</span>
      </div>
      <ul>
        <li class="list-items">
          <a href="./generate.php"><i class="fa-solid fa-circle-plus"></i><span class="nav-lists">Generate Schedule</span></a>
        </li>
        <li class="list-items">
          <a href="./dashboard.php"><i class="fa-solid fa-tv"></i><span class="nav-lists">Dashboard</span></a>
        </li>
        <li class="list-items">
          <a href="./teachers.php"><i class="fa-solid fa-chalkboard-user"></i><span class="nav-lists">Teachers</span></a>
        </li>
        <li class="list-items">
          <a href="./section.php"><i class="fa-solid fa-users-rectangle"></i><span class="nav-lists">Sections</span></a>
        </li>
        <li class="list-items">
          <a href="./subject.php" class="active"><i class="fa-solid fa-book"></i><span class="nav-lists">Subjects</span></a>
        </li>
        <li>
          <a href="./login.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i><span class="nav-lists">Logout</span></a>
        </li>
      </ul>
    </nav>
    <section class="main-content">
      <div class="main-logo">
        <h1>Edit <span>Subject</span></h1>
        <div class="edit-container">
          <a href="./subject.php">Back</a>
        </div>
        <i class="fa-solid fa-user"></i>
      </div>
      <div class="inputs">
        <form action="" method="post">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="subject-code">
            <div class="subj-code">
              <span>Subject<span style="color: red; font-size: 1.3em">*</span></span>
              <input required type="text" class="first-name input" autocomplete="off" name="subject_name" value="<?php echo $row['subject_name']; ?>" />
            </div>
            <div class="subj-code">
              <span>Subject Code<span style="color: red; font-size: 1.3em">*</span></span>
              <input required type="text" class="first-name input" autocomplete="off" name="subject_code" value="<?php echo $row['subject_code']; ?>" />
            </div>
          </div>
          <div class="yrlvl-gradelvl">
            <div class="year-level">
              <span>School Year<span style="color: red; font-size: 1.3em">*</span></span>
              <input required type="text" class="first-name input" autocomplete="off" name="school_year" value="<?php echo $row['school_year']; ?>" />
            </div>
            <div class="dropdown-gradelvl">
              <span class="input-info">Grade Level<span style="color: red; font-size: 1.3em">*</span></span>
              <input type="text" class="textbox-grade input" placeholder="No grade level selected" readonly name="grade_level" value="<?php echo $row['grade_level']; ?>" />
              <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>

              <div class="option-grade">
                <div onclick="show('Grade 11')">Grade 11</div>
                <div onclick="show('Grade 12')">Grade 12</div>
              </div>
            </div>
          </div>
          <div class="strand-dropdown">
            <span class="input-info">
              Strand<span style="color: red; font-size: 1.3em">*</span>
            </span>

            <select name="strand[]" multiple multiselect-select-all="true">
              <?php
              $selected_strand = explode(", ", $row['strand']);
              $strands = array("GAS", "STEM", "TVL", "ICT", "ABM");
              foreach ($strands as $strand) {
                $selected = in_array($strand, $selected_strand) ? 'selected' : '';
                echo "<option value='$strand' $selected>$strand</option>";
              }
              ?>
            </select>
          </div>

          <div class="button-submit">
            <button type="submit" class="btn-submit">Update</button>
          </div>



        </form>
      </div>

      <div class="subject-table">
        <div class="table-header">
          <span>List of sections</span>
          <div class="table-search">
            <form class="search-container">
              <input id="search-box" type="text" class="search-box" name="" />
              <label for="search-box"><i class="fa-solid fa-magnifying-glass search-icon"></i></label>
              <input type="submit" id="search-submit" />
            </form>
          </div>
        </div>
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th>Subject</th>
                <th>Subject Code</th>
                <th>School Year</th>
                <th>Grade Level</th>
                <th>Strand</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody st>
              <?php

              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['subject_name'] . "</td>";
                echo "<td>" . $row['subject_code'] . "</td>";
                echo "<td>" . $row['school_year'] . "</td>";
                echo "<td>" . $row['grade_level'] . "</td>";
                echo "<td>" . $row['strand'] . "</td>";
                echo "<td> <a href='edit_page_subjects.php?id=" . $row['id'] . "'><button class='edit'><i class='fa-solid fa-pen'></i></button></a> 
                  <a href='delete_subjects.php?id=" . $row['id'] . "'> <button  class='delete' type='submit' name='delete'><i class='fa-solid fa-trash-can'></i></button></a> 
                  </td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
  <script src="editSubj.js"></script>
</body>

</html>