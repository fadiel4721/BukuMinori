// Mengambil elemen-elemen HTML yang akan digunakan
const body = document.querySelector("body"),
  sidebar = body.querySelector(".sidebar"),
  toggle = body.querySelector(".toggle"),
  searchBtn = body.querySelector(".search-box"),
  modeSwitch = body.querySelector(".toggle-switch"),
  modeText = body.querySelector(".mode-text");

// Event listener untuk meng-handle toggle pada tombol sidebar
toggle.addEventListener("click", () => {
  sidebar.classList.toggle("close"); // Menambah atau menghapus kelas "close" pada elemen sidebar
});

// Event listener untuk meng-handle klik pada tombol pencarian, menghilangkan kelas "close" dari sidebar
searchBtn.addEventListener("click", () => {
  sidebar.classList.remove("close");
});

// Event listener untuk meng-handle toggle pada mode gelap atau terang
modeSwitch.addEventListener("click", () => {
  body.classList.toggle("dark"); // Menambah atau menghapus kelas "dark" pada elemen body

  // Mengganti teks mode tergantung pada status kelas "dark"
  if (body.classList.contains("dark")) {
    modeText.innerText = "Light Mode";
  } else {
    modeText.innerText = "Dark Mode";
  }
});
