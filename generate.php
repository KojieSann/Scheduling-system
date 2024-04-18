<?php
include ('connect.php');

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
          <a href="./generate.php" class="active"><i class="fa-solid fa-circle-plus"></i><span
              class="nav-lists">Generate Schedule</span></a>
        </li>
        <li class="list-items">
          <a href="./dashboard.php"><i class="fa-solid fa-tv"></i><span class="nav-lists">Dashboard</span></a>
        </li>
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
          <a href="./login_page.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i><span
              class="nav-lists">Logout</span></a>
        </li>
      </ul>
    </nav>
    <div class="bg-modal-subject">
      <div class="modal-content-subject">
        <div class="close-subject"><i class="fa-solid fa-xmark"></i></div>
        <!-- <header class="dragable">
              <i class="fa-solid fa-up-down-left-right"></i>
            </header> -->
        <div class="modal-subject-container">
          <div class="subject-header">
            <div class="subject-info">
              <span>Subject</span>
              <input type="text" class="headerInput" readonly placeholder="English" />
            </div>
            <div class="subject-info">
              <span>Subject code</span>
              <input type="text" class="headerInput" readonly placeholder="">
            </div>
          </div>
          <div class="form-wrapper">
            <div class="form1 data-info">
              <form action="">
                <div class="input-wrap">
                  <span class="input-header">Choose preferred date</span>
                  <div class="round">
                    <input type="checkbox" id="monday" />
                    <label for="monday">Monday</label>
                  </div>
                  <div class="round">
                    <input type="checkbox" id="tuesday" />
                    <label for="tuesday">Tuesday</label>
                  </div>
                  <div class="round">
                    <input type="checkbox" id="wednesday" />
                    <label for="wednesday">Wednesday</label>
                  </div>
                  <div class="round">
                    <input type="checkbox" id="thursday" />
                    <label for="thursday">Thursday</label>
                  </div>
                  <div class="round">
                    <input type="checkbox" id="friday" />
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
                  <button type="button" class="active-day">Monday</button>
                  <button type="button" class="not-active">Tuesday</button>
                  <button type="button" class="not-active">Wednesday</button>
                  <button class="not-selected" disabled>Thursday</button>
                  <button type="button" class="not-active">Friday</button>
                </div>
                <div class="time-selection">
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
              </form>

              <div class="btns-wrap">
                <button type="button" class="subj-btn-back2 subjBtn">
                  Back
                </button>
                <button type="button" class="subj-btn-next2 subjBtn">
                  Next
                </button>
              </div>
            </div>
            <div class="form3 data-info" style="display: none">
              <h1>Page 3</h1>
              <form action="">
                <div class="input-wrap">
                  <label for="">hahah</label>
                  <input type="text" />
                </div>
              </form>
              <div class="btns-wrap">
                <button type="button" class="subj-btn-back3 subjBtn">
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
              <p>Instructors</p>
              <div class="bullet">
                <span>3</span>
              </div>
              <div class="check fas fa-check"></div>
            </div>
            <div class="step">
              <p>Finalize</p>
              <div class="bullet">
                <span>4</span>
              </div>
              <div class="check fas fa-check"></div>
            </div>
            <div class="step">
              <p>Submit</p>
              <div class="bullet">
                <span>5</span>
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
                        echo "<td>" . $row['section_name'] . "</td>";
                        echo "<td>" . $row['strand'] . "</td>";
                        echo "<td>" . $row['grade_level'] . "</td>";
                        echo "<td>None</td>";
                        echo "<td><button class='firstNext next'>Next <i class='fa-solid fa-angle-right'></i></button></td>";
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
                    <input readonly type="text" class="input" value="" />
                  </div>
                  <div class="input-wrapper">
                    <span>Strand</span>
                    <input readonly type="text" class="input" value="" />
                  </div>
                  <div class="input-wrapper">
                    <span>Grade level</span>
                    <input readonly type="text" class="input" value="" />
                  </div>
                </div>
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
                      echo "<div class=\"done subject-status\">";
                      echo "<i class=\"fa-regular fa-circle-check\"></i> Done";
                      echo "</div>";
                      echo "<div class=\"in-progress subject-status\">";
                      echo "<i class=\"fa-regular fa-clock\"></i> In Progress";
                      echo "</div>";
                      echo "</div>";
                      echo "</td>";
                      echo "<td>";
                      echo "<button type=\"button\" class=\"open-modal\">";
                      echo "Apply";
                      echo "</button>";
                      echo "</td>";
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
                <div class="field btns">
                  <button class="prev-1 prev">Previous</button>
                  <button class="next-1 next">Next</button>
                </div>
              </div>
              <div class="page">
                <div class="title">Ano ba maganda ilagay</div>

                <div class="field btns">
                  <button class="prev-2 prev">Previous</button>
                  <button class="next-2 next">Next</button>
                </div>
              </div>
              <div class="page">
                <div class="title">Delete ko nalang ata to</div>

                <div class="field btns">
                  <button class="prev-3 prev">Previous</button>
                  <button class="next-3 next">Next</button>
                </div>
              </div>

              <div class="page">
                <div class="title">Di ko na alam ano ilalagay</div>
                <div class="field btns">
                  <button class="prev-4 prev">Previous</button>
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
      <div class="generate-lists">
        <div class="generate-table">
          <div class="table-header">
            <h1>Schedules</h1>
            <div class="table-nav" style="display: none">
              <button><i class="fa-solid fa-print"></i> Print</button>
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
            <div class="table-wrapper">
              <table class="table">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="selectAll" /></th>
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
                    <td><input type="checkbox" class="select" /></td>
                    <td>Sampaguita</td>
                    <td>HUMSS</td>
                    <td>Mon,Tues,Fri</td>
                    <td>2nd</td>
                    <td>2024-2025</td>
                    <td>AM</td>
                    <td>Papa Andrei</td>
                    <td>
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
                    <td><input type="checkbox" class="select" /></td>
                    <td>Santol</td>
                    <td>GAS</td>
                    <td>Mon,Tues,Fri</td>
                    <td>2nd</td>
                    <td>2024-2025</td>
                    <td>AM</td>
                    <td>Papa Andrei</td>
                    <td>
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
    </div>
  </div>
  <script src="./generate.js"></script>
</body>

</html>