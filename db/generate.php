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
          <a href="./generate.php" class="active"><i class="fa-solid fa-circle-plus"></i><span class="nav-lists">Generate Schedule</span></a>
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
          <a href="./subject.php"><i class="fa-solid fa-book"></i><span class="nav-lists">Subjects</span></a>
        </li>
        <li>
          <a class="logout"><i class="fa-solid fa-right-from-bracket"></i><span class="nav-lists">Logout</span></a>
        </li>
      </ul>
    </nav>
    <div class="bg-content-view" style="display: none;">
      <div class="content-view">
        <div class="close-subject"><i class="fa-solid fa-xmark"></i></div>

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
    <div class="bg-modal-subject">
      <div class="modal-content-subject">
        <div class="close-subject"><i class="fa-solid fa-xmark"></i></div>
        <div class="modal-subject-container">
          <div class="subject-header">
            <div class="subject-info">
              <span>Subject</span>
              <input type="text" id="modalSubjectName" class="headerInput" readonly placeholder="" />
            </div>
            <div class="subject-info">
              <span>Subject code</span>
              <input type="text" id="modalSubjectCode" class="headerInput" readonly placeholder="" />
            </div>
          </div>
          <div class="form-wrapper">
            <div class="form1 data-info">
              <form action="">
                <div class="input-wrap">
                  <span class="input-header">Choose preferred date</span>
                  <div class="round">
                    <input type="checkbox" id="monday" onchange="toggleButton('monday')" />
                    <label for="monday">Monday</label>
                  </div>
                  <div class="round">
                    <input type="checkbox" id="tuesday" onchange="toggleButton('tuesday')" />
                    <label for="tuesday">Tuesday</label>
                  </div>
                  <div class="round">
                    <input type="checkbox" id="wednesday" onchange="toggleButton('wednesday')" />
                    <label for="wednesday">Wednesday</label>
                  </div>
                  <div class="round">
                    <input type="checkbox" id="thursday" onchange="toggleButton('thursday')" />
                    <label for="thursday">Thursday</label>
                  </div>
                  <div class="round">
                    <input type="checkbox" id="friday" onchange="toggleButton('friday')" />
                    <label for="friday">Friday</label>
                  </div>
                </div>
                <div class="dropdown-instructor">
                  <span class="input-header-instructor">Select the instructor
                  </span>
                  <select class="subject-select" name="select" multiselect-search="true">
                    <?php
                    if ($result_teachers) {
                      while ($row = $result_teachers->fetch_assoc()) {
                        $full_name = $row['last_name'] . ' , ' . $row['first_name'];
                        echo "<option value='" . $full_name . "'>" . $full_name . "</option>";
                      }
                    }
                    ?>
                  </select>


                  <div class="radio-time">
                    <div class="radio-list">
                      <div class="radio-item">
                        <input type="radio" value="AM" name="time" id="am" />
                        <label for="am">AM</label>
                      </div>
                      <div class="radio-item">
                        <input type="radio" value="PM" name="time" id="pm" />
                        <label for="pm">PM</label>
                      </div>
                      <div class="radio-item">
                        <input type="radio" value="AM-PM" name="time" id="am-pm" />
                        <label for="am-pm">AM-PM</label>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <div class="btns-wrap">
                <button type="button" class="subj-btn-next subjBtn">
                  Next
                </button>
              </div>
            </div>
            <div class="form2 data-info" style="display: none">
              <form action="">
                <div class="day-selection">
                  <button type="button" class="monday not-active not-selected" disabled>Monday</button>
                  <button type="button" class="tuesday not-active not-selected" disabled>Tuesday</button>
                  <button type="button" class="wednesday not-active not-selected" disabled>Wednesday</button>
                  <button type="button" class="not-active thursday not-selected" disabled>Thursday</button>
                  <button type="button" class="friday not-active not-selected" disabled>Friday</button>
                </div>
                <div class="time-selection-monday" style="display: none;">
                  <div class="time-selection">
                    <p>Monday</p>
                    <div class="inTime time">
                      <span>In time</span>
                      <input type="time" />
                    </div>
                    <div class="outTime time">
                      <span>Out time</span>
                      <input type="time" />
                    </div>
                    <div class="repeat">
                      <input type="checkbox" name="repeat" />
                      <label for="repeat">Same as last schedule</label>
                    </div>
                  </div>
                </div>
                <div class="time-selection-monday" style="display: none;">
                  <div class="time-selection">
                    <p>Monday</p>
                    <div class="inTime time">
                      <span>In time</span>
                      <input type="time" />
                    </div>
                    <div class="outTime time">
                      <span>Out time</span>
                      <input type="time" />
                    </div>
                    <div class="repeat">
                      <input type="checkbox" name="repeat" />
                      <label for="repeat">Same as last schedule</label>
                    </div>
                  </div>
                </div>
                <div class="time-selection-tuesday" style="display: none;">
                  <div class="time-selection">
                    <p>Tuesday</p>
                    <div class="inTime time">
                      <span>In time</span>
                      <input type="time" />
                    </div>
                    <div class="outTime time">
                      <span>Out time</span>
                      <input type="time" />
                    </div>
                    <div class="repeat">
                      <input type="checkbox" name="repeat" />
                      <label for="repeat">Same as last schedule</label>
                    </div>
                  </div>
                </div>
                <div class="time-selection-wednesday" style="display: none;">
                  <div class="time-selection">
                    <p>Wednesday</p>
                    <div class="inTime time">
                      <span>In time</span>
                      <input type="time" />
                    </div>
                    <div class="outTime time">
                      <span>Out time</span>
                      <input type="time" />
                    </div>
                    <div class="repeat">
                      <input type="checkbox" name="repeat" />
                      <label for="repeat">Same as last schedule</label>
                    </div>
                  </div>
                </div>
                <div class="time-selection-thursday" style="display: none;">
                  <div class="time-selection">
                    <p>Thursday</p>
                    <div class="inTime time">
                      <span>In time</span>
                      <input type="time" />
                    </div>
                    <div class="outTime time">
                      <span>Out time</span>
                      <input type="time" />
                    </div>
                    <div class="repeat">
                      <input type="checkbox" name="repeat" />
                      <label for="repeat">Same as last schedule</label>
                    </div>
                  </div>
                </div>
                <div class="time-selection-friday" style="display: none;">
                  <div class="time-selection">
                    <p>Friday</p>
                    <div class="inTime time">
                      <span>In time</span>
                      <input type="time" />
                    </div>
                    <div class="outTime time">
                      <span>Out time</span>
                      <input type="time" />
                    </div>
                    <div class="repeat">
                      <input type="checkbox" name="repeat" />
                      <label for="repeat">Same as last schedule</label>
                    </div>
                  </div>
                </div>

              </form>

              <div class="btns-wrap">
                <button type="button" class="subj-btn-back2 subjBtn">
                  Back
                </button>
                <button type="submit" class="subj-btn-submit subjBtn">
                  <i class="fa-regular fa-floppy-disk"></i> <span> Save</span>
                </button>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="bg-modal">
      <div class="modal-content">
        <div class="close-window"><i class="fa-solid fa-xmark"></i></div>
        <div class="modal-container">
          <div class="progress-bar">
            <div class="step">
              <p>Section</p>
              <div class="bullet">
                <span>1</span>
              </div>
              <div class="check fas fa-check"></div>
            </div>
            <div class="step">
              <p>Subjects</p>
              <div class="bullet">
                <span>2</span>
              </div>
              <div class="check fas fa-check"></div>
            </div>
            <div class="step">
              <p>Finalize</p>
              <div class="bullet">
                <span>3</span>
              </div>
              <div class="check fas fa-check"></div>
            </div>
          </div>
          <div class="form-outer">
            <form action="#">
              <div class="page slide-page">
                <div class="titleSection-header">
                  <div class="title">Select section</div>
                  <div class="searchSection">
                    <input type="text" />
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </div>
                </div>


                <div class="table-container-modal">
                  <table class="section-table">
                    <thead>
                      <tr>
                        <th>Section</th>
                        <th>Strand</th>
                        <th>Grade lvl</th>
                        <th>Schedule</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while ($row = $result_sections->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['section_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['strand']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['grade_level']) . "</td>";
                        echo "<td>None</td>";
                        echo "<td><button class='firstNext next' data-section='" . htmlspecialchars($row['section_name'], ENT_QUOTES) . "' data-strand='" . htmlspecialchars($row['strand'], ENT_QUOTES) . "' data-grade-level='" . htmlspecialchars($row['grade_level'], ENT_QUOTES) . "'>Next <i class='fa-solid fa-angle-right'></i></button></td>";
                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="page">
                <div class="title">Apply Subjects</div>
                <div class="input-container">
                  <div class="input-wrapper">
                    <span>Section</span>
                    <input readonly type="text" id="inputSection" class="input" value="" />
                  </div>
                  <div class="input-wrapper">
                    <span>Strand</span>
                    <input readonly type="text" id="inputStrand" class="input" value="" />
                  </div>
                  <div class="input-wrapper">
                    <span>Grade level</span>
                    <input readonly type="text" id="inputGradeLevel" class="input" value="" />
                  </div>
                </div>
                <div class="table-container-modal">
                  <table class="section-table">
                    <thead>
                      <tr>
                        <th>Subjects</th>
                        <th>Code</th>
                        <th>Strand</th>
                        <th>Grade lvl</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      while ($row = $result_subjects->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['subject_name'] . "</td>";
                        echo "<td>" . $row['subject_code'] . "</td>";
                        echo "<td>" . $row['strand'] . "</td>";
                        echo "<td>" . $row['grade_level'] . "</td>";
                        echo "<td class=\"status\">";
                        echo "<div class=\"subject-progress\">";

                        $statusClass = ($row['status'] == 'done') ? 'done' : 'in-progress';
                        $statusIcon = ($row['status'] == 'done') ? 'fa-circle-check' : 'fa-clock';
                        $statusText = ($row['status'] == 'done') ? 'Done' : 'In Progress';

                        echo "<div class=\"$statusClass subject-status\">";
                        echo "<i class=\"fa-regular $statusIcon\"></i> $statusText";
                        echo "</div>";

                        echo "</div>";
                        echo "</td>";
                        echo "<td>";
                        echo "<button type=\"button\" class=\"open-modal\" data-subject-name=\"" . htmlspecialchars($row['subject_name'], ENT_QUOTES) . "\" data-subject-code=\"" . htmlspecialchars($row['subject_code'], ENT_QUOTES) . "\" data-strand=\"" . htmlspecialchars($row['strand'], ENT_QUOTES) . "\" data-grade-level=\"" . htmlspecialchars($row['grade_level'], ENT_QUOTES) . "\">";
                        echo "Apply";
                        echo "</button>";
                        echo "</td>";
                        echo "</tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>


                <div class="field btns">
                  <button class="prev-1 prev">Previous</button>
                  <button class="next-1 next">Next</button>
                </div>
              </div>
              <div class="page details">
                <div class="title">Finalize the schedule</div>
                <div class="input-container">
                  <div class="input-wrapper">
                    <span>Section</span>
                    <input readonly type="text" class="input" placeholder="Sampaguita
                        " />
                  </div>
                  <div class="input-wrapper">
                    <span>Strand</span>
                    <input readonly type="text" class="input" placeholder="HUMSS
                        " />
                  </div>
                  <div class="input-wrapper">
                    <span>Grade level</span>
                    <input readonly type="text" class="input" placeholder="Grade 11
                        " />
                  </div>
                </div>
                <hr />
                <div class="additional-inputs">
                  <div class="sy-container">
                    <span class="title">School year</span>
                    <div class="sy">
                      <input type="text" maxlength="4" name="sy" /><span>-</span><input type="text" maxlength="4" name="sy2" />
                    </div>
                  </div>
                  <div class="sem-container">
                    <span class="title">Semester</span>
                    <div class="dropdown-sem">
                      <input type="text" class="textbox-sy" placeholder="Select semester" readonly />
                      <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>

                      <div class="option">
                        <div onclick="show('1st')">1st</div>
                        <div onclick="show('2nd')">2nd</div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field btns">
                  <button class="prev-2 prev">Previous</button>
                  <button class="submit">Submit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="main-content">
      <div class="main-logo">
        <h1>Generate a <span>Schedule</span></h1>
        <i class="fa-solid fa-user"></i>
      </div>
      <div class="button-container">
        <button class="modal-button">
          Add new <i class="fa-solid fa-plus"></i>
        </button>
      </div>
      <div class="schedules-table">
        <div class="table-header">
          <span>Schedules</span>
          <div class="table-nav" style="display: none">
            <button onclick="window.print()">
              <i class="fa-solid fa-print"></i> Print
            </button>
            <button onclick="tableToPDF()">
              <i class="fa-regular fa-file-pdf"></i> PDF
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
                <th class="checkboxTbl"><input type="checkbox" id="selectAll" /></th>
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
                <td class="checkboxTbl"><input type="checkbox" class="select" /></td>
                <td>Sampaguita</td>
                <td>HUMSS</td>
                <td>Mon,Tues,Fri</td>
                <td>2nd</td>
                <td>2024-2025</td>
                <td>AM</td>
                <td>Papa Andrei</td>
                <td class="checkboxTbl">
                  <div class="dropdown-table">
                    <span class="icon-right"><i class="fa-solid fa-chevron-right"></i></span>
                    <div class="option-table">
                      <div class="option-wrapper">
                        <div class="option-icon">
                          <i class="fa-regular fa-eye"></i>
                        </div>
                        <span>View</span>
                      </div>
                      <div class="option-wrapper">
                        <div class="option-icon">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </div>
                        <span>Edit</span>
                      </div>
                      <div class="option-wrapper">
                        <div class="option-icon">
                          <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <span>Delete</span>
                      </div>
                      <div class="option-wrapper">
                        <div class="option-icon">
                          <i class="fa-solid fa-print"></i>
                        </div>
                        <span>Print</span>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="checkboxTbl"><input type="checkbox" class="select" /></td>
                <td>Santol</td>
                <td>GAS</td>
                <td>Mon,Tues,Fri</td>
                <td>2nd</td>
                <td>2024-2025</td>
                <td>AM</td>
                <td>Papa Andrei</td>
                <td class="checkboxTbl">
                  <div class="dropdown-table">
                    <span class="icon-right"><i class="fa-solid fa-chevron-right"></i></span>
                    <div class="option-table">
                      <div class="option-wrapper">
                        <div class="option-icon">
                          <i class="fa-regular fa-eye"></i>
                        </div>
                        <span>View</span>
                      </div>
                      <div class="option-wrapper">
                        <div class="option-icon">
                          <i class="fa-regular fa-pen-to-square"></i>
                        </div>
                        <span>Edit</span>
                      </div>
                      <div class="option-wrapper">
                        <div class="option-icon">
                          <i class="fa-solid fa-trash-can"></i>
                        </div>
                        <span>Delete</span>
                      </div>
                      <div class="option-wrapper">
                        <div class="option-icon">
                          <i class="fa-solid fa-print"></i>
                        </div>
                        <span>Print</span>
                      </div>
                    </div>
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