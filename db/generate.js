
const modalButton = document.querySelector(".modal-button");
const closeModal = document.querySelector(".close-window");
modalButton.addEventListener("click", function () {
  document.querySelector(".bg-modal").style.display = "flex";
});
closeModal.addEventListener("click", function () {
  document.querySelector(".bg-modal").style.display = "none";
});
const modalSubject = document.querySelector(".open-modal");
const closeModalSubject = document.querySelector(".close-subject");
modalSubject.addEventListener("click", function () {
  document.querySelector(".bg-modal-subject").style.display = "flex";
});
closeModalSubject.addEventListener("click", function () {
  document.querySelector(".bg-modal-subject").style.display = "none";
});
// table to excel
document.getElementById('tableToExcel').addEventListener('click', function(){
  var table2excel = new Table2Excel();
  table2excel.export(document.querySelectorAll("#scheduleTable"));
})
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
    var checkedRows = document.querySelectorAll('.checkboxTbl input:checked');
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
    printContent += '<thead><tr><th>Section</th><th>Strand</th><th>Day</th><th>Subject</th><th>Time in</th><th>Time out</th><th>Duration</th><th>Instructor</th></tr></thead>';
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
  
// delete rows
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
      form.action = "deleteSchedule.php"; 

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
// for status in subject modal
  const modalOpenButtons = document.querySelectorAll('.open-modal');
  modalOpenButtons.forEach(button => {
    button.addEventListener('click', function() {
      const subjectCode = this.getAttribute('data-subject-code');
      const rows = document.querySelectorAll('.selected-row');
      
      rows.forEach(row => {
        row.classList.remove('selected-row');
      });
      const row = document.getElementById('row-' + subjectCode);
      row.classList.add('selected-row');
    });
  });
  const formSubmitButton = document.querySelector('.subj-btn-submit');
  formSubmitButton.addEventListener('click', function() {
    const selectedRow = document.querySelector('.selected-row');
    selectedRow.style.backgroundColor = '#d8f3dc';
  });

// select all for table
function toggleSelectAll() {
  var checkboxes = document.querySelectorAll('.checkboxTbl input[type="checkbox"]');
  var selectAllCheckbox = document.getElementById('selectAll');
  checkboxes.forEach(function(checkbox) {
    checkbox.checked = selectAllCheckbox.checked;
  });
}
document.querySelectorAll('.table tbody tr').forEach(function(row) {
  row.addEventListener('click', function() {
      var checkbox = this.querySelector('.checkboxTbl input[type="checkbox"]');
      checkbox.checked = !checkbox.checked;
  });
});

// // modal for viewing
// const view = document.querySelector(".view-open-modal");
// const closeView = document.querySelector(".close-view");
// view.addEventListener("click", function () {
//   document.querySelector(".bg-content-view").style.display = "flex";
// });
// closeView.addEventListener("click", function () {
//   document.querySelector(".bg-content-view").style.display = "none";
// });

// popout for the logout
const logoutButton = document.querySelector(".logout");
const closePopup = document.querySelector(".noBtn");
logoutButton.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "flex";
});
closePopup.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "none";
});
// day selection for subject
const monday = document.querySelector(".monday");
const tuesday = document.querySelector(".tuesday");
const wednesday = document.querySelector(".wednesday");
const thursday = document.querySelector(".thursday");
const friday = document.querySelector(".friday");
const mondaySlct = document.querySelector(".time-selection-monday");
const tuesdaySlct = document.querySelector(".time-selection-tuesday");
const wednesdaySlct = document.querySelector(".time-selection-wednesday");
const thursdaySlct = document.querySelector(".time-selection-thursday");
const fridaySlct = document.querySelector(".time-selection-friday");
monday.addEventListener("click", ()=>{
  monday.classList.add("active-day");
  tuesday.classList.remove("active-day");
  wednesday.classList.remove("active-day");
  thursday.classList.remove("active-day");
  friday.classList.remove("active-day");
  mondaySlct.style.display = "block";
  tuesdaySlct.style.display = "none";
  wednesdaySlct.style.display = "none";
  thursdaySlct.style.display = "none";
  fridaySlct.style.display = "none";
});
tuesday.addEventListener("click", ()=>{
  monday.classList.remove("active-day");
  tuesday.classList.add("active-day");
  wednesday.classList.remove("active-day");
  thursday.classList.remove("active-day");
  friday.classList.remove("active-day");
  mondaySlct.style.display = "none";
  tuesdaySlct.style.display = "block";
  wednesdaySlct.style.display = "none";
  thursdaySlct.style.display = "none";
  fridaySlct.style.display = "none";
});
wednesday.addEventListener("click", ()=>{
  monday.classList.remove("active-day");
  tuesday.classList.remove("active-day");
  wednesday.classList.add("active-day");
  thursday.classList.remove("active-day");
  friday.classList.remove("active-day");
  mondaySlct.style.display = "none";
  tuesdaySlct.style.display = "none";
  wednesdaySlct.style.display = "block";
  thursdaySlct.style.display = "none";
  fridaySlct.style.display = "none";
});
thursday.addEventListener("click", ()=>{
  monday.classList.remove("active-day");
  tuesday.classList.remove("active-day");
  wednesday.classList.remove("active-day");
  thursday.classList.add("active-day");
  friday.classList.remove("active-day");
  mondaySlct.style.display = "none";
  tuesdaySlct.style.display = "none";
  wednesdaySlct.style.display = "none";
  thursdaySlct.style.display = "block";
  fridaySlct.style.display = "none";
});
friday.addEventListener("click", ()=>{
  monday.classList.remove("active-day");
  tuesday.classList.remove("active-day");
  wednesday.classList.remove("active-day");
  thursday.classList.remove("active-day");
  friday.classList.add("active-day");
  mondaySlct.style.display = "none";
  tuesdaySlct.style.display = "none";
  wednesdaySlct.style.display = "none";
  thursdaySlct.style.display = "none";
  fridaySlct.style.display = "block";
});


function toggleButton(day) {
  var checkbox = document.getElementById(day);
  var button = document.querySelector("." + day);
  if (checkbox.checked) {
    button.classList.remove("not-selected");    
    button.removeAttribute("disabled");
  } else {
    button.classList.add("not-selected");
    button.classList.remove("not-active");
    button.setAttribute("disabled","");
    
  }
}

//  for the repeated checkbox in subject scheduling
const repeatCheckboxes = document.querySelectorAll('input[type="checkbox"][name="repeat"]');
repeatCheckboxes.forEach(function(checkbox) {
  checkbox.addEventListener("change", function() {
    const timeSelection = checkbox.closest('.time-selection');
    const inTimeInput = timeSelection.querySelector('.inTime input[type="time"]');
    const outTimeInput = timeSelection.querySelector('.outTime input[type="time"]');
    if (this.checked) {
      const inTimeValue = inTimeInput.value;
      const outTimeValue = outTimeInput.value;
      const timeSelections = document.querySelectorAll('.time-selection');
      timeSelections.forEach(function(selection) {
        if (selection !== timeSelection) {
          const inTimeInput = selection.querySelector('.inTime input[type="time"]');
          const outTimeInput = selection.querySelector('.outTime input[type="time"]');
          inTimeInput.value = inTimeValue;
          outTimeInput.value = outTimeValue;
        }
      });
    }
  });
});

// modal for multistep
initMultiStepForm();
function initMultiStepForm() {
  const progressNumber = document.querySelectorAll(".step").length;
  const slidePage = document.querySelector(".slide-page");
  const submitButton = document.querySelector(".submit");
  const progressText = document.querySelectorAll(".step p");
  const progressCheck = document.querySelectorAll(".step .check");
  const bullet = document.querySelectorAll(".step .bullet");
  const pages = document.querySelectorAll(".page");
  const nextButtons = document.querySelectorAll(".next");
  const prevButtons = document.querySelectorAll(".prev");
  const stepsNumber = pages.length;

  if (progressNumber !== stepsNumber) {
    console.warn("bubu ampotaaaa");
  }

  document.documentElement.style.setProperty("--stepNumber", stepsNumber);

  let current = 1;

  for (let i = 0; i < nextButtons.length; i++) {
    nextButtons[i].addEventListener("click", function (event) {
      event.preventDefault();

      inputsValid = validateInputs(this);
      // inputsValid = true;

      if (inputsValid) {
        slidePage.style.marginLeft = `-${(100 / stepsNumber) * current}%`;
        bullet[current - 1].classList.add("active");
        progressCheck[current - 1].classList.add("active");
        progressText[current - 1].classList.add("active");
        current += 1;
      }
    });
  }

  for (let i = 0; i < prevButtons.length; i++) {
    prevButtons[i].addEventListener("click", function (event) {
      event.preventDefault();
      slidePage.style.marginLeft = `-${(100 / stepsNumber) * (current - 2)}%`;
      bullet[current - 2].classList.remove("active");
      progressCheck[current - 2].classList.remove("active");
      progressText[current - 2].classList.remove("active");
      current -= 1;
    });
  }
  submitButton.addEventListener("click", function () {
    bullet[current - 1].classList.add("active");
    progressCheck[current - 1].classList.add("active");
    progressText[current - 1].classList.add("active");
    current += 1;
    setTimeout(function () {
      alert("KAGALING AHHHHH!!");
      location.reload();
    }, 800);
  });

  function validateInputs(ths) {
    let inputsValid = true;

    const inputs =
      ths.parentElement.parentElement.querySelectorAll(".required-input");
    for (let i = 0; i < inputs.length; i++) {
      const valid = inputs[i].checkValidity();
      if (!valid) {
        inputsValid = false;
        inputs[i].classList.add("invalid-input");
      } else {
        inputs[i].classList.remove("invalid-input");
      }
    }
    return inputsValid;
  }
}
//for modal subject
const form1 = document.querySelector(".form1");
const form2 = document.querySelector(".form2");
const form1NxtBtn = document.querySelector(".subj-btn-next");
const form2BckBtn = document.querySelector(".subj-btn-back2");
form1NxtBtn.addEventListener("click", function () {
  form1.style.display = "none";
  form2.style.display = "block";
});
form2BckBtn.addEventListener("click", function () {
  form2.style.display = "none";
  form1.style.display = "block";
});
// dropdown for subject
var style = document.createElement("style");
style.setAttribute("id", "multiselect_dropdown_styles");
document.head.appendChild(style);
function MultiselectDropdown(options) {
  var config = {
    search: true,
    placeholder: "Select",
    txtSelected: "Selected",
    txtAll: "All",
    txtRemove: "Remove",
    txtSearch: "Search",
    ...options,
  };
  function newEl(tag, attrs) {
    var e = document.createElement(tag);
    if (attrs !== undefined)
      Object.keys(attrs).forEach((k) => {
        if (k === "class") {
          Array.isArray(attrs[k])
            ? attrs[k].forEach((o) => (o !== "" ? e.classList.add(o) : 0))
            : attrs[k] !== ""
            ? e.classList.add(attrs[k])
            : 0;
        } else if (k === "style") {
          Object.keys(attrs[k]).forEach((ks) => {
            e.style[ks] = attrs[k][ks];
          });
        } else if (k === "text") {
          attrs[k] === "" ? (e.innerHTML = "&nbsp;") : (e.innerText = attrs[k]);
        } else e[k] = attrs[k];
      });
    return e;
  }

  document.querySelectorAll("select[multiple]").forEach((el, k) => {
    var div = newEl("div", {
      class: "multiselect-dropdown",
      style: {
        padding: config.style?.padding ?? "",
      },
    });
    el.style.display = "none";
    el.parentNode.insertBefore(div, el.nextSibling);
    var listWrap = newEl("div", { class: "multiselect-dropdown-list-wrapper" });
    var list = newEl("div", {
      class: "multiselect-dropdown-list",
      style: { height: config.height },
    });
    var search = newEl("input", {
      class: ["multiselect-dropdown-search"].concat([
        config.searchInput?.class ?? "form-control",
      ]),
      style: {
        width: "100%",
        display:
          el.attributes["multiselect-search"]?.value === "true"
            ? "block"
            : "none",
      },
      placeholder: config.txtSearch,
    });
    listWrap.appendChild(search);
    div.appendChild(listWrap);
    listWrap.appendChild(list);

    el.loadOptions = () => {
      list.innerHTML = "";

      if (el.attributes["multiselect-select-all"]?.value == "true") {
        var op = newEl("div", { class: "multiselect-dropdown-all-selector" });
        var ic = newEl("input", {
          type: "checkbox",
          class: "subject-checkbox",
        });
        op.appendChild(ic);
        op.appendChild(newEl("label", { text: config.txtAll }));

        op.addEventListener("click", () => {
          op.classList.toggle("checked");
          op.querySelector("input").checked =
            !op.querySelector("input").checked;

          var ch = op.querySelector("input").checked;
          list
            .querySelectorAll(
              ":scope > div:not(.multiselect-dropdown-all-selector)"
            )
            .forEach((i) => {
              if (i.style.display !== "none") {
                i.querySelector("input").checked = ch;
                i.optEl.selected = ch;
              }
            });

          el.dispatchEvent(new Event("change"));
        });
        ic.addEventListener("click", (ev) => {
          ic.checked = !ic.checked;
        });

        list.appendChild(op);
      }

      Array.from(el.options).map((o) => {
        var op = newEl("div", { class: o.selected ? "checked" : "", optEl: o });
        var ic = newEl("input", { type: "checkbox", checked: o.selected });
        op.appendChild(ic);
        op.appendChild(newEl("label", { text: o.text }));

        op.addEventListener("click", () => {
          op.classList.toggle("checked");
          op.querySelector("input").checked =
            !op.querySelector("input").checked;
          op.optEl.selected = !!!op.optEl.selected;
          el.dispatchEvent(new Event("change"));
        });
        ic.addEventListener("click", (ev) => {
          ic.checked = !ic.checked;
        });
        o.listitemEl = op;
        list.appendChild(op);
      });
      div.listEl = listWrap;

      div.refresh = () => {
        div
          .querySelectorAll("span.optext, span.placeholder")
          .forEach((t) => div.removeChild(t));
        var sels = Array.from(el.selectedOptions);
        if (
          sels.length > (el.attributes["multiselect-max-items"]?.value ?? 5)
        ) {
          div.appendChild(
            newEl("span", {
              class: ["optext", "maxselected"],
              text: sels.length + " " + config.txtSelected,
            })
          );
        } else {
          sels.map((x) => {
            var c = newEl("span", {
              class: "optext",
              text: x.text,
              srcOption: x,
            });
            if (el.attributes["multiselect-hide-x"]?.value !== "true")
              c.appendChild(
                newEl("span", {
                  class: "optdel",
                  text: "🗙",
                  title: config.txtRemove,
                  onclick: (ev) => {
                    c.srcOption.listitemEl.dispatchEvent(new Event("click"));
                    div.refresh();
                    ev.stopPropagation();
                  },
                })
              );

            div.appendChild(c);
          });
        }
        if (0 == el.selectedOptions.length)
          div.appendChild(
            newEl("span", {
              class: "placeholder",
              text: el.attributes["placeholder"]?.value ?? config.placeholder,
            })
          );
      };
      div.refresh();
    };
    el.loadOptions();

    search.addEventListener("input", () => {
      list
        .querySelectorAll(":scope div:not(.multiselect-dropdown-all-selector)")
        .forEach((d) => {
          var txt = d.querySelector("label").innerText.toUpperCase();
          d.style.display = txt.includes(search.value.toUpperCase())
            ? "block"
            : "none";
        });
    });

    div.addEventListener("click", () => {
      div.listEl.style.display = "block";
      search.focus();
      search.select();
    });

    document.addEventListener("click", function (event) {
      if (!div.contains(event.target)) {
        listWrap.style.display = "none";
        div.refresh();
      }
    });
  });
}

window.addEventListener("load", () => {
  MultiselectDropdown(window.MultiselectDropdownOptions);
});

document.addEventListener('DOMContentLoaded', function() {
  var nextButtons = document.querySelectorAll('.next');
  var nextButton = document.querySelector('.next-1');
  var prevButton = document.querySelector('.prev-1');

  nextButtons.forEach(function(button) {
      button.addEventListener('click', function(event) {
          event.preventDefault();

          var section = this.getAttribute('data-section');
          var strand = this.getAttribute('data-strand');
          var gradeLevel = this.getAttribute('data-grade-level');

          document.getElementById('inputSection').value = section;
          document.getElementById('inputStrand').value = strand;
          document.getElementById('inputGradeLevel').value = gradeLevel;
        
      });
  });
});

document.addEventListener('DOMContentLoaded', function() {
    var applyButtons = document.querySelectorAll('.open-modal');

    applyButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            var subjectName = this.getAttribute('data-subject-name');
            var subjectCode = this.getAttribute('data-subject-code');

            document.getElementById('modalSubjectName').value = subjectName;
            document.getElementById('modalSubjectCode').value = subjectCode;
        });
    });
});

$(document).ready(function(){
  $('.open-modal').click(function(){
      var subjectName = $(this).data('subject-name');
      var subjectCode = $(this).data('subject-code');
      var strand = $(this).data('strand');
      var gradeLevel = $(this).data('grade-level');

      $('#modalSubjectName').val(subjectName);
      $('#modalSubjectCode').val(subjectCode);

      $('.bg-modal-subject').show();
  });

  $('.close-subject').click(function(){
      $('.bg-modal-subject').hide();
  });
});

function updatePreferredDays(selectElement) {
  var instructorId = selectElement.value;

  fetch('fetch_instructor_availability.php?id=' + instructorId)
    .then(response => response.json())
    .then(data => {
      updateCheckboxes(data.days);
      updateTime(data.time);
    });
}

