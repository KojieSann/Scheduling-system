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

  $sql_schedule = "SELECT * FROM schedules";
  $result_schedule = $conn->query($sql_schedule);

  $query = "SELECT 
        sec.id,
        sec.section_name,
        sec.grade_level,
        sec.strand,
        COUNT(sch.id) AS schedule_count
    FROM 
        sections sec
    LEFT JOIN 
        schedules sch 
    ON 
        sec.section_name = sch.section
    GROUP BY 
        sec.id, sec.section_name, sec.grade_level, sec.strand;
";
  $result = $conn->query($query);

  ?>


 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Olivarez College Tagaytay</title>
   <link rel="stylesheet" href="generate.css" />
   <link rel="icon" type="x-icon" href="./img/olivarez-college-tagaytay-logo.png" />
   <script type="text/javascript" src="libraries/jquery.tabledit.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 </head>

 <body>
   <div class="container">
     <nav>
       <div class="logo">
         <img src="./img/olivarez-college-tagaytay-logo.png" alt="oct logo">
       </div>
       <div class="public">
         <a href="./generate.php" class="active"><i class="fa-solid fa-circle-plus"></i><span>Create schedule</span></a>
         <a href="./dashboard.php"> <i class="fa-solid fa-tv"></i><span>Dashboard</span></a>
         <a href="./subject.php"><i class="fa-solid fa-book"></i><span>Subjects</span></a>
         <a href="./section.php"><i class="fa-solid fa-users-rectangle"></i><span>Sections</span></a>
         <a href="./teachers.php"><i class="fa-solid fa-chalkboard-user"></i> <span>Teachers</span></a>

       </div>
       <div class="admin">
         <a class="logout"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></a>
       </div>
     </nav>
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
     <div class="bg-modal-success">
       <div class="success-content">
         <div class="successLogo">
           <div class="textcontainer">
             <span class="particletext confetti"><i class="fa-solid fa-circle-check"></i></span>
             <p>Schedule created <span style="color: #2d6a4f; font-size:20px;">successfully!</span></p>
             <p style="font-size: 11px; font-weight:400;">View the added schedule in the dashboard <br> or make some more!</p>
           </div>

         </div>
         <div class="btn-content">
           <button class="close">Close</button>
          <a href="dashboard.php"><button class="create">Go to Dashboard</button></a> 
         </div>
       </div>
     </div>
     <div class="bg-modal-failed" style="display: none; z-index:10000;">
       <div class="success-content">
         <div class="successLogo">
           <div class="textcontainer">
             <i class="fa-solid fa-circle-xmark failed"></i>
             <p>Schedule creation <span style="color: #ba181b; font-size:20px;">failed! </span></p>
             <p style="font-size: 11px; font-weight:400;">Seems like there is an error while creating a schedule <br>try checking the schedules or completely <br>filling up the required fieds</p>
           </div>

         </div>
         <div class="btn-content">
           <button class="closeFailed close">Close</button>
         </div>
       </div>
     </div>
     <div class="bg-modal-subject">
       <div class="tableSubject-container">
         <div class="table-subject" onclick="expandDiv()">
           <div class="tableSub-container">
             <div class="searchSchedule">
               <input id="search-box-2" type="text" placeholder="Search" oninput="searchSchedule()" />
               <i class="fa-solid fa-magnifying-glass"></i>
             </div>
             <table id="scheduleTableSubj" class="table">
               <thead>
                 <tr>
                   <th>Section</th>
                   <th>Day</th>
                   <th>Subject</th>
                   <th>Time</th>
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
                      echo '<td>' . htmlspecialchars($row['section']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['day']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                      echo '<td>' . htmlspecialchars($row['time']) . '</td>';
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
           <div class="icon">
             <i class="fa-solid fa-table"></i>
           </div>
         </div>
         <div class="close-table" onclick="closeDiv()">
           <i class="fa-solid fa-xmark"></i>
         </div>
       </div>
       <div class="modal-content-subject">
         <div class="close-subject"><i class="fa-solid fa-xmark"></i></div>
         <form action="addSchedule.php" method="POST" id="contact_form" name="contact_form">
           <div class="modal-subject-container">
             <div class="subject-header">
               <div class="subject-info">
                 <span>Subject</span>
                 <input type="text" id="modalSubjectName" name="modalSubjectName" class="headerInput" readonly />
               </div>
               <div class="subject-info">
                 <span>Subject code</span>
                 <input type="text" id="modalSubjectCode" name="modalSubjectCode" class="headerInput" readonly />
               </div>
             </div>
             <div class="form-wrapper">
               <div class="form1 data-info">
                 <div class="form1-wrappper">
                   <div class="input-wrap">
                     <span class="input-header">Choose preferred date</span>
                     <div class="round">
                       <input type="checkbox" id="monday" name="days[]" value="Monday" onchange="toggleButton('monday')" />
                       <label for="monday">Monday</label>
                     </div>
                     <div class="round">
                       <input type="checkbox" id="tuesday" name="days[]" value="Tuesday" onchange="toggleButton('tuesday')" />
                       <label for="tuesday">Tuesday</label>
                     </div>
                     <div class="round">
                       <input type="checkbox" id="wednesday" name="days[]" value="Wednesday" onchange="toggleButton('wednesday')" />
                       <label for="wednesday">Wednesday</label>
                     </div>
                     <div class="round">
                       <input type="checkbox" id="thursday" name="days[]" value="Thursday" onchange="toggleButton('thursday')" />
                       <label for="thursday">Thursday</label>
                     </div>
                     <div class="round">
                       <input type="checkbox" id="friday" name="days[]" value="Friday" onchange="toggleButton('friday')" />
                       <label for="friday">Friday</label>
                     </div>
                   </div>
                   <div class="dropdown-instructor">
                     <span class="input-header-instructor">Select the instructor
                     </span>
                     <select class="subject-select" name="instructorSelect" multiselect-search="true" onchange="updatePreferredDays(this)">
                       <option value="" hidden>Select Instructor</option>
                       <?php while ($row = mysqli_fetch_assoc($result_teachers)) : ?>
                         <option value="<?php echo $row['id']; ?>">
                           <?php echo $row['first_name'] . ' , ' . $row['last_name']; ?>
                         </option>
                       <?php endwhile; ?>
                     </select>
                     <div class="radio-time">
                       <div class="radio-list">
                         <div class="radio-item">
                           <input type="radio" value="AM" name="time" id="AM" />
                           <label for="AM">AM</label>
                         </div>
                         <div class="radio-item">
                           <input type="radio" value="PM" name="time" id="PM" />
                           <label for="PM">PM</label>
                         </div>
                         <div class="radio-item">
                           <input type="radio" value="AM-PM" name="time" id="AM-PM" />
                           <label for="AM-PM">AM-PM</label>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>

                 <div class="btns-wrap">
                   <button type="button" class="subj-btn-next subjBtn">
                     Next
                   </button>
                 </div>
               </div>
               <div class="form2 data-info" style="display: none">
                 <div id="formContainer"></div>
                 <div class="day-selection">
                   <button type="button" class="monday not-selected not-active" disabled>Monday</button>
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
                       <input type="time" name="timeInMonday[]" />
                     </div>
                     <div class="outTime time">
                       <span>Out time</span>
                       <input type="time" name="timeOutMonday[]" />
                     </div>
                     <div class="repeat">
                       <input type="checkbox" name="repeat" />
                       <label for="repeat">Copy to all schedule</label>
                     </div>
                   </div>
                 </div>
                 <div class="time-selection-tuesday" style="display: none;">
                   <div class="time-selection">
                     <p>Tuesday</p>
                     <div class="inTime time">
                       <span>In time</span>
                       <input type="time" name="timeInTuesday[]" />
                     </div>
                     <div class="outTime time">
                       <span>Out time</span>
                       <input type="time" name="timeOutTuesday[]" />
                     </div>
                     <div class="repeat">
                       <input type="checkbox" name="repeat" />
                       <label for="repeat">Copy to all schedule</label>
                     </div>
                   </div>
                 </div>
                 <div class="time-selection-wednesday" style="display: none;">
                   <div class="time-selection">
                     <p>Wednesday</p>
                     <div class="inTime time">
                       <span>In time</span>
                       <input type="time" name="timeInWednesday[]" />
                     </div>
                     <div class="outTime time">
                       <span>Out time</span>
                       <input type="time" name="timeOutWednesday[]" />
                     </div>
                     <div class="repeat">
                       <input type="checkbox" name="repeat" />
                       <label for="repeat">Copy to all schedule</label>
                     </div>
                   </div>
                 </div>
                 <div class="time-selection-thursday" style="display: none;">
                   <div class="time-selection">
                     <p>Thursday</p>
                     <div class="inTime time">
                       <span>In time</span>
                       <input type="time" name="timeInThursday[]" />
                     </div>
                     <div class="outTime time">
                       <span>Out time</span>
                       <input type="time" name="timeOutThursday[]" />
                     </div>
                     <div class="repeat">
                       <input type="checkbox" name="repeat" />
                       <label for="repeat">Copy to all schedule</label>
                     </div>
                   </div>
                 </div>
                 <div class="time-selection-friday" style="display: none;">
                   <div class="time-selection">
                     <p>Friday</p>
                     <div class="inTime time">
                       <span>In time</span>
                       <input type="time" name="timeInFriday[]" />
                     </div>
                     <div class="outTime time">
                       <span>Out time</span>
                       <input type="time" name="timeOutFriday[]" />
                     </div>
                     <div class="repeat">
                       <input type="checkbox" name="repeat" />
                       <label for="repeat">Copy to all schedule</label>
                     </div>
                   </div>
                 </div>
                 <div class="btns-wrap">
                   <button type="button" class="subj-btn-back2 subjBtn">
                     Back
                   </button>
                   <button type="submit" name="subjectSubmit" class="subj-btn-submit subjBtn">
                     <i class="fa-regular fa-floppy-disk"></i> <span> Save</span>
                   </button>
                 </div>

               </div>
             </div>
           </div>
         </form>
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
             <div class="oct-schedule">
               <div class="page slide-page">
                 <div class="titleSection-header">
                   <div class="title">Select section</div>
                   <div class="searchSection">
                     <input type="text" id="searchInput" placeholder="Search...">
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
                        while ($row = $result->fetch_assoc()) {
                          echo "<tr>";
                          echo "<td>" . htmlspecialchars($row['section_name']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['strand']) . "</td>";
                          echo "<td>" . htmlspecialchars($row['grade_level']) . "</td>";
                          echo '<td>' . htmlspecialchars($row['schedule_count']) . '</td>';
                          echo "<td><button type='button' class='firstNext next' data-section='" . htmlspecialchars($row['section_name'], ENT_QUOTES) . "' data-strand='" . htmlspecialchars($row['strand'], ENT_QUOTES) . "' data-grade-level='" . htmlspecialchars($row['grade_level'], ENT_QUOTES) . "'>Next <i class='fa-solid fa-angle-right'></i></button></td>";
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
                   <table class="section-table subject-table">
                     <thead>
                       <tr>
                         <th>Subjects</th>
                         <th>Code</th>
                         <th>Strand</th>
                         <th>Grade lvl</th>
                         <th>Action</th>
                       </tr>
                     </thead>
                     <tbody>
                       <?php
                        while ($row = $result_subjects->fetch_assoc()) {
                          echo "<tr id=\"row-" . $row['subject_code'] . "\">";
                          echo "<td>" . $row['subject_name'] . "</td>";
                          echo "<td>" . $row['subject_code'] . "</td>";
                          echo "<td>" . $row['strand'] . "</td>";
                          echo "<td>" . $row['grade_level'] . "</td>";
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
                 <form id="scheduleForm" method="POST" action="addAnotherSchedule.php">
                   <div class="title">Finalize the schedule</div>
                   <div class="input-container">
                     <div class="input-wrapper">
                       <span>Section</span>
                       <input readonly type="text" class="input" name="inputSection" />
                     </div>
                     <div class="input-wrapper">
                       <span>Strand</span>
                       <input readonly type="text" class="input" name="inputStrand" />
                     </div>
                     <div class="input-wrapper">
                       <span>Grade level</span>
                       <input readonly type="text" class="input" name="inputGradeLevel" />
                     </div>
                   </div>
                   <hr />
                   <div class="additional-inputs">
                     <div class="sy-container">
                       <span class="title">School year</span>
                       <div class="dropdown-sy">

                         <input type="text" class="textbox-sy required" name="school_year" placeholder="Select school year" readonly />
                         <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>
                         <div class="option-sy">
                           <div onclick="bulaga('2024-2025')">2024-2025</div>
                           <div onclick="bulaga('2025-2026')">2025-2026</div>
                           <div onclick="bulaga('2026-2027')">2026-2027</div>
                           <div onclick="bulaga('2027-2028')">2027-2028</div>
                           <div onclick="bulaga('2028-2029')">2028-2029</div>
                           <div onclick="bulaga('2030-2031')">2030-2031</div>
                           <div onclick="bulaga('2031-2032')">2031-2032</div>
                           <div onclick="bulaga('2033-2034')">2033-2034</div>

                         </div>
                       </div>
                     </div>
                     <div class="sem-container">
                       <span class="title">Semester</span>
                       <div class="dropdown-sem">
                         <input type="text" class="textbox-sem required" name="sem" placeholder="Select semester" readonly />
                         <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>
                         <div class="option">
                           <div onclick="show('1st')">1st</div>
                           <div onclick="show('2nd')">2nd</div>
                         </div>
                       </div>
                     </div>
                     <div class="adviser-container">
                       <span class="title">Semester</span>
                       <div class="dropdown-adviser">
                         <input type="text" class="textbox-adviser required" name="adviser" placeholder="Select adviser" readonly />
                         <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>
                         <div class="option">
                           <?php
                            include('connect.php');
                            $sql = "SELECT first_name, last_name FROM teachers";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {

                              while ($row = $result->fetch_assoc()) {

                                echo '<div onclick="adviser(\'' . $row["first_name"] . ' ' . $row["last_name"] . '\')">' . $row["first_name"] . ' ' . $row["last_name"] . '</div>';
                              }
                            } else {
                              echo "0 results";
                            }
                            ?>
                         </div>
                       </div>
                     </div>
                   </div>
                   <div class="field btns">
                     <button type="button" class="prev-2 prev">Previous</button>
                     <button type="submit" class="submit"><i class="fa-regular fa-floppy-disk"></i> Submit</button>
                   </div>
                 </form>
               </div>
             </div>
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
             <button onclick="deleteSelectedRows()">
               <i class=" fa-solid fa-trash-can"></i> Delete
             </button>
             <button class="apply"><i class="fa-regular fa-floppy-disk"></i> Apply</button>
           </div>
           <div class="table-search">
             <form class="search-container">
               <input id="search-box" type="text" class="search-box" />
               <label for="search-box"><i class="fa-solid fa-magnifying-glass search-icon"></i></label>
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
                    echo '<tr class="clickable-row" data-schedule-id="' . $row['id'] . '">';
                    echo '<td class="checkboxTbl"><input type="checkbox" name="selected[]" value="' . $row['id'] . '" /></td>';
                    echo '<td class="editable">' . htmlspecialchars($row['section']) . '</td>';
                    echo '<td class="editable">' . htmlspecialchars($row['strand']) . '</td>';
                    echo '<td class="editable">' . htmlspecialchars($row['day']) . '</td>';
                    echo '<td class="editable">' . htmlspecialchars($row['subject']) . '</td>';
                    echo '<td class="editable">' . htmlspecialchars($row['time']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['duration']) . '</td>';
                    echo '<td class="editable">' . htmlspecialchars($row['instructor']) . '</td>';
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

     </div>
   </div>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="./libraries/html2pdf.bundle.min.js"></script>
   <script src="./libraries/table2excel.js"></script>
   <script src="./generate.js"></script>


   <script>
     const applyButton = document.querySelector('.apply');
     const scheduleTable = document.querySelector('#scheduleTable');

     applyButton.addEventListener('click', () => {
       const tableData = [];
       const rows = scheduleTable.rows;

       for (let i = 1; i < rows.length; i++) {
         const row = rows[i];
         const scheduleId = row.dataset.scheduleId;
         const cells = row.cells;

         const scheduleData = {
           id: scheduleId,
           section: cells[1].textContent,
           strand: cells[2].textContent,
           day: cells[3].textContent,
           subject: cells[4].textContent,
           time: cells[5].textContent,
           duration: cells[6].textContent,
           instructor: cells[7].textContent,
         };

         tableData.push(scheduleData);
       }

       const xhr = new XMLHttpRequest();
       xhr.open('POST', 'update_schedules.php', true);
       xhr.setRequestHeader('Content-Type', 'application/json');

       xhr.onload = function() {
         if (xhr.status === 200) {
           console.log('Schedules updated successfully!');
         } else {
           console.error('Error updating schedules:', xhr.statusText);
         }
       };

       xhr.send(JSON.stringify(tableData));
     });
   </script>


 </body>


 </html>