// popout for the logout
const logoutButton = document.querySelector(".logout");
const closePopup = document.querySelector(".noBtn");
logoutButton.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "flex";
});
closePopup.addEventListener("click", function () {
  document.querySelector(".bg-content-logout").style.display = "none";
});
const dropdownbtn = document.querySelector(".dropdown-day"),
  items = document.querySelectorAll(".ddown-listItem");
dropdownbtn.addEventListener("click", () => {
  dropdownbtn.classList.toggle("open");
});
items.forEach((item) => {
  item.addEventListener("click", () => {
    item.classList.toggle("checked");
    let checked = document.querySelectorAll("checked"),
      selectorText = document.querySelector(".selector-text");
    console.log(checked, selectorText);
    if (checked && checked.length > 0) {
      selectorText.innerText = `${checked.length} Day selected`;
    } else {
      selectorText.innerText = "Select Day";
    }
  });
});
function showicon() {
  const name = document.querySelector(".teacher-name").value;
  const icon = document.querySelector(".icon");
  if (name.lenght <= 0) document.body.classList.remove("act");
  else document.body.classList.add("act");
  icon.addEventListener("click", () => {
    document.querySelector(".name").value = "";
    document.body.classList.remove("act");
  });
}
// dropdown for time dropdown
const textboxtime = document.querySelector(".textbox-time");
const dropdown = document.querySelector(".dropdown-time");
function show(anything) {
  document.querySelector(".textbox-time").value = anything;
}
dropdown.onclick = function () {
  dropdown.classList.toggle("activeShow");
};
document.addEventListener("click", (e) => {
  if (!textboxtime.contains(e.target) && e.target !== dropdown) {
    dropdown.classList.remove("activeShow");
  }
});
// dropdown for strandlists

function reveal(anything) {
  document.querySelector(".textbox-strands").value = anything;
}
let dropdownStrand = document.querySelector(".strand-list");
dropdownStrand.onclick = function () {
  dropdownStrand.classList.toggle("activeShowStrand");
};
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
function validateForm() {
  var firstName = document.querySelector('.first-name').value;
  var lastName = document.querySelector('.last-name').value;
  var time = document.querySelector('.textbox-time').value;
  var strand = document.querySelector('.textbox-strands').value;
  var subjects = document.querySelector('.subject-select').value;

  if (firstName.trim() === '' || lastName.trim() === '' || time.trim() === '' || strand.trim() === '' || subjects.length === 0) {
    alert('Please fill in all required fields.');
    return false;
  }

  return true;
}
// search function for table
// document.addEventListener("touchstart", function () {}, true);
// const dropdownStrand = document.querySelector(".strand-list");
// const textboxStrand = document.querySelector(".textbox-strands");
// document.addEventListener("click", (e) => {
//   if (!textboxStrand.contains(e.target) && e.target !== dropdownStrand) {
//     dropdownStrand.classList.remove("activeShowStrand");
//   }
// });
