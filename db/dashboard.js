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
  printContent += '<thead><tr><th>Section</th><th>Strand</th><th>Grade level</th><th># of Subjects</th><th>Sem</th><th>SY</th><th>Adviser</th></tr></thead>';
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
  newWindow.document.write('<html><head><title>Print page</title><style>.hide-on-print { display: none; }</style></head><body>' + printContent + '</body></html>');
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
 

 document.querySelector('.openTutorial').addEventListener('click', function (){
  document.querySelector('.bg-content-tutorial').style.display = "flex";
 })
  let currentPage = 1;
  const pages = document.querySelectorAll(".tutorialPage");

  function showPage(pageNumber) {
    pages.forEach(page => {
      page.style.display = "none";
    });
    document.querySelector(`.page${pageNumber}`).style.display = "flex";
  }
  function nextPage() {
    if (currentPage < pages.length) {
        currentPage++;
        showPage(currentPage);
    }
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
}

document.querySelector(".nxtTutsPage").addEventListener("click", nextPage);
document.querySelector(".nxtTutsPage2").addEventListener("click", nextPage);
document.querySelector(".nxtTutsPage3").addEventListener("click", nextPage);
document.querySelector(".nxtTutsPage4").addEventListener("click", nextPage); // New next button for the fifth page
document.querySelector(".nxtTutsPage5").addEventListener("click", nextPage); // New next button for the fifth page
document.querySelector(".bckTutsPage").addEventListener("click", prevPage);
document.querySelector(".bckTutsPage2").addEventListener("click", prevPage);
document.querySelector(".bckTutsPage3").addEventListener("click", prevPage);
document.querySelector(".bckTutsPage4").addEventListener("click", prevPage); // New previous button for the fifth page
document.querySelector(".bckTutsPage5").addEventListener("click", prevPage); // New previous button for the fifth page

document.querySelector(".closeTutsPage").addEventListener("click", () => {
    document.querySelector('.bg-content-tutorial').style.display = "none";
    currentPage = 1;
    showPage(currentPage);
});

showPage(1);

