<?php

include_once("views/Template.php"); //Memuat kelas view/template satu kali ini untuk mencegah error redeclare/duplikasi deklarasi
include_once("models/DB.php"); //Memuat kelas koneksi database satu kali
include_once("controllers/SongController.php"); //Memuat controller yang menangani logika data song satu kali

$song = new SongController(); //Membuat instance (objek) dari SongController untuk menjalankan aksi CRUD

if (isset($_POST['add'])){ //Mengecek apakah form tambah data dikirim melalui metode POST dengan tombol yang namanya 'add'
    $song->add($_POST); //Memanggil method add() pada controller dengan membawa seluruh data dari $_POST
}
elseif (isset($_POST['update']) && isset($_GET['id_update'])){ //Jika bukan 'add', cek apakah form ubah data dikirim via POST dan parameter 'id_update' ada di URL ($_GET)
    $song->update($_GET['id_update'], $_POST); //Memanggil method update() dengan membawa ID data yang diubah serta data baru dari $_POST
}
elseif (!empty($_GET['id_hapus'])) { //Jika bukan 'add' maupun 'update', cek apakah parameter 'id_hapus' di URL ada dan tidak kosong
    $song->delete($_GET['id_hapus']); //Memanggil method delete() untuk menghapus data song berdasarkan ID yang dikirim
}
else{ //Ini jika tidak ada aksi add, update, maupun delete yang diminta
    $song->index(); //Menampilkan halaman daftar data song
}