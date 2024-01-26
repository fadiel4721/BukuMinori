// Mendapatkan referensi elemen HTML menggunakan ID
let text = document.getElementById('text');   // elemen teks
let leaf = document.getElementById('leaf');   // elemen daun
let hill1 = document.getElementById('hill1'); // elemen gunung 1
let hill4 = document.getElementById('hill4'); // elemen gunung 4
let hill5 = document.getElementById('hill5'); // elemen gunung 5

// Menambahkan event listener untuk merespons peristiwa scroll pada window
window.addEventListener('scroll', () => {
    // Mendapatkan nilai posisi scroll (jumlah pixel yang telah di-scroll dari atas)
    let value = window.scrollY;

    // Mengubah margin atas elemen teks berdasarkan nilai scroll untuk efek parallax
    text.style.marginTop = value * 2.5 + 'px';

    // Mengubah posisi top dan left elemen daun untuk efek animasi parallax
    leaf.style.top = value * -1.5 + 'px';
    leaf.style.left = value * 1.5 + 'px';

    // Mengubah posisi left elemen gunung 5 untuk efek animasi parallax
    hill5.style.left = value * 1.5 + 'px';

    // Mengubah posisi left elemen gunung 4 untuk efek animasi parallax
    hill4.style.left = value * -1.5 + 'px';

    // Mengubah posisi top elemen gunung 1 untuk efek animasi parallax
    hill1.style.top = value * 1 + 'px';
});

