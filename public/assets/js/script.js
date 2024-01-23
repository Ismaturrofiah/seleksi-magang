const side = document.getElementById("sidebar");
const sideIcon = document.getElementById("sidebar-icon");
const sideUtama = document.getElementById("sidebar-utama");
const display = document.getElementById("content");

side.addEventListener("mouseover", Open);
function Open() {
  side.style.width = "15rem";
  sideIcon.hidden = true;
  sideUtama.removeAttribute("hidden");
  display.style.left = "15rem";
  display.style.width = "calc(100% - 15rem)";
}

side.addEventListener("mouseout", Close);
function Close() {
  side.style.width = "4.25rem";
  sideUtama.hidden = true;
  sideIcon.removeAttribute("hidden");
  display.style.left = "4.25rem";
  display.style.width = "calc(100% - 4.25rem)";
}
