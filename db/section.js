// search function
  const searchInput = document.getElementById('search-box');
  const tableRows = document.querySelectorAll('.section-table .table tbody tr');

  searchInput.addEventListener('input', function() {
    const searchTerm = searchInput.value.toLowerCase().trim();

    tableRows.forEach(function(row) {
      const sectionName = row.querySelector('td:nth-child(1)').textContent.toLowerCase().trim();
      const gradeLevel = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim();
      const strand = row.querySelector('td:nth-child(3)').textContent.toLowerCase().trim();

      if (sectionName.includes(searchTerm) || gradeLevel.includes(searchTerm) || strand.includes(searchTerm)) {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    });
  });
// popout for the logout
const logoutButton = document.querySelector(".logout");
const closePopup = document.querySelector(".noBtn");
logoutButton.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "flex";
});
closePopup.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "none";
});
// dropdown for strand
function show(anything) {
  document.querySelector(".textbox-strand").value = anything;
}
const textboxStrand =  document.querySelector(".textbox-strand");
let dropdownStrand = document.querySelector(".dropdown-strand");
dropdownStrand.onclick = function () {
  dropdownStrand.classList.toggle("showStrand");
};
document.addEventListener("click", (e) => {
  if (!textboxStrand.contains(e.target) && e.target !== dropdownStrand) {
    dropdownStrand.classList.remove("showStrand");
  }
});
// dropdown for grade lvl
function reveal(anything) {
    document.querySelector(".textbox-grade").value = anything;
  }
  const textboxGlvl = document.querySelector(".textbox-grade");
  let dropdowngradeLvl = document.querySelector(".dropdown-gradelvl");
  dropdowngradeLvl.onclick = function () {
    dropdowngradeLvl.classList.toggle("activeShowGLevel");
  };
  document.addEventListener("click", (e) => {
    if (!textboxGlvl.contains(e.target) && e.target !== dropdowngradeLvl) {
        dropdowngradeLvl.classList.remove("activeShowGLevel");
    }
  });

function validateFormSection() {
    var sectionName = document.querySelector('[name="section_name"]').value;
    var gradeLevel = document.querySelector('[name="grade_level"]').value;
    var strand = document.querySelector('.textbox-grade').value;
  
    if (sectionName.trim() === '' || gradeLevel.trim() === '' || strand.trim() === '') {
      alert('Please fill in all required fields.');
      return false;
    }
  
    return true;
  }
  console.log('hjahahaa');