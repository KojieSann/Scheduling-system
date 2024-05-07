<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login_page.php");
  exit;
}

include('connect.php');

$sql_sections = "SELECT * FROM sections";
$result_sections = $conn->query($sql_sections);

$sql_subjects = "SELECT * FROM subjects";
$result_subjects = $conn->query($sql_subjects);

$sql_teachers = "SELECT * FROM teachers";
$result_teachers = $conn->query($sql_teachers);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olivarez College Tagaytay</title>
  <link rel="stylesheet" href="generate.css" />
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
          <a href="./userGenerate.php" class="active"><i class="fa-solid fa-circle-plus"></i><span class="nav-lists">Generate Schedule</span></a>
        </li>
        <li class="list-items">
          <a href="./userDashboard.php"><i class="fa-solid fa-tv"></i><span class="nav-lists">Dashboard</span></a>
        </li>
        <li class="list-items">
          <a href="./userTeacher.php"><i class="fa-solid fa-chalkboard-user"></i><span class="nav-lists">Teachers</span></a>
        </li>
        <li class="list-items">
          <a href="./userSection.php"><i class="fa-solid fa-users-rectangle"></i><span class="nav-lists">Sections</span></a>
        </li>
        <li class="list-items">
          <a href="./userSubject.php"><i class="fa-solid fa-book"></i><span class="nav-lists">Subjects</span></a>
        </li>
        <li>
          <a class="logout"><i class="fa-solid fa-right-from-bracket"></i><span class="nav-lists">Logout</span></a>
        </li>
      </ul>
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
              <input type="text" readonly>
            </div>
            <div class="inputs">
              <span>Strand</span>
              <input type="text" readonly>
            </div>
            <div class="inputs">
              <span>Adviser</span>
              <input type="text" readonly>
            </div>
          </div>
        </div>
        <div class="view-table">
          <div class="table-header">
            <span>Schedule</span>
            <div class="table-search">
              <form>
                <div class="searchSection">
                  <input type="text" />
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
              </form>
            </div>
          </div>
          <div class="table-container">
            <table class="table">
              <thead>
                <tr>
                  <th>Schedule</th>
                  <th>Subject</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                  <th>Instructor</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Monday</td>
                  <td>English</td>
                  <td>08:00 am</td>
                  <td>09:00 am</td>
                  <td>papa andrei</td>
                </tr>
                <tr>
                  <td>Monday</td>
                  <td>Math</td>
                  <td>09:00 am</td>
                  <td>10:00 am</td>
                  <td>papa andrei</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="button-container">
          <button class="print" onclick="window.print()"><i class="fa-solid fa-print"></i> Print</button>
          <button class="edit"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
          <button class="delete"><i class="fa-regular fa-trash-can"></i> Delete</button>
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
          <img src="./img/undraw_login_re_4vu2.svg" alt="" />
        </div>
        <div class="btn">
          <button class="noBtn">Cancel</button>
          <a href="./login.php"><button class="yesBtn">Logout</button></a>
        </div>
      </div>
    </div>
    <div class="main-content">
      <div class="main-logo">
        <h1>Lists of <span>Schedule</span></h1>
        <i class="fa-solid fa-user"></i>
      </div>
      <div class="schedules-table">
        <div class="table-header">
          <span>Schedules</span>
          <div class="table-nav" style="display: none">
            <button onclick="tableToPrint()">
              <i class="fa-regular fa-file-pdf"></i> Print
            </button>
            <button onclick="tableToExcel()">
              <i class="fa-regular fa-file-excel"></i> Excel
            </button>
            <button><i class="fa-solid fa-trash-can"></i> Delete</button>
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
                <th>Schedule</th>
                <th>Sem</th>
                <th>SY</th>
                <th>Time</th>
                <th>Adviser</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="checkboxTbl"><input type="checkbox" class="select" onclick="toggleTableNav()" /></td>
                <td>Sampaguita</td>
                <td>HUMSS</td>
                <td>Mon,Tues,Fri</td>
                <td>2nd</td>
                <td>2024-2025</td>
                <td>AM</td>
                <td>Papa Andrei</td>
                <td class="checkboxTbl">
                  <div class="view-open-modal">
                    <i class="fa-regular fa-eye"></i>
                    <span>View</span>
                  </div>
                </td>

              </tr>
              <tr>
                <td class="checkboxTbl"><input type="checkbox" class="select" onclick="toggleTableNav()" /></td>
                <td>Santol</td>
                <td>GAS</td>
                <td>Mon,Tues,Fri</td>
                <td>2nd</td>
                <td>2024-2025</td>
                <td>AM</td>
                <td>Papa Andrei</td>
                <td class="checkboxTbl">
                  <div class="view-open-modal">
                    <i class="fa-regular fa-eye"></i>
                    <span>View</span>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="checkboxTbl"><input type="checkbox" class="select" onclick="toggleTableNav()" /></td>
                <td>Santol</td>
                <td>GAS</td>
                <td>Mon,Tues,Fri</td>
                <td>2nd</td>
                <td>2024-2025</td>
                <td>AM</td>
                <td>Papa Andrei</td>
                <td class="checkboxTbl">
                  <div class="view-open-modal">
                    <i class="fa-regular fa-eye"></i>
                    <span>View</span>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="./libraries/html2pdf.bundle.min.js"></script>
  <script src="./libraries/table2excel.js"></script>
  <script src="./generate.js"></script>
</body>

</html>