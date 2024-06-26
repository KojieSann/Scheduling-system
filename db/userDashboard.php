<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login_page.php");
  exit;
}

$username = $_SESSION['username'];
include('connect.php');

$sql = "
    SELECT
        day,
        COUNT(*) AS count
    FROM
        schedules
    GROUP BY
        day;
";
$result = $conn->query($sql);
$weekday_counts = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $weekday_counts[$row["day"]] = $row["count"];
  }
} else {
  $weekday_counts = array(
    "Monday" => 0,
    "Tuesday" => 0,
    "Wednesday" => 0,
    "Thursday" => 0,
    "Friday" => 0
  );
}

$sql_count = "SELECT COUNT(*) AS total FROM sections";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_sections = $row_count['total'];

$sql_schedule = "SELECT * FROM teachers";
$result_teachers = $conn->query($sql_schedule);

$query = "SELECT sa.id, sa.section, sa.strand, sa.grade_level, COUNT(DISTINCT s.subject) AS subject_count, sa.sem, sa.school_year, sa.adviser
  FROM schedule_again sa
  LEFT JOIN schedules s ON s.section = sa.section
  GROUP BY sa.id, sa.section, sa.strand, sa.grade_level,  sa.sem, sa.school_year, sa.adviser;
";
$result_schedule2 = $conn->query($query);
if (!$result_schedule2) {
  die("Query failed: " . $conn->error);
}

$sql_sections = "SELECT * FROM sections";
$result_sections = $conn->query($sql_sections);

$sql_subjects = "SELECT * FROM subjects";
$result_subjects = $conn->query($sql_subjects);

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

    <div class="bg-content-view">
      <div class="content-view">
        <div class="close-view">
          <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="main-inputs">
          <div class="inputs-container">
            <div class="inputs">
              <span>Section</span>
              <input type="text" name="section" readonly>
            </div>
            <div class="inputs">
              <span>Strand</span>
              <input type="text" name="strand" readonly>
            </div>
            <div class="inputs">
              <span>Adviser</span>
              <input type="text" name="adviser" readonly>
            </div>
          </div>
        </div>
        <div class="schedules-table">
          <div class="table-header">
            <div class="searchSchedule">
              <form class="search-container">
                <input type="text" id="searchInput" oninput="searchFunction()" />
                <i class="fa-solid fa-magnifying-glass"></i>
              </form>
            </div>
          </div>
          <div class="table-containerView">
            <table id="scheduleTableView" class="table">
              <thead>
                <tr>
                  <th>Section</th>
                  <th>Strand</th>
                  <th>
                    <div class="sort" onclick="sortTable()">
                      Day <i class="fa-solid fa-chevron-down"></i>
                    </div>
                  </th>
                  <th>Subject</th>
                  <th>Time</th>
                  <th>Instructor</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = $result_schedule->fetch_assoc()) {
                  echo '<tr data-section="' . htmlspecialchars($row['section']) . '">';
                  echo '<td>' . htmlspecialchars($row['section']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['strand']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['day']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['instructor']) . '</td>';
                  echo '</tr>';
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="button-container">
          <button class="print" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
        </div>
      </div>
    </div>
    <div class="bg-content-logout">
      <div class="content-logout">
        <img src="./img/shs-logo.png" alt="shs logo" class="shs-logo" />
        <div class="header-text">
          <span>Confirm Logout</span>
          <p style="font-size: 13px">Are you sure you want to logout?</p>
        </div>

        <img src="./img/olivarez-college-tagaytay-logo.png" class="oct-logo" alt="Oct logo">

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
                  <a>Schedules created</a>
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
                  <a>Subjects in total</a>
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
                  <a>Sections applied</a>
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
                  <a>Teachers added</a>
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
                      <th>Section</th>
                      <th>Strand</th>
                      <th>Grade level</th>
                      <th># of Subj</th>
                      <th>Sem</th>
                      <th>SY</th>
                      <th>Adviser</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    while ($row = $result_schedule2->fetch_assoc()) {
                      echo '<tr data-section="' . htmlspecialchars($row['section']) . '">';
                      echo '<td>' . htmlspecialchars($row['section']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['strand']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['grade_level']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['subject_count']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['sem']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['school_year']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['adviser']) . '</td>';
                      echo '<td><button class="view-open-modal" data-section="' . htmlspecialchars($row['section']) . '" data-strand="' . htmlspecialchars($row['strand']) . '" data-adviser="' . htmlspecialchars($row['adviser']) . '">Schedules</button></td>';
                      echo '</tr>';
                    }
                    ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
          <div class="pieUser-container">
            <div class="pie-container">
              <div class="pie-header">
                <div class="pie-icon">
                  <i class="fa-regular fa-sun"></i>
                </div>
                <div class="pie-text">
                  <span>Days</span>
                  <p>Create your schedules!</p>
                </div>
              </div>
              <div id="pie-chart"></div>
            </div>
            <div class="user">
              <div class="user-wrapper">
                <div class="close-user">
                  <i class="fa-solid fa-xmark"></i>
                </div>

                <div class="user-logo">
                  <img src="./img/man.png" alt="">
                </div>
                <span>User</span>

              </div>
              <div class="table-wrapper" style="display: none;">
                <button class="switch-user">User</button>
                <div class="table-container">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Instructor</th>
                        <th>Subject</th>
                        <th>Time</th>
                      </tr>
                    </thead>
                    <tbody style="font-size:13px;">
                      <?php
                      $today = date('l'); // Gets the current day of the week, e.g., "Wednesday"
                      $sql_schedule = "SELECT * FROM schedules WHERE day = '$today'";
                      $result_schedule = $conn->query($sql_schedule);
                      while ($row = $result_schedule->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['instructor']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                        echo '</tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

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
              <button onclick="tableToPDF2()">
                <i class="fa-regular fa-file-pdf"></i> PDF
              </button>
            </div>
            <div class="searchSchedule">
              <form class="search-container">
                <input id="search-box-2" type="text" oninput="searchFunction2()" placeholder="Search..." />
                <i class="fa-solid fa-magnifying-glass"></i>
              </form>
            </div>
          </div>
          <div class="table-container">
            <table id="scheduleTable" class="table">
              <thead>
                <tr>
                  <th class="checkboxTbl"><input type="checkbox" id="selectAll" onclick="toggleSelectAll()" /></th>
                  </th>
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
                  <th>Time</th>
                  <th>Duration</th>
                  <th>Instructor</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include('connect.php');
                $query = "SELECT * FROM schedules ORDER BY id DESC";
                $result_schedule = $conn->query($query);
                if ($result_schedule->num_rows > 0) {
                  while ($row = $result_schedule->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td class="checkboxTbl"><input type="checkbox" name="selected[]" value="' . $row['id'] . '" /></td>';
                    echo '<td>' . htmlspecialchars($row['section']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['strand']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['day']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['duration']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['instructor']) . '</td>';
                    echo '</tr>';
                  }
                } else {
                  echo "<tr><td colspan='8'>No schedule available</td></tr>";
                }
                $conn->close();
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
                <input id="teacher-search-box" type="text" oninput="searchTeacher()" placeholder="Search..." />
                <i class="fa-solid fa-magnifying-glass"></i>
              </form>
            </div>
          </div>
          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>Last Name</th>
                  <th>Middle name</th>
                  <th>First name</th>
                  <th>Day</th>
                  <th>Time</th>
                  <th>Strand</th>
                  <th>Subjects</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while ($row = $result_teachers->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['last_name'] . "</td>";
                  echo "<td>" . $row['middle_name'] . "</td>";
                  echo "<td>" . $row['first_name'] . "</td>";
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
                <input id="section-search-box" type="text" oninput="searchSection()" placeholder="Search..." />
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
                while ($row = $result_sections->fetch_assoc()) {
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
                <input id="subject-search-box" type="text" oninput="searchSubject()" placeholder="Search..." />
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
                  <th>Grade Level</th>
                  <th>Strand</th>

                </tr>
              </thead>
              <tbody st>
                <?php
                while ($row = $result_subjects->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['subject_name'] . "</td>";
                  echo "<td>" . $row['subject_code'] . "</td>";
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
  <script src="./userDashboard.js"></script>
  <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
  <script>
    var weekdayCounts = <?php echo json_encode($weekday_counts); ?>;
    var data = [{
      values: Object.values(weekdayCounts),
      labels: Object.keys(weekdayCounts),
      hole: 0.6,
      type: 'pie',
      marker: {
        colors: ['#e76f51', '#f4a261', '#e9c46a', '#2a9d8f', '#264653']
      }
    }];

    var layout = {
      height: 285,
      width: 290,
      images: [{
        source: './img/shs-logo.png',
        xref: 'paper',
        yref: 'paper',
        x: 0.5,
        y: 0.5,
        sizex: 0.5,
        sizey: 0.5,
        xanchor: 'center',
        yanchor: 'middle',
        opacity: 0.9
      }]
    };

    Plotly.newPlot('pie-chart', data, layout);
  </script>
</body>

</html>