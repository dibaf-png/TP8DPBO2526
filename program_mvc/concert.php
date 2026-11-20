<?php

include_once("views/Template.php"); //Memuat kelas view/template satu kali ini untuk mencegah error redeclare/duplikasi deklarasi
include_once("models/DB.php"); //Memuat kelas koneksi/abstraksi database satu kali
include_once("controllers/ConcertController.php"); //Memuat kelas koneksi/abstraksi database satu kali

$concert = new ConcertController(); // Membuat instance (objek) dari ConcertController untuk menjalankan aksi CRUD

if (isset($_POST['add'])) { //Mengecek apakah form tambah data dikirim lewat metode POST dengan nama 'add'
    $concert->add($_POST); //Memanggil method add() pada controller dengan membawa seluruh data dari $_POST
}
elseif (isset($_POST['update']) && isset($_GET['id_update'])){ // Jika bukan 'add', cek apakah form edit dikirim via POST ('update') dan 'id_update' tersedia di query string ($_GET)
    $concert->update($_GET['id_update'], $_POST); //Memanggil method update() dengan membawa ID data yang diubah serta data baru dari $_POST
}
elseif (!empty($_GET['id_hapus'])){ //Jika bukan 'add' maupun 'update', cek apakah parameter 'id_hapus' di URL ada dan tidak kosong
    $concert->delete($_GET['id_hapus']); //Memanggil method delete() untuk menghapus data concert berdasarkan ID di URL
}
else{ //Ini jika tidak ada aksi add, update, maupun delete yang diminta
    $concert->index(); //Memanggil method index() untuk menampilkan halaman utama atau daftar data concert
}