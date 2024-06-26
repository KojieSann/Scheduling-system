<?php
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login_page.php");
  exit;
}

include('connect.php');

$sql = "SELECT * FROM subjects";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Olivarez College Tagaytay</title>
  <link rel="stylesheet" href="subject.css" />
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
        <a href="./dashboard.php"> <i class="fa-solid fa-tv"></i><span>Dashboard</span></a>
        <a href="./subject.php" class="active"><i class="fa-solid fa-book"></i><span>Subjects</span></a>
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
    <section class="main-content">
      <div class="main-logo">
        <h1>Add <span>Subject</span></h1>
        <i class="fa-solid fa-user"></i>
      </div>
      <div class="inputs">
        <form name="subjectForm" action="add_subject.php" method="post" onsubmit="return validateForm()">

          <div class="subject-code">
            <div class="subj-code">
              <span>Subject<span style="color: red; font-size: 1.3em">*</span></span>
              <input type="text" class="first-name input" autocomplete="off" name="subject_name" />
            </div>
            <div class="subj-code">
              <span>Subject Code<span style="color: red; font-size: 1.3em">*</span></span>
              <input type="text" class="first-name input" autocomplete="off" name="subject_code" />
            </div>
          </div>
          <div class="yrlvl-gradelvl">
            <div class="strand-dropdown">
              <span class="input-info">
                Strand<span style="color: red; font-size: 1.3em">*</span>
              </span>
              <select name="strand[]" multiple multiselect-select-all="true" class="strand-select">             
                <option value="STEM">STEM</option>
                <option value="TVL-ICT">TVL-ICT</option>
                <option value="TVL-HE">TVL-HE</option>
                <option value="ABM">ABM</option>
                <option value="HUMSS">HUMSS</option>
                
              </select>
            </div>
            <div class="dropdown-gradelvl">
              <span class="input-info">Grade Level<span style="color: red; font-size: 1.3em">*</span></span>
              <input type="text" class="textbox-grade input" placeholder="No grade level selected" readonly name="grade_level" />
              <span class="icon-down"><i class="fa-solid fa-chevron-down"></i></span>
              <div class="option-grade">
                <div onclick="show('Grade 11')">Grade 11</div>
                <div onclick="show('Grade 12')">Grade 12</div>
              </div>
            </div>
          </div>
          <div class="button-submit">
            <button href="" class="btn-submit">Submit</button>
          </div>
        </form>
      </div>

      <div class="subject-table">
        <div class="table-header">
          <span>List of subjects</span>
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
                <th>Subject</th>
                <th>Subject Code</th>
                <th>Grade Level</th>
                <th>Strand</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php

              $query = "SELECT * FROM subjects ORDER BY id DESC";

              $result = $conn->query($query);

              if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['subject_name'] . "</td>";
                  echo "<td>" . $row['subject_code'] . "</td>";
                  echo "<td>" . $row['grade_level'] . "</td>";
                  echo "<td>" . $row['strand'] . "</td>";
                  echo "<td> 
                    <a href='edit_page_subjects.php?id=" . $row['id'] . "'><button class='edit'><i class='fa-solid fa-pen'></i></button></a> 
                    <a href='delete_subjects.php?id=" . $row['id'] . "'><button class='delete' type='submit' name='delete'><i class='fa-solid fa-trash-can'></i></button></a> 
                    </td>";
                  echo "</tr>";
                }
              } else {
                echo "<tr><td colspan='5'>No subject available</td></tr>";
              }
              $conn->close();
              ?>
            </tbody>

          </table>
        </div>
      </div>
    </section>
  </div>
  <script src="./subject.js"></script>
</body>

</html>