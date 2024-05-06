
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

const dropdownTable = document.querySelector(".dropdown-table");
dropdownTable.onclick = function () {
  dropdownTable.classList.toggle("activeShow");
};
document.addEventListener("click", (e) => {
  if (!dropdownTable.contains(e.target) && e.target !== dropdownTable) {
    dropdownTable.classList.remove("activeShow");
  }
});
// table to excel
function tableToExcel() {
  var table2excel = new Table2Excel();
  table2excel.export(document.querySelectorAll(".table"));
}
// table to pdf
function tableToPDF() {
  var table2pdf = document.querySelector(".table");
  var opt = {
    margin: 1,
    filename: "octScheduleMaker.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
  };
  html2pdf(table2pdf, opt);
}
// popout for the logout
const logoutButton = document.querySelector(".logout");
const closePopup = document.querySelector(".noBtn");
logoutButton.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "flex";
});
closePopup.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "none";
});
// select all for table
const selectAll = document.getElementById("selectAll");
const select = document.getElementsByClassName("select");
selectAll.onclick = () => {
  if (selectAll.checked == true) {
    for (let i = 0; i < select.length; i++) {
      select[i].checked = true;
      document.querySelector(".table-nav").style.display = "block";
    }
  } else {
    for (let i = 0; i < select.length; i++) {
      select[i].checked = false;
      document.querySelector(".table-nav").style.display = "none";
    }
  }
};
// modal for subject
// to make it draggable hehe
// const modalSubject = document.querySelector(".modal-content-subject"),
//   drag = modalSubject.querySelector(".dragable");
// function ondrag({ movementX, movementY }) {
//   let getStyle = window.getComputedStyle(modalSubject);
//   let left = parseInt(getStyle.left);
//   let top = parseInt(getStyle.top);

//   modalSubject.style.left = `${left + movementX}px`;
//   modalSubject.style.top = `${top + movementY}px`;
// }
// drag.addEventListener("mousedown", () => {
//   drag.addEventListener("mousemove", ondrag);
// });

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
// multistep for modal subject
const bgModalSubject = document.querySelector(".bg-modal-subject");
const form1 = document.querySelector(".form1");
const form2 = document.querySelector(".form2");
const form3 = document.querySelector(".form3");
const form1NxtBtn = document.querySelector(".subj-btn-next");
const form2BckBtn = document.querySelector(".subj-btn-back2");
const submitBtnSubj = document.querySelector(".subj-btn-submit");
const doneStatus = document.querySelector(".done"),
  inProgress = document.querySelector(".in-progress");
form1NxtBtn.addEventListener("click", function () {
  form1.style.display = "none";
  form2.style.display = "block";
});
form2BckBtn.addEventListener("click", function () {
  form2.style.display = "none";
  form1.style.display = "block";
});
submitBtnSubj.addEventListener("click", function () {
  doneStatus.style.display = "block";
  bgModalSubject.style.display = "none";
  inProgress.style.display = "none";
  console.log("hahahah");
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
        width: config.style?.width ?? el.clientWidth + "px",
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
    document.getElementById(day).checked = true;
  });
}

function updateTime(preferredTime) {
  var timeRadios = document.querySelectorAll('input[name="time"]');
  timeRadios.forEach(function(radio) {
    radio.checked = (radio.value === preferredTime);
  });
}
