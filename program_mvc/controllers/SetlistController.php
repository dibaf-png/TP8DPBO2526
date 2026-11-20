<?php

include_once("config.php"); //Memuat file konfigurasi database sekali saja
include_once("models/Setlist.php"); //Memuat model Setlist sekali saja
include_once("models/Concert.php"); //Memuat model Concert sekali saja
include_once("models/Song.php"); //Memuat model Song sekali saja
include_once("views/SetlistView.php"); //Memuat view SetlistView sekali saja

class SetlistController //Membuat class SetlistController untuk mengatur alur data setlist konser
{
    private $setList; //Menyimpan instance model Setlist
    private $song; //Menyimpan instance model Song
    private $concert; //Menyimpan instance model Concert

    function __construct() //Konstruktor yang dijalankan saat controller diinstansiasi
    {
        $this->setList = new Setlist(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name); //Membuat objek model Setlist dengan kredensial dari Config
        $this->concert = new Concert(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name); //Membuat objek model Concert dengan kredensial dari Config
        $this->song = new Song(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name); //Membuat objek model Song dengan kredensial dari Config
    }

    public function index() //Menampilkan halaman utama susunan dan form setlist konser
    {
        $this->setList->open(); //Membuka koneksi database untuk model Setlist
        $this->song->open(); //Membuka koneksi database untuk model Song
        $this->concert->open(); //Membuka koneksi database untuk model Concert

        $filterConcert = isset($_GET['filter_concert']) ? $_GET['filter_concert'] : ""; //Mengambil nilai filter konser dari parameter GET jika tersedia

        $this->setList->getSetlist($filterConcert); //Mengambil data setlist sesuai filter konser
        $this->song->getSong(); //Mengambil seluruh data lagu untuk pilihan form
        $this->concert->getConcert(); //Mengambil seluruh data konser untuk pilihan form dan filter

        $data = array( //Menyiapkan struktur data untuk dikirim ke view
            'setList' => array(), //Inisialisasi array daftar item setlist
            'songs' => array(), //Inisialisasi array daftar lagu
            'concert' => array(), //Inisialisasi array daftar konser
            'edit_data' => null, //Inisialisasi data edit bernilai null secara default
            'filter_concert' => $filterConcert //Menyimpan nilai filter konser aktif untuk diteruskan ke view
        );

        while ($row = $this->setList->getResult()) { //Melakukan iterasi setiap baris hasil query setlist
            $data['setList'][] = $row; //Menambahkan baris data setlist ke array $data['setList']
        }

        while ($row = $this->concert->getResult()) { //Melakukan iterasi setiap baris hasil query konser
            $data['concert'][] = $row; //Menambahkan baris data konser ke array $data['concert']
        }

        while ($row = $this->song->getResult()) { //Melakukan iterasi setiap baris hasil query lagu
            $data['songs'][] = $row; //Menambahkan baris data lagu ke array $data['songs']
        }

        if (isset($_GET['id_edit'])) { //Mengecek apakah ada parameter id_edit pada URL untuk mode edit
            $this->setList->getSetlistById($_GET['id_edit']); //Mengambil data setlist berdasarkan id_edit
            $data['edit_data'] = $this->setList->getResult(); //Menyimpan data setlist yang akan diedit ke $data['edit_data']
        }

        $this->setList->close(); //Menutup koneksi database model Setlist
        $this->song->close(); //Menutup koneksi database model Song
        $this->concert->close(); //Menutup koneksi database model Concert

        $view = new SetlistView(); //Membuat instance SetlistView
        $view->render($data); //Merender tampilan halaman setlist dengan data yang sudah disiapkan
    }

    public function add($data) //Menambahkan item lagu baru ke setlist konser
    {
        $this->setList->open(); //Membuka koneksi database
        $this->setList->add($data); //Menjalankan proses tambah data setlist
        $this->setList->close(); //Menutup koneksi database
        header("location:setlist.php"); //Mengalihkan kembali ke halaman setlist.php
    }

    public function update($id, $data) //Memperbarui data item setlist berdasarkan ID
    {
        $this->setList->open(); //Membuka koneksi database
        $this->setList->update($id, $data); //Menjalankan proses update data setlist
        $this->setList->close(); //Menutup koneksi database
        header("location:setlist.php"); //Mengalihkan kembali ke halaman setlist.php
    }

    public function delete($id) //Menghapus item lagu dari setlist berdasarkan ID
    {
        $this->setList->open(); //Membuka koneksi database
        $this->setList->delete($id); //Menjalankan proses hapus data setlist
        $this->setList->close(); //Menutup koneksi database
        header("location:setlist.php"); //Mengalihkan kembali ke halaman setlist.php
    }
}