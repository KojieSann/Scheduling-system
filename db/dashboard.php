<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit;
}

$username = $_SESSION['username'];
include ('connect.php');

$sql_count = "SELECT COUNT(*) AS total FROM sections";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_sections = $row_count['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olivarez College Tagaytay</title>
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="icon" type="x-icon" href="./img/olivarez-college-tagaytay-logo.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

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
          <a href="./generate.php" class="generate"><i class="fa-solid fa-circle-plus"></i><span
              class="nav-lists">Generate Schedule</span></a>
        </li>
        <li class="list-items">
          <a href="./dashboard.php" class="active"><i class="fa-solid fa-tv"></i><span
              class="nav-lists">Dashboard</span></a>
        </li class="list-items">
        <li class="list-items">
          <a href="./teachers.php"><i class="fa-solid fa-chalkboard-user"></i><span
              class="nav-lists">Teachers</span></a>
        </li>
        <li class="list-items">
          <a href="./section.php"><i class="fa-solid fa-users-rectangle"></i><span class="nav-lists">Sections</span></a>
        </li>
        <li class="list-items">
          <a href="./subject.php"><i class="fa-solid fa-book"></i><span class="nav-lists">Subjects</span></a>
        </li>
        <li>
          <a class="logout"><i class="fa-solid fa-right-from-bracket"></i><span
              class="nav-lists">Logout</span></a>
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
      <div class="header-logo">
        <div class="text-logo">
            <div class="main-logo">
              <h1>Start your <input type="text" id="myDay" readonly /></h1>
              <p>An OCT Schedule maker</p>
            </div>
            <div class="date">
              <input type="text" id="myDate" readonly />
              <div class="year-month">
                <input
                  type="text"
                  id="myYear"
                  readonly
                  style="color: #747474"
                />
                <input type="text" id="myMonth" readonly />
              </div>
            </div>
          </div>
        <div class="create-schedule">
          <button><i class="fa-solid fa-plus"></i> Create new</button>
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
                <span>0</span>
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
                <div class="table-search">
                  <form class="search-container">
                    <input
                      id="search-box"
                      type="text"
                      class="search-box"
                      name=""
                    />
                    <label for="search-box"
                      ><i class="fa-solid fa-magnifying-glass search-icon"></i
                    ></label>
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
                      <th>Schedule</th>
                      <th>Sem</th>
                      <th>SY</th>
                      <th>Time</th>
                      <th>Adviser</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
                    <tr>
                      <td>Sampaguita</td>
                      <td>HUMSS</td>
                      <td>Mon,Tue,Fri</td>
                      <td>2nd</td>
                      <td>2024-2025</td>
                      <td>AM</td>
                      <td>Papa Andrei</td>
                    </tr>
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
  </div>
  <script src="./dashboard.js"></script>
</body>

</html>