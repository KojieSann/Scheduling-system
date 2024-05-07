<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login_page.php");
  exit;
}

include('connect.php');

$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);

function searchTeachers($conn, $searchTerm)
{
  $sql = "SELECT * FROM teachers WHERE last_name LIKE '%$searchTerm%' OR day LIKE '%$searchTerm%' OR time LIKE '%$searchTerm%' OR strand LIKE '%$searchTerm%' OR subject LIKE '%$searchTerm%'";
  $result = $conn->query($sql);
  return $result;
}
if (isset($_GET['search'])) {
  $searchTerm = $_GET['search'];
  $result = searchTeachers($conn, $searchTerm);
} else {
  $sql = "SELECT * FROM teachers";
  $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olivarez College Tagaytay</title>
  <link rel="stylesheet" type="text/css" href="teacher.css?<?php echo time(); ?>" />
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
          <a href="./userGenerate.php" class="generate"><i class="fa-solid fa-circle-plus"></i><span class="nav-lists">Generate Schedule</span></a>
        </li>
        <li class="list-items">
          <a href="./userDashboard.php" target="_self"><i class="fa-solid fa-tv"></i><span class="nav-lists">Dashboard</span></a>
        </li>
        <li class="list-items">
          <a href="./userTeacher.php" class="active" target="_top"><i class="fa-solid fa-chalkboard-user"></i><span class="nav-lists">Teachers</span></a>
        </li>
        <li class="list-items">
          <a href="./userSection.php"><i class="fa-solid fa-users-rectangle"></i><span class="nav-lists">Sections</span></a>
        </li>
        <li class="list-items">
          <a href="./userSubject.php" target="_parent"><i class="fa-solid fa-book"></i><span class="nav-lists">Subjects</span></a>
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
        <h1>Add <span>Instructor</span></h1><i class="fa-solid fa-user"></i>
      </div>
      <div class="inputs">
        <form action="add_teachers.php" method="post" onsubmit="return validateForm()">
          <div class="names">
            <div class="teacher-name">
              <span>First name<span style="color: red; font-size: 1.3em">*</span></span>
              <input required type="text" class="first-name input" autocomplete="off" name="first_name" />
            </div>
            <div class="teacher-name">
              <span>Middle name</span>
              <input type="text" class="middle-name input" autocomplete="off" name="middle_name" />
            </div>
            <div class="teacher-name">
              <span>Last name<span style="color: red; font-size: 1.3em">*</span></span>
              <input required type="text" class="last-name input" autocomplete="off" name="last_name" />
            </div>
          </div>
          <div class="day-time">
            <div class="dropdown-time">
              <span class="input-info">Select time<span style="color: red; font-size: 1.3em">*</span></span>
              <input required type="text" class="textbox-time input" placeholder="No time selected" readonly name="time" />
              <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>

              <div class="option-time">
                <div onclick="show('AM')">
                  <i class="fa-regular fa-sun"></i> AM
                </div>
                <div onclick="show('PM')">
                  <i class="fa-regular fa-moon"></i> PM
                </div>
                <div onclick="show('AM-PM')">
                  <i class="fa-solid fa-cloud-sun"></i> AM-PM
                </div>
              </div>
            </div>
            <div class="dropdown-day">
              <span class="input-info">Select day<span style="color: red; font-size: 1.3em;">*</span></span>
              <select name="day[]" multiple multiselect-select-all="true" style="width:200px;">
                <option value="Monday">MONDAY</option>
                <option value="Tuesday">TUESDAY</option>
                <option value="Wednesday">WEDNESDAY</option>
                <option value="Thursday">THURSDAY</option>
                <option value="Friday">FRIDAY</option>
              </select>

            </div>
            <div class="button-submit"><button href="add_teachers.php" class="btn-submit">Submit</button></div>
          </div>
          <div class="subject-strand">
            <div class="strand-list">
              <span class="input-info">Select strand<span style="color: red; font-size: 1.3em">*</span></span>
              <input type="text" name="strand" class="textbox-strands input" placeholder="No strand selected" readonly required />

              <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>

              <div class="options-strand">
                <div onclick="reveal('GAS')">GAS
                </div>
                <div onclick="reveal('STEM')">STEM
                </div>
                <div onclick="reveal('TVL')">TVL
                </div>
                <div onclick="reveal('ICT')">ICT
                </div>
                <div onclick="reveal('ABM')">ABM
                </div>
              </div>
            </div>
            <div class="subject-list">
              <span class="input-info">Select subject<span style="color: red; font-size: 1.3em">*</span></span>
              <select class="subject-select" name="subject[]" multiple multiselect-select-all="true" multiselect-search="true">
                <?php

                $sql_subjects = "SELECT * FROM subjects";
                $result_subjects = $conn->query($sql_subjects);


                if ($result_subjects->num_rows > 0) {
                  while ($row_subject = $result_subjects->fetch_assoc()) {

                    $selected = '';
                    $subjects = explode(", ", $row['subject']);
                    if (in_array($row_subject['subject_name'], $subjects)) {
                      $selected = 'selected';
                    }
                    echo "<option value='" . $row_subject['subject_name'] . "' $selected>" . $row_subject['subject_name'] . "</option>";
                  }
                }
                ?>
              </select>
            </div>

          </div>
      </div>
  </div>
  </form>
  </div>

  <div class="teacher-table">
    <div class="table-header">
      <span>List of instructors</span>
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
            <th>Last Name</th>
            <th>Day</th>
            <th>Time</th>
            <th>Strand</th>
            <th>Subjects</th>

          </tr>
        </thead>
        <tbody st>
          <?php

          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['last_name'] . "</td>";
            echo "<td>" . $row['day'] . "</td>";
            echo "<td>" . $row['time'] . "</td>";
            echo "<td>" . $row['strand'] . "</td>";
            echo "<td>" . $row['subject'] . "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  </section>
  </div>
  <script src="./teacher.js"></script>
</body>

</html>