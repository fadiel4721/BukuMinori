var waktu = document.getElementById("waktu");
var hari = document.getElementById("hari");
var formatwaktu = document.getElementById("formatwaktu");

var jamdigital = setInterval(function calctime() {
  var tanggalsekarang = new Date();
  var jm = tanggalsekarang.getHours();
  var mn = tanggalsekarang.getMinutes();
  var sec = tanggalsekarang.getSeconds();
  var nilaiformatwaktu = "AM";
  var pekan = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

  hari.textContent = pekan[tanggalsekarang.getDay()];

  nilaiformatwaktu = jm >= 12 ? "PM" : "AM";
  if (jm == 0) {
    jm = 12;
  } else if (jm > 12) {
    jm -= 12;
  }
  jm = jm < 10 ? "0" + jm : jm;
  mn = mn < 10 ? "0" + mn : mn;
  sec = sec < 10 ? "0" + sec : sec;

  waktu.textContent = jm + ":" + mn + ":" + sec;
  formatwaktu.textContent = nilaiformatwaktu;
}, 1000);
