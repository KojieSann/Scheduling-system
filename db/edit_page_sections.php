<?php
include('connect.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = mysqli_query($conn, "SELECT * FROM sections WHERE id = '$id'");
  $row = mysqli_fetch_assoc($query);
} else {
  header("Location: sections.php");
  exit();
}

$sql_subjects = "SELECT * FROM subjects";
$result_subjects = $conn->query($sql_subjects);

function searchTeachers($conn, $searchTerm)
{
  $sql = "SELECT * FROM sections WHERE section_name LIKE '%$searchTerm%' OR grade_level LIKE '%$searchTerm%' OR strand LIKE '%$searchTerm%'";
  $result = $conn->query($sql);
  return $result;
}
if (isset($_GET['search'])) {
  $searchTerm = $_GET['search'];
  $result = searchTeachers($conn, $searchTerm);
} else {
  $sql = "SELECT * FROM sections";
  $result = $conn->query($sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];
  $section_name = $_POST['section_name'];
  $grade_level = $_POST['grade_level'];
  $strand = $_POST['strand'];

  $update_query = "UPDATE sections SET section_name='$section_name', grade_level='$grade_level', strand='$strand'  WHERE id='$id'";

  if (mysqli_query($conn, $update_query)) {
    header("Location: edit_page_sections.php?id=$id");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olivarez College Tagaytay</title>
  <link rel="stylesheet" href="section.css" />
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
          <a href="./section.php" class="active"><i class="fa-solid fa-users-rectangle"></i><span class="nav-lists">Sections</span></a>
        </li>
        <li class="list-items">
          <a href="./subject.php"><i class="fa-solid fa-book"></i><span class="nav-lists">Subjects</span></a>
        </li>
        <li>
          <a class="logout"><i class="fa-solid fa-right-from-bracket"></i><span class="nav-lists">Logout</span></a>
        </li>
      </ul>
    </nav>
    <div class="bg-content-logout">
      <div class="content-logout">
        <img src="./img/shs-logo.png" alt="shs logo" class="shs-logo" />
        <div class="header-text">
          <span>Confirm Logout</span>
          <p style="font-size: 13px">Are you sure you want to logout?</p>
        </div>
        <div class="header-img">
          <img src="./img/undraw_login_re_4vu2.svg" alt="" />
        </div>
        <div class="btn">
          <button class="noBtn">Cancel</button>
          <a href="logout.php"><button class="yesBtn">Logout</button></a>
        </div>
      </div>
    </div>
    <section class="main-content">
      <div class="main-logo">
        <h1>Edit <span>Section</span></h1>
        <div class="edit-container">
          <a href="./section.php">Back</a>
        </div>
        <i class="fa-solid fa-user"></i>
      </div>
      <div class="inputs">
        <form action="" method="post">
          <input type="hidden" name="id" value="<?php echo $id; ?>">
          <div class="subject-code">
            <div class="subj-code">
              <span>Section Name<span style="color: red; font-size: 1.3em">*</span></span>
              <input required type="text" class="first-name" autocomplete="off" name="section_name" value="<?php echo $row['section_name']; ?>" />
            </div>
            <div class="subj-code">
              <div class="dropdown-gradelvl">
                <span class="input-info">Grade Level<span style="color: red; font-size: 1.3em">*</span></span>
                <input type="text" class="textbox-grade input" placeholder="No grade level selected" readonly name="grade_level" value="<?php echo $row['grade_level']; ?>" />
                <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>
                <div class="option-grade">
                  <div onclick="reveal('Grade 11')">Grade 11</div>
                  <div onclick="reveal('Grade 12')">Grade 12</div>
                </div>
              </div>
            </div>

          </div>
          <div class="yrlvl-gradelvl">
            <div class="dropdown-strand">
              <span class="input-info">Strand<span style="color: red; font-size: 1.3em">*</span></span>
              <input type="text" class="textbox-strand" placeholder="Select Strand" name="strand" value="<?php echo $row['strand']; ?>" readonly />
              <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>

              <div class="option-strand">
                <div onclick="show('GAS')">GAS</div>
                <div onclick="show('STEM')">STEM</div>
                <div onclick="show('TVL')">TVL</div>
                <div onclick="show('ICT')">ICT</div>
                <div onclick="show('ABM')">ABM</div>
              </div>
            </div>

            <div class="button-submit">
              <button type="submit" class="btn-submit">Update</button>
            </div>
          </div>
        </form>
      </div>
      <div class="section-table">
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
                <th>Section Name</th>
                <th>Grade Level</th>
                <th>Strand</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody st>
              <?php

              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['section_name'] . "</td>";
                echo "<td>" . $row['grade_level'] . "</td>";
                echo "<td>" . $row['strand'] . "</td>";
                echo "<td><a href='edit_page_sections.php?id=" . $row['id'] . "'><button class='edit'><i class='fa-solid fa-pen'></i></button></a> 
                  <a href='delete_sections.php?id=" . $row['id'] . "'> <button  class='delete' type='submit' name='delete'><i class='fa-solid fa-trash-can'></i></button></a> 
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
  <script src="./section.js"></script>
</body>

</html>