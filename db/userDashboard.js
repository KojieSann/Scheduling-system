
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
function tableToPrint() {
  // var table2pdf = document.querySelector(".table");
  // var opt = {
  //   margin: 1,
  //   filename: "octScheduleMaker.pdf",
  //   image: { type: "jpeg", quality: 0.98 },
  //   html2canvas: { scale: 2 },
  //   jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
  // };
  // html2pdf(table2pdf, opt);
  var checkedRows = document.querySelectorAll('.select:checked');
  if (checkedRows.length === 0) {
      alert("Please select at least one row to print.");
      return;
  }
  checkedRows.forEach(function(row) {
      var tdElements = row.closest('tr').querySelectorAll('td');
      tdElements.forEach(function(td) {
          td.classList.add('hide-on-print');
      });
  });
  var printContent = '<table border="1">';
  printContent += '<thead><tr><th>Section</th><th>Strand</th><th>Schedule</th><th>Sem</th><th>SY</th><th>Time</th><th>Adviser</th></tr></thead>';
  printContent += '<tbody>';
  checkedRows.forEach(function(row) {
      var rowData = row.closest('tr').querySelectorAll('td:not(.checkboxTbl)');
      printContent += '<tr>';
      rowData.forEach(function(cell) {
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
  checkedRows.forEach(function(row) {
      var tdElements = row.closest('tr').querySelectorAll('td');
      tdElements.forEach(function(td) {
          td.classList.remove('hide-on-print');
      });
  });
}
// select all for table
function toggleSelectAll(tableIndex) {
  var table = document.querySelectorAll('.table')[tableIndex - 1];
  var checkboxes = table.querySelectorAll('.checkboxTbl input[type="checkbox"]');
  var selectAllCheckbox = table.querySelector('.checkboxTbl input[type="checkbox"]:first-child');
  checkboxes.forEach(function(checkbox) {
    checkbox.checked = selectAllCheckbox.checked;
  });
  toggleTableNav();
}



