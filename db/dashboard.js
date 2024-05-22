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


// table to pdf
function tableToPDF() {
  var table2pdf = document.querySelector(".table");
  var checkboxColumns = table2pdf.querySelectorAll(".checkboxTbl");
  checkboxColumns.forEach(function(column) {
    column.parentNode.removeChild(column);
  });
  var opt = {
    margin: 1,
    filename: "octScheduleMaker.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
  };
  html2pdf(table2pdf, opt);
  checkboxColumns.forEach(function(column) {
    column.parentNode.insertBefore(column, table2pdf.querySelector("thead th:nth-child(1)"));
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
document.getElementById('tableToExcel').addEventListener('click', function(){
  var table2excel = new Table2Excel();
  table2excel.export(document.querySelectorAll("table"));
})

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
  var table = document.getElementById("scheduleTable");
  var rows = Array.from(table.getElementsByTagName("tr"));
  var groupedRows = {
      Monday: [],
      Tuesday: [],
      Wednesday: [],
      Thursday: [],
      Friday: []
  };
  for (var i = 1; i < rows.length; i++) {
      var dayCell = rows[i].getElementsByTagName("td")[3];
      var day = dayCell.textContent.trim();
      groupedRows[day].push(rows[i]);
  }
  while (table.rows.length > 1) {
      table.deleteRow(1);
  }

  for (var day in groupedRows) {
      if (groupedRows.hasOwnProperty(day)) {
          var rowsForDay = groupedRows[day];
          for (var j = 0; j < rowsForDay.length; j++) {
              table.appendChild(rowsForDay[j]);
          }
      }
  }

  var sortedRows = Array.from(table.getElementsByTagName("tr"));
  sortedRows.forEach(function(row, index) {
      if (index % 2 === 0) {
          row.style.backgroundColor = "#eee";
      } else {
          row.style.backgroundColor = ""; 
      }
  });
}
// for grouping sections
function groupSections() {
  var table = document.getElementById("scheduleTable");
  var rows = table.getElementsByTagName("tr");
  var groupedRows = {};
  for (var i = 1; i < rows.length; i++) {
      var sectionCell = rows[i].getElementsByTagName("td")[1]; 
      var section = sectionCell.textContent.trim();
      if (!groupedRows[section]) {
          groupedRows[section] = [];
      }
      groupedRows[section].push(rows[i]);
  }
  while (table.rows.length > 1) {
      table.deleteRow(1);
  }
  for (var section in groupedRows) {
      if (groupedRows.hasOwnProperty(section)) {
          var rowsForSection = groupedRows[section];
          for (var j = 0; j < rowsForSection.length; j++) {
              table.appendChild(rowsForSection[j]);
          }
      }
  }
  var sortedRows = Array.from(table.getElementsByTagName("tr"));
  sortedRows.forEach(function(row, index) {
      if (index % 2 === 0) {
          row.style.backgroundColor = "#eee";
      } else {
          row.style.backgroundColor = ""; 
      }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  const scheduleButtons = document.querySelectorAll('.view-open-modal');
  const tableRows = document.querySelectorAll('#scheduleTable tbody tr');
  const searchInput = document.getElementById('search-box');

  let currentSection = null;

  scheduleButtons.forEach(button => {
    button.addEventListener('click', function() {
      currentSection = this.getAttribute('data-section');
      filterTableBySection(currentSection);
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