function updateCheckboxes(preferredDays) {
  var checkboxes = document.querySelectorAll('.input-wrap input[type="checkbox"]');
  checkboxes.forEach(function(checkbox) {
    checkbox.checked = false;
  });

  preferredDays.forEach(function(day) {
    var checkbox = document.getElementById(day);
    if (checkbox) {
      checkbox.checked = true;
      checkbox.dispatchEvent(new Event('change'));
    }
  });
}
function updateTime(preferredTime) {
  var timeRadios = document.querySelectorAll('input[name="time"]');
  timeRadios.forEach(function(radio) {
    radio.checked = (radio.value === preferredTime);
  });
}
$(document).ready(function() {
  var selectedStrands = [];

  function filterSubjects() {
    $('.section-table tbody tr').each(function() {
      var subjectStrands = $(this).find('td:nth-child(3)').text().trim().split(',');

      if (selectedStrands.length === 0 || selectedStrands.some(strand => subjectStrands.map(s => s.trim()).includes(strand.trim()))) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  }
  $('.next').click(function() {
    selectedStrands = $('#inputStrand').val().split(',');
    filterSubjects();
  });
  $('.prev').click(function() {
    selectedStrands = [];
    filterSubjects();
  });
  filterSubjects();
});

$('.next-1').click(function() {
  var section = $('#inputSection').val();
  var strand = $('#inputStrand').val();
  var gradeLevel = $('#inputGradeLevel').val();

  $('.details').find('input[name="inputSection"]').val(section);
  $('.details').find('input[name="inputStrand"]').val(strand);
  $('.details').find('input[name="inputGradeLevel"]').val(gradeLevel);
});

//  dropdown for semester
function show(anything) {
  document.querySelector(".textbox-sy").value = anything;
}
const textBoxStrand = document.querySelector(".textbox-sy")
let dropdownStrand = document.querySelector(".dropdown-sem");
dropdownStrand.onclick = function () {
  dropdownStrand.classList.toggle("activeShow");
};
document.addEventListener("click", (e) => {
  if (!textBoxStrand.contains(e.target) && e.target !== dropdownStrand) {
    dropdownStrand.classList.remove("activeShow");
  }
});
// search function for the table
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('search-box');
  const tableRows = document.querySelectorAll('.schedules-table .table tbody tr');

  searchInput.addEventListener('input', function() {
    const searchTerm = searchInput.value.toLowerCase().trim();

    tableRows.forEach(function(row) {
      const section = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim();
      const strand = row.querySelector('td:nth-child(3)').textContent.toLowerCase().trim();
      const day = row.querySelector('td:nth-child(4)').textContent.toLowerCase().trim();
      const subject = row.querySelector('td:nth-child(5)').textContent.toLowerCase().trim();
      const timeIn = row.querySelector('td:nth-child(6)').textContent.toLowerCase().trim();
      const timeOut = row.querySelector('td:nth-child(7)').textContent.toLowerCase().trim();
      const duration = row.querySelector('td:nth-child(8)').textContent.toLowerCase().trim();
      const instructor = row.querySelector('td:nth-child(9)').textContent.toLowerCase().trim();

      if (section.includes(searchTerm) || strand.includes(searchTerm) || day.includes(searchTerm) || subject.includes(searchTerm) || timeIn.includes(searchTerm) || timeOut.includes(searchTerm) || duration.includes(searchTerm) || instructor.includes(searchTerm)) {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    });
  });
});

  // search function for the modal
  const searchInput = document.getElementById('searchInput');
  const tableRows = document.querySelectorAll('.section-table tbody tr');

  searchInput.addEventListener('input', function() {
    const searchTerm = searchInput.value.toLowerCase().trim();

    tableRows.forEach(function(row) {
      const sectionName = row.querySelector('td:nth-child(1)').textContent.toLowerCase().trim();
      const strand = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim();
      const gradeLevel = row.querySelector('td:nth-child(3)').textContent.toLowerCase().trim();

      if (sectionName.includes(searchTerm) || strand.includes(searchTerm) || gradeLevel.includes(searchTerm)) {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    });
  });

  const form = document.getElementById('contact_form');
  const myDiv = document.getElementById('formContainer');

form.addEventListener('submit', (event) => {
  event.preventDefault();
  const inputSectionValue = document.getElementById('inputSection').value;
  const inputStrandValue = document.getElementById('inputStrand').value;
  
  const formData = new FormData(form);
  
  formData.append('inputSection', inputSectionValue);
  formData.append('inputStrand', inputStrandValue);
  
  fetch("addSchedule.php", {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if (response.ok) {
      window.alert("Schedule added successfully");
      document.querySelector('.bg-modal-subject').style.display = 'none';
      document.getElementById('contact_form').reset();
      form2.style.display = "none";
      form1.style.display = "block";
    } else {
      myDiv.innerHTML = '<p>There was an error submitting the form</p>';
    }
  })
  .catch(error => {
    myDiv.innerHTML = '<p>There was an error submitting the form:'+error+'</p>';
  });
});

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




