<?php

include_once("views/Template.php"); //Memuat kelas view/template satu kali ini untuk mencegah error redeclare/duplikasi deklarasi
include_once("models/DB.php"); //Memuat kelas koneksi database satu kali
include_once("controllers/SetlistController.php"); //Memuat controller yang menangani logika data setlist satu kali

$setList = new SetlistController(); //Membuat instance (objek) dari SetlistController untuk menjalankan aksi CRUD

if (isset($_POST['add'])){ //Mengecek apakah form tambah data dikirim melalui metode POST dengan tombol yang namanya 'add'
    $setList->add($_POST); //Memanggil method add() pada controller dengan membawa seluruh data dari $_POST
}
elseif (isset($_POST['update']) && isset($_GET['id_update'])){ //Jika bukan 'add', cek apakah form ubah data dikirim via POST dan parameter 'id_update' ada di URL ($_GET)
    $setList->update($_GET['id_update'], $_POST); //Memanggil method update() dengan membawa ID data yang diubah serta data baru dari $_POST
}
elseif (!empty($_GET['id_hapus'])) { //Jika bukan 'add' maupun 'update', cek apakah parameter 'id_hapus' di URL ada dan tidak kosong
    $setList->delete($_GET['id_hapus']); //Memanggil method delete() untuk menghapus data setlist berdasarkan ID yang dikirim
}
else{ //Ini jika tidak ada aksi add, update, maupun delete yang diminta
    $setList->index(); //Menampilkan halaman daftar data setlist
}