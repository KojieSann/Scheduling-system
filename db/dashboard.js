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

  //search function for the table
  const searchInput = document.getElementById('search-box');
  const tableRows = document.querySelectorAll('.schedule-table .table tbody tr');
  
  searchInput.addEventListener('input', function() {
    const searchTerm = searchInput.value.toLowerCase().trim();
  
    tableRows.forEach(function(row) {
      const section = row.querySelector('td:nth-child(1)').textContent.toLowerCase().trim();
      const strand = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim();
      const numberOfSubjects = row.querySelector('td:nth-child(3)').textContent.toLowerCase().trim();
      const sem = row.querySelector('td:nth-child(4)').textContent.toLowerCase().trim();
      const sy = row.querySelector('td:nth-child(5)').textContent.toLowerCase().trim();
      const adviser = row.querySelector('td:nth-child(6)').textContent.toLowerCase().trim(); 

      if (section.includes(searchTerm) || strand.includes(searchTerm) || numberOfSubjects.includes(searchTerm) || sem.includes(searchTerm) || sy.includes(searchTerm) || adviser.includes(searchTerm)) {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    });
  });
  
 // function to handle "Select All" functionality
 function toggleSelectAll() {
  var checkboxes = document.querySelectorAll('.checkboxTbl input[type="checkbox"]');
  var selectAllCheckbox = document.getElementById('selectAll');
  checkboxes.forEach(function(checkbox) {
    checkbox.checked = selectAllCheckbox.checked;
  });
}



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
  printContent += '<thead><tr><th>Section</th><th>Strand</th><th># of Subjects</th><th>Sem</th><th>SY</th><th>Adviser</th></tr></thead>';
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
  newWindow.document.write('<html><head><title>Checked Rows</title><style>.hide-on-print { display: none; }</style></head><body>' + printContent + '</body></html>');
  newWindow.document.close();
  newWindow.print();
  checkedRows.forEach(function (row) {
      var tdElements = row.closest('tr').querySelectorAll('td');
      tdElements.forEach(function (td) {
          td.classList.remove('hide-on-print');
      });
  });
}
// delete function
function deleteSelectedRows() {
  var selectedRows = document.querySelectorAll('input[name="selected[]"]:checked');
  if (selectedRows.length === 0) {

      alert("Please select at least one row to delete.");
      return; 
  }
  var confirmed = window.confirm("Are you sure you want to delete the selected rows?");
  if (confirmed) {
      var form = document.createElement("form");
      form.method = "POST";
      form.action = "deleteSchedDashboard.php"; 

      selectedRows.forEach(function(row) {
          var input = document.createElement("input");
          input.type = "hidden";
          input.name = "selected[]";
          input.value = row.value;
          form.appendChild(input);
      });

      document.body.appendChild(form);
      form.submit();
  }
}
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

function searchFunction() {
  var input, filter, table, tr, td, i, j, txtValue;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("scheduleTable");
  tr = table.getElementsByTagName("tr");

  for (i = 1; i < tr.length; i++) { // Start from index 1 to exclude thead
      var found = false;
      td = tr[i].getElementsByTagName("td");
      for (j = 0; j < td.length; j++) {
          txtValue = td[j].textContent || td[j].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
              found = true;
              break;
          }
      }
      if (found) {
          tr[i].style.display = "";
      } else {
          tr[i].style.display = "none";
      }
  }
}
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

document.addEventListener('DOMContentLoaded', function() {
  const scheduleButtons = document.querySelectorAll('.view-open-modal');
  const tableRows = document.querySelectorAll('#scheduleTable tbody tr');
  const searchInput = document.getElementById('search-box');

  let currentSection = null;

  scheduleButtons.forEach(button => {
    button.addEventListener('click', function() {
      currentSection = this.getAttribute('data-section');
      filterTableBySection(currentSection, searchInput.value.toLowerCase().trim());
    });
  });

  searchInput.addEventListener('input', function() {
    const searchTerm = searchInput.value.toLowerCase().trim();
    filterTableBySection(currentSection, searchTerm);
  });

  function filterTableBySection(section, searchTerm = '') {
    tableRows.forEach(row => {
      const matchesSection = !section || row.getAttribute('data-section') === section;
      const matchesSearch = row.textContent.toLowerCase().includes(searchTerm);

      if (matchesSection && matchesSearch) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  }
});
