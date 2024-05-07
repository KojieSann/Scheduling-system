const body = document.querySelector("body"),
  sidebar = document.querySelector(".side-bar"),
  sub = document.querySelectorAll(".navlink"),
  icon = document.querySelectorAll(".icon"),
  sideBarOpen = document.querySelector(".sideBarOpen");
sideBarOpen.onclick = () => {
  sidebar.classList.toggle("close");
};
sub.forEach((item) => {
  item.onclick = () => {
    sub.forEach((item) => item.classList.remove("active"));
    item.classList.add("active");
  };
});
for (var i = 0; i < icon.length; i++) {
  icon[i].addEventListener("click", (e) => {
    let target = e.target;
    target.classList.toggle("active");
  });
}
