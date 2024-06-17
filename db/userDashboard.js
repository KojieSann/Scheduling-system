
// popout for the logout
const logoutButton = document.querySelector(".logout");
const closePopup = document.querySelector(".noBtn");
logoutButton.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "flex";
});
closePopup.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "none";
});
// date for the header
var myDate = new Date(),
  day = myDate.getDay(),
  date = myDate.getDate(),
  month = myDate.getMonth(),
  year = myDate.getFullYear();
var days = [
  "Sunday",
  "Monday",
  "Tuesday",
  "Wednesday",
  "Thursday",
  "Friday",
  "Saturday",
  "Sunday",
];
var months = [
  "January",
  "February",
  "March",
  "April",
  "May",
  "June",
  "July",
  "August",
  "September",
  "October",
  "November",
  "December",
];
document.getElementById("myMonth").value = months[month];
document.getElementById("myYear").value = year;
document.getElementById("myDate").value = date;
document.getElementById("myDay").value = days[day];
// table to pdf
  // var table2pdf = document.querySelector(".table");
  // var opt = {
  //   margin: 1,
  //   filename: "octScheduleMaker.pdf",
  //   image: { type: "jpeg", quality: 0.98 },
  //   html2canvas: { scale: 2 },
  //   jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
  // };
  // html2pdf(table2pdf, opt);

  function tableToPrint() {
    var checkedRows = document.querySelectorAll('.table-container input:checked');
    if (checkedRows.length === 0) {
        alert("Please select at least one row to print.");
        return;
    }
    checkedRows.forEach(function (row) {
        var tdElements = row.closest('tr').querySelectorAll('td');
        tdElements.forEach(function (td) {
            td.classList.add('hide-on-print');
        });
    });
    var printContent = '<table border="1">';
    printContent += '<thead><tr><th>Section</th><th>Strand</th><th>Day</th><th>Subject</th><th>Time</th><th>Duration</th><th>Instructor</th></tr></thead>';
    printContent += '<tbody>';
    checkedRows.forEach(function (row) {
        var rowData = row.closest('tr').querySelectorAll('td:not(:first-child)');
        printContent += '<tr>';
        rowData.forEach(function (cell) {
            printContent += '<td>' + cell.textContent + '</td>';
        });
        printContent += '</tr>';
    });
    printContent += '</tbody></table>';
    var newWindow = window.open('', '_blank');
    newWindow.document.open();
    newWindow.document.write('<html><head><title>Schedule print page</title><style>.hide-on-print { display: none; } </style></head><body>' + printContent + '</body></html>');
    newWindow.document.close();
    newWindow.print();
    checkedRows.forEach(function (row) {
        var tdElements = row.closest('tr').querySelectorAll('td');
        tdElements.forEach(function (td) {
            td.classList.remove('hide-on-print');
        });
    });
  }
// select all for table
function toggleSelectAll() {
  var checkboxes = document.querySelectorAll(
    '.checkboxTbl input[type="checkbox"]'
  );
  var selectAllCheckbox = document.getElementById("selectAll");
  checkboxes.forEach(function (checkbox) {
    checkbox.checked = selectAllCheckbox.checked;
  });
}

function searchFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search-box");
  filter = input.value.toUpperCase();
  table = document.getElementById("schedule-table");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}

function searchFunction2() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("search-box-2");
  filter = input.value.toUpperCase();
  table = document.getElementById("scheduleTable");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 1; j < td.length; j++) { // Start from 1 to skip checkbox column
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}

function searchTeacher() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("teacher-search-box");
  filter = input.value.toUpperCase();
  table = document.querySelector("#teacher .table-container table");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}

function searchSubject() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("subject-search-box");
  filter = input.value.toUpperCase();
  table = document.querySelector("#subject .table-container table");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}
function searchSection() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("section-search-box");
  filter = input.value.toUpperCase();
  table = document.querySelector("#section .table-container table");
  tr = table.getElementsByTagName("tr");

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    for (var j = 0; j < td.length; j++) {
      if (td[j]) {
        txtValue = td[j].textContent || td[j].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}
// switch user and table
const userSwitch = document.querySelector(".user-wrapper");
const userBtnSwitch = document.querySelector(".close-user");
const tableSwitch = document.querySelector(".table-wrapper");
const tableBtnSwitch = document.querySelector(".switch-user");
userBtnSwitch.addEventListener("click", function () {
 userSwitch.style.display = "none";
 tableSwitch.style.display = "block"

});
tableBtnSwitch.addEventListener("click", function () {
 userSwitch.style.display = "flex";
 tableSwitch.style.display = "none"
});

document.addEventListener('DOMContentLoaded', function() {
  const scheduleButtons = document.querySelectorAll('.view-open-modal');
  const tableRows = document.querySelectorAll('#scheduleTableView tbody tr');
  const searchInput = document.getElementById('search-box');

  let currentSection = null;

  // Event listeners for each schedule button to set the current section
  scheduleButtons.forEach(button => {
    button.addEventListener('click', function() {
      currentSection = this.getAttribute('data-section');
      // Clear search input when a new section is selected
      searchInput.value = '';
      filterTableBySection(currentSection);
    });
  });

  // Event listener for search input changes
  searchInput.addEventListener('input', function() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    filterTableBySection(currentSection, searchTerm);
  });

  // Function to filter table rows based on section and search term
  function filterTableBySection(section, searchTerm = '') {
    tableRows.forEach(row => {
      const sectionMatches = row.getAttribute('data-section') === section;
  
      if (sectionMatches) {
        const searchMatches = row.textContent.toLowerCase().includes(searchTerm);
        row.style.display = searchMatches ? '' : 'none';
      } else {
        row.style.display = 'none';
      }
    });
  }
});

// // modal for viewing
document.querySelectorAll(".view-open-modal").forEach(function(button) {
  button.addEventListener("click", function () {
    document.querySelector(".bg-content-view").style.display = "flex";
  });
});

const closeView = document.querySelector(".close-view");
closeView.addEventListener("click", function () {
  document.querySelector(".bg-content-view").style.display = "none";
});

document.addEventListener('DOMContentLoaded', function () {
  const scheduleButtons = document.querySelectorAll('.view-open-modal');
  scheduleButtons.forEach(button => {
    button.addEventListener('click', function () {
      const section = this.getAttribute('data-section');
      const strand = this.getAttribute('data-strand');
      const adviser = this.getAttribute('data-adviser');

      document.querySelector('input[name="section"]').value = section;
      document.querySelector('input[name="strand"]').value = strand;
      document.querySelector('input[name="adviser"]').value = adviser;
    });
  });
});
// for sorting the day
function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("scheduleTable");
  switching = true;
  while (switching) {
      switching = false;
      rows = table.getElementsByTagName("TR");
      for (i = 1; i < (rows.length - 1); i++) {
          shouldSwitch = false;
          x = rows[i].getElementsByTagName("TD")[2];
          y = rows[i + 1].getElementsByTagName("TD")[2];
          var days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
          var xIndex = days.indexOf(x.innerHTML);
          var yIndex = days.indexOf(y.innerHTML);
          if (xIndex > yIndex) {
              shouldSwitch = true;
              break;
          }
      }
      if (shouldSwitch) {
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
      }
  }
}