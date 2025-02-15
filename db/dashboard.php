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

$sql_schedule = "SELECT * FROM schedules";
$result_schedule = $conn->query($sql_schedule);

$sql_schedule2 = "SELECT * FROM schedule_again";
$result_schedule2 = $conn->query($sql_schedule2);


$query = "SELECT sa.id, sa.section, sa.strand, sa.grade_level, COUNT(DISTINCT s.subject) AS subject_count, sa.sem, sa.school_year, sa.adviser
  FROM schedule_again sa
  LEFT JOIN schedules s ON s.section = sa.section
  GROUP BY sa.id, sa.section, sa.strand, sa.grade_level,  sa.sem, sa.school_year, sa.adviser;
";
$result_schedule2 = $conn->query($query);
if (!$result_schedule2) {
  die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olivarez College Tagaytay</title>
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="icon" type="x-icon" href="./img/olivarez-college-tagaytay-logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
  <div class="container">
    <nav>
      <div class="logo">
        <img src="./img/olivarez-college-tagaytay-logo.png" alt="oct logo">
      </div>
      <div class="public">
        <a href="./generate.php"><i class="fa-solid fa-circle-plus"></i><span>Create schedule</span></a>
        <a href="./dashboard.php" class="active"> <i class="fa-solid fa-tv"></i><span>Dashboard</span></a>
        <a href="./subject.php"><i class="fa-solid fa-book"></i><span>Subjects</span></a>
        <a href="./section.php"><i class="fa-solid fa-users-rectangle"></i><span>Sections</span></a>
        <a href="./teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a>

      </div>
      <div class="admin">
        <a class="logout"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
      </div>
    </nav>
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
          <div class="table-container">
            <table id="scheduleTable" class="table">
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
          <!-- <button type="submit"><i class="fa-regular fa-trash-can"></i> Delete</button> -->
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
        <div class="header-img">
          <img src="./img/olivarez-college-tagaytay-logo.png" alt="Oct logo">
        </div>
        <div class="btn">
          <button class="noBtn">Cancel</button>
          <a href="logout.php"><button class="yesBtn">Logout</button></a>
        </div>
      </div>
    </div>
    <div class="bg-content-tutorial">
      <div class="content-tutorial">
        <div class="tutorialPage page1">
          <div class="progressBar">
            <div class="progress activePage"></div>
            <div class="progress">
              <div class="progressCreateWrapper">
                <div class="progressCreate"></div>
                <div class="progressCreate"></div>
                <div class="progressCreate"></div>
              </div>
            </div>
            <div class="progress"></div>
          </div>
          <div class="tuts-content">
            <div class="tutorialTitle">
              Factor to make before creating a schedule
            </div>
            <img style="width: 800px;" src="./img/page1img.png" alt="">
            <div class="tutorial-info">
              <p>Before Creating a schedule you must first create <span>Section</span>, <span>Subject</span> and the <span>Instructors</span>. keep in mind that you must first create a subject before a teacher.</p>
            </div>
          </div>
          <div class="btn-tutorial">
            <button class="nxtTutsPage">Next</button>
          </div>
        </div>
        <div class="tutorialPage page2">
          <div class="progressBar">
            <div class="progress"></div>
            <div class="progress activePage">
              <div class="progressCreateWrapper">
                <div class="progressCreate"></div>
                <div class="progressCreate"></div>
                <div class="progressCreate"></div>
              </div>
            </div>
            <div class="progress"></div>
          </div>
          <div class="tuts-content">
            <div class="tutorialTitle">
              Create schedule tab
            </div>
            <img style="width: 600px; top: 110px; position: absolute;" src="./img/page2img.jpg" alt="">
            <div class="tutorial-info">
              <p style="font-size: 12px;">In the creating schedule page this image will show first. as you can see we have numerous buttons with various functions. To <span>print</span> first select the checkboxes you want to print or you can select all to print all. You can also convert it into <span>EXCEL</span> and <span>PDF</span>. To <span>Delete</span> check the checkboxes you want to delete then press the button delete. and lastly the <span>Edit</span> function, double click the cell you want to edit then a text box will show, then after you can press the button <span>apply</span> to save the changes</p>
            </div>
          </div>
          <div class="btn-tutorial">
            <button class="bckTutsPage">Back</button>
            <button class="nxtTutsPage2">Next</button>
          </div>
        </div>
        <div class="tutorialPage page3">
          <div class="progressBar">
            <div class="progress"></div>
            <div class="progress">
              <div class="progressCreateWrapper">
                <div class="progressCreate activePageCreate"></div>
                <div class="progressCreate"></div>
                <div class="progressCreate"></div>
              </div>
            </div>
            <div class="progress"></div>
          </div>
          <div class="tuts-content">
            <div class="tutorialTitle">
              Create schedule tab 1.2
            </div>
            <img style="width: 700px; top: 110px; position: absolute;" src="./img/page3img.png" alt="">
            <div class="tutorial-info">
              <p>Now to create a <span>Schedule</span> click the <span>Add new</span> button then a modal will show just like in the image. Choose a section you want to create a schedule to by clicking <span>next</span>, then it wil take you to a next step which is applying a <span>Subject</span> for that section.</p>
            </div>
          </div>
          <div class="btn-tutorial">
            <button class="bckTutsPage2">Back</button>
            <button class="nxtTutsPage3">Next</button>
          </div>
        </div>
        <div class="tutorialPage page4">
          <div class="progressBar">
            <div class="progress"></div>
            <div class="progress">
              <div class="progressCreateWrapper">
                <div class="progressCreate"></div>
                <div class="progressCreate activePageCreate"></div>
                <div class="progressCreate"></div>
              </div>
            </div>
            <div class="progress"></div>
          </div>
          <div class="tuts-content">
            <div class="tutorialTitle">
              Create schedule tab 1.3
            </div>
            <img style="width: 630px; top: 90px; position: absolute;" src="./img/page4img.png" alt="">
            <div class="tutorial-info">
              <p style="font-size: 12px;">Now when clicking the <span>apply</span> button on a particular subject a new modal will open. First select an <span>instructor</span> which automatically check the day that instructor are only available, <i style="font-size: 12px;">keep in mind that you can change that day by checking the checkbox but will not change on the teacher table.</i> After that click the <span>next</span> button. Which takes you to the next step which is <span>applying time</span> for that subject after that you can check the <span>checkbox</span> to save time and copy it to all the days.</p>
            </div>
          </div>
          <div class="btn-tutorial">
            <button class="bckTutsPage3">Back</button>
            <button class="nxtTutsPage4">Next</button>
          </div>
        </div>
        <div class="tutorialPage page5">
          <div class="progressBar">
            <div class="progress"></div>
            <div class="progress">
              <div class="progressCreateWrapper">
                <div class="progressCreate"></div>
                <div class="progressCreate"></div>
                <div class="progressCreate activePageCreate"></div>
              </div>
            </div>
            <div class="progress"></div>
          </div>
          <div class="tuts-content">
            <div class="tutorialTitle">
              Create schedule tab 1.4
            </div>
            <img style="width: 700px; top: 110px; position: absolute;" src="./img/page5img.jpg" alt="">
            <div class="tutorial-info">
              <p>After a success of creating schedule. The row of that <span>subject</span> will be <span>green</span> to help you keep track on your progress.</p>
            </div>
          </div>
          <div class="btn-tutorial">
            <button class="bckTutsPage4">Back</button>
            <button class="nxtTutsPage5">Next</button>
          </div>
        </div>
        <div class="tutorialPage page6">
          <div class="progressBar">
            <div class="progress"></div>
            <div class="progress">
              <div class="progressCreateWrapper">
                <div class="progressCreate"></div>
                <div class="progressCreate"></div>
                <div class="progressCreate"></div>
              </div>
            </div>
            <div class="progress activePage"></div>

          </div>
          <div class="tuts-content">
            <div class="tutorialTitle">
              Finalize the scheduling
            </div>
            <img style="width: 650px; top: 110px; position: absolute;" src="./img/page6img.jpg" alt="">
            <div class="tutorial-info">
              <p>For the last step choose a <span>School year</span>, <span>Semester</span>, and <span>Adviser</span> for that section. You can go to the dashboard and click the schedules for that section to filter out the other sections schedules </p>
            </div>
          </div>
          <div class="btn-tutorial">
            <button class="bckTutsPage5">Back</button>
            <button class="closeTutsPage">Close</button>
          </div>
        </div>
      </div>
    </div>
    <section class="main-content">
      <div class="header-logo">
        <div class="text-logo">
          <div class="main-logo">
            <h1>Start your <input type="text" id="myDay" readonly /></h1>
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
        <div class="create-schedule">
          <button>
            <a href="./generate.php"><i class="fa-solid fa-plus"></i> Create new</a>
          </button>
        </div>
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
                <button onclick="deleteSelectedRows()"><i class=" fa-solid fa-trash-can"></i> Delete</button>
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
                    echo '<td class="checkboxTbl"><input type="checkbox" name="selected[]" value="' . $row['id'] . '" /></td>';
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
              <span>Admin</span>
              <div class="user-btn"> <button class="openTutorial">Tutorial</button></div>
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
                    $today = date('l');
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
  </div>
  <script src="./libraries/table2excel.js"></script>
  <script src="./libraries/html2pdf.bundle.min.js"></script>
  <script src="./dashboard.js"></script>
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