<?php

include_once("config.php"); //Memuat file konfigurasi database sekali saja
include_once("models/Concert.php"); //Memuat model Concert sekali saja
include_once("views/ConcertView.php"); //Memuat view ConcertView sekali saja

class ConcertController{ //Membuat class ConcertController untuk mengatur alur data konser
    private $concert; //Menyimpan instance model Concert

    function __construct(){ //Konstruktor yang dijalankan saat controller diinstansiasi
        $this->concert = new Concert(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name); //Membuat objek model Concert dengan kredensial dari Config
    }

    public function index(){ //Menampilkan halaman utama jadwal dan form konser
        $this->concert->open(); //Membuka koneksi database
        $this->concert->getConcert(); //Mengambil seluruh data jadwal konser

        $data= array( //Menyiapkan struktur data untuk dikirim ke view
            'concert' => array(), 'edit_data' => null); //Inisialisasi array awal dan edit_data null

        while ($row = $this->concert->getResult()) { //Melakukan iterasi setiap baris hasil query konser
            $data['concerts'][] = $row; //Menambahkan baris data konser ke array $data['concerts']
        }

        if (isset($_GET['id_edit'])) { //Mengecek apakah ada parameter id_edit pada URL untuk mode edit
            $this->concert->getConcertById($_GET['id_edit']); //Mengambil data konser berdasarkan id_edit
            $data['edit_data'] = $this->concert->getResult(); //Menyimpan data konser yang akan diedit ke $data['edit_data']
        }

        $this ->concert->close(); //Menutup koneksi database
        $view = new ConcertView(); //Membuat instance ConcertView
        $view->render($data); //Merender tampilan halaman konser dengan data yang sudah disiapkan
    }

    public function add($data){ //Menambahkan data jadwal konser baru
        $this->concert->open(); //Membuka koneksi database
        $this ->concert->add($data); //Menjalankan proses tambah data konser
        $this->concert->close(); //Menutup koneksi database
        header("location:concert.php"); //Mengalihkan kembali ke halaman concert.php
    }

    public function update($id, $data){ //Memperbarui data konser berdasarkan ID
        $this ->concert->open(); //Membuka koneksi database
        $this ->concert->update($id, $data); //Menjalankan proses update data konser
        $this ->concert->close(); //Menutup koneksi database
        header("location:concert.php"); //Mengalihkan kembali ke halaman concert.php
    }

    public function delete($id){ //Menghapus data konser berdasarkan ID
        $this ->concert->open(); //Membuka koneksi database
        $this ->concert->delete($id); //Menjalankan proses hapus data konser
        $this ->concert->close(); //Menutup koneksi database
        header("location:concert.php"); //Mengalihkan kembali ke halaman concert.php
    }

}