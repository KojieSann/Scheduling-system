<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login_page.php");
  exit;
}

$username = $_SESSION['username'];
include('connect.php');

$sql_count = "SELECT COUNT(*) AS total FROM sections";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_sections = $row_count['total'];

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
$sql_schedule2 = "SELECT * FROM schedule_again";
$result_schedule2 = $conn->query($sql_schedule2);
$sql_sections = "SELECT * FROM sections";
$result_sections = $conn->query($sql_sections);

$sql_subjects = "SELECT * FROM subjects";
$result_subjects = $conn->query($sql_subjects);

$sql_teachers = "SELECT * FROM teachers";
$result_teachers = $conn->query($sql_teachers);

$sql_schedule = "SELECT * FROM schedules";
$result_schedule = $conn->query($sql_schedule);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olivarez College Tagaytay</title>
  <link rel="stylesheet" href="userDashboard.css" />
  <link rel="icon" type="x-icon" href="./img/olivarez-college-tagaytay-logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div class="container">
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
    <div class="main-content">
      <section>
        <div class="header-logo">
          <div class="text-logo">
            <div class="logo">
              <img src="./img/olivarez-college-tagaytay-logo.png" alt="" />
            </div>
            <div class="main-logo">
              <div class="main-logo-wrapper" style="align-items: center; display:flex; gap:5px;">
                <h1 style="white-space: nowrap;">Start your</h1>
                <input type="text" id="myDay" readonly />
              </div>
              <p>SHS Scheduling System</p>
            </div>
            <div class="date">
              <input type="text" id="myDate" readonly />
              <div class="year-month">
                <input type="text" id="myYear" readonly style="color: #747474" />
                <input type="text" id="myMonth" readonly />
              </div>
            </div>
          </div>
          <nav>
            <ul>
              <li class="list-items">
                <a href="#schedule" class="generate">
                  Schedules
                </a>
              </li>

              <li class="list-items">
                <a href="#teacher"><span class="nav-lists">Teachers</span></a>
              </li>
              <li class="list-items">
                <a href="#section"><span class="nav-lists">Sections</span></a>
              </li>
              <li class="list-items">
                <a href="#subject"><span class="nav-lists">Subjects</span></a>
              </li>
              <li class="list-items">
                <a class="logout"><i class="fa-solid fa-right-from-bracket"></i></a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="content-container">
          <div class="info-date">
            <div class="infos-container">

              <div class="infos-wrapper">
                <div class="info-title">
                  <a href="generate.php">Schedules created</a>
                  <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
                <div class="info">
                  <span><?php
                        $sql_count = "SELECT COUNT(*) AS total FROM schedules";
                        $result_count = $conn->query($sql_count);
                        $row_count = $result_count->fetch_assoc();
                        $total_sections = $row_count['total'];
                        echo $total_sections;
                        ?></span></span>
                </div>
                <div class="info-img">
                  <img src="./img/undraw_schedule_re_2vro.svg" alt="">
                </div>
              </div>
              <div class="infos-wrapper">
                <div class="info-title">
                  <a href="subject.php">Subjects in total</a>
                  <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
                <div class="info">
                  <span>
                    <?php
                    $sql_count = "SELECT COUNT(*) AS total FROM subjects";
                    $result_count = $conn->query($sql_count);
                    $row_count = $result_count->fetch_assoc();
                    $total_sections = $row_count['total'];
                    echo $total_sections;
                    ?>
                  </span>
                </div>
                <div class="info-img">
                  <img src="./img/undraw_content_structure_re_ebkv.svg" alt="">
                </div>
              </div>
              <div class="infos-wrapper">
                <div class="info-title">
                  <a href="section.php">Sections applied</a>
                  <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
                <div class="info">
                  <span>
                    <?php
                    $sql_count = "SELECT COUNT(*) AS total FROM sections";
                    $result_count = $conn->query($sql_count);
                    $row_count = $result_count->fetch_assoc();
                    $total_sections = $row_count['total'];
                    echo $total_sections;
                    ?>
                  </span>
                </div>
                <div class="info-img">
                  <img src="./img/undraw_community_re_cyrm.svg" alt="">
                </div>
              </div>
              <div class="infos-wrapper">
                <div class="info-title">
                  <a href="teachers.php">Teachers added</a>
                  <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </div>
                <div class="info">
                  <span>
                    <?php
                    $sql_count = "SELECT COUNT(*) AS total FROM teachers";
                    $result_count = $conn->query($sql_count);
                    $row_count = $result_count->fetch_assoc();
                    $total_sections = $row_count['total'];
                    echo $total_sections;
                    ?>
                  </span>
                </div>
                <div class="info-img">
                  <img src="./img/undraw_teacher_re_sico.svg" alt="">
                </div>
              </div>
            </div>
            <div class="schedule-table">
              <div class="table-header">
                <span>Schedules</span>
                <div class="table-nav">
                  <button onclick="tableToPrint()">
                    <i class="fa-solid fa-print"></i> Print
                  </button>
                  <button id="tableToExcel">
                    <i class="fa-regular fa-file-excel"></i> Excel
                  </button>
                  <button onclick="tableToPDF()">
                    <i class="fa-regular fa-file-pdf"></i> PDF
                  </button>
                </div>
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
                      <th class="checkboxTbl"><input type="checkbox" id="selectAll" onclick="toggleSelectAll()" /></th>
                      <th>Section</th>
                      <th>Strand</th>
                      <th># of Subjects</th>
                      <th>Sem</th>
                      <th>SY</th>
                      <th>Adviser</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = $result_schedule2->fetch_assoc()) {
                      echo '<tr>';
                      echo '<td class="checkboxTbl"><input type="checkbox" name="selected[]" value="' . $row['id'] . '" /></td>';
                      echo '<td>' . htmlspecialchars($row['section']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['strand']) . '</td>';
                      echo '<td>  0 </td>';
                      echo '<td>' . htmlspecialchars($row['sem']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['school_year']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['adviser']) . '</td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="section-teacher">
            <div class="section-container">
              <span>Today's Schedule</span>
              <div class="section-wrapper contents"></div>
            </div>
            <div class="teacher-container">
              <span>Instructors Schedule</span>
              <div class="instructors-wrapper contents"></div>
            </div>
          </div>

        </div>
      </section>
      <section id="schedule">
        <div class="schedules-table main-table">
          <div class="table-header">
            <span>Schedules</span>
            <div class="table-nav">
              <button onclick="tableToPrint()">
                <i class="fa-solid fa-print"></i> Print
              </button>
              <button id="tableToExcel">
                <i class="fa-regular fa-file-excel"></i> Excel
              </button>
              <button onclick="tableToPDF()">
                <i class="fa-regular fa-file-pdf"></i> PDF
              </button>
              <button onclick="deleteSelectedRows()"><i class=" fa-solid fa-trash-can"></i> Delete</button>
            </div>
            <div class="searchSchedule">
              <form class="search-container">
                <input type="text" />
                <i class="fa-solid fa-magnifying-glass"></i>
              </form>
            </div>
          </div>
          <div class="table-container">
            <table id="scheduleTable" class="table">
              <thead>
                <tr>
                  <th class="checkboxTbl"><input type="checkbox" id="selectAll" onclick="toggleSelectAll()" /></th>
                  <th>
                    <div class="sort" onclick="groupSections()">
                      Section <i class="fa-solid fa-chevron-down"></i>
                    </div>
                  </th>
                  <th>Strand</th>
                  <th>
                    <div class="sort" onclick="sortTable()">
                      Day <i class="fa-solid fa-chevron-down"></i>
                    </div>
                  </th>
                  <th>Subject</th>
                  <th>Time in</th>
                  <th>Time out</th>
                  <th>Duration</th>
                  <th>Instructor</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = $result_schedule->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td class="checkboxTbl"><input type="checkbox" name="selected[]" value="' . $row['id'] . '" /></td>';
                  echo '<td>' . htmlspecialchars($row['section']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['strand']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['day']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['timeIn']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['timeOut']) . '</td>';
                  echo '<td> none </td>';
                  echo '<td>' . htmlspecialchars($row['instructor']) . '</td>';
                  echo '<td class="checkboxTbl">
                  <div class="view-open-modal">
                  <i class="fa-regular fa-pen-to-square"></i>
                  <span>Edit</span>
                  </div>
                  </td>';
                  echo '</tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
      <section id="teacher">
        <div class="main-table">
          <div class="table-header">
            <span>List of instructors</span>
            <div class="searchSchedule">
              <form class="search-container">
                <input type="text" />
                <i class="fa-solid fa-magnifying-glass"></i>
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
      <section id="section">
        <div class="main-table">
          <div class="table-header">
            <span>List of sections</span>
            <div class="searchSchedule">
              <form class="search-container">
                <input type="text" />
                <i class="fa-solid fa-magnifying-glass"></i>
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
                </tr>
              </thead>
              <tbody st>
                <?php

                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['section_name'] . "</td>";
                  echo "<td>" . $row['grade_level'] . "</td>";
                  echo "<td>" . $row['strand'] . "</td>";

                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>
      <section id="subject">
        <div class="main-table">
          <div class="table-header">
            <span>List of subjects</span>
            <div class="searchSchedule">
              <form class="search-container">
                <input type="text" />
                <i class="fa-solid fa-magnifying-glass"></i>
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
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>


    </div>
  </div>
  <script src="./libraries/table2excel.js"></script>
  <script src="./libraries/html2pdf.bundle.min.js"></script>
  <script src="./dashboard.js"></script>
  <script src="./userDashboard.js"></script>
  <script src="./generate.js"></script>
</body>

</html>