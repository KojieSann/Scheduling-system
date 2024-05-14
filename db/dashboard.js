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
  
