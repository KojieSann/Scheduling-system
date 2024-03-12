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
  const submitBtn = document.querySelector(".submit");
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
  submitBtn.addEventListener("click", function () {
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
