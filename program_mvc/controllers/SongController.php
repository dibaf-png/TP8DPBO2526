<?php

include_once("config.php"); //Memuat file konfigurasi database sekali saja
include_once("models/Song.php"); //Memuat model Song sekali saja
include_once("models/Artist.php"); //Memuat model Artist sekali saja
include_once("views/SongView.php"); //Memuat view SongView sekali saja

class SongController //Membuat class SongController untuk mengatur alur data lagu
{
    private $song; //Menyimpan instance model Song
    private $artist; //Menyimpan instance model Artist

    function __construct() //Konstruktor yang dijalankan saat controller diinstansiasi
    {
        $this->song = new Song(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name); //Membuat objek model Song dengan kredensial dari Config
        $this->artist = new Artist(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name); //Membuat objek model Artist dengan kredensial dari Config
    }

    public function index() //Menampilkan halaman utama daftar dan form lagu
    {
        $this->song->open(); //Membuka koneksi database untuk model Song
        $this->artist->open(); //Membuka koneksi database untuk model Artist

        $filterArtist = isset($_GET['filter_artist']) ? $_GET['filter_artist'] : ""; //Mengambil nilai filter artis dari parameter GET jika tersedia

        $this->song->getSong($filterArtist); //Mengambil data lagu sesuai filter artis
        $this->artist->getArtist(); //Mengambil seluruh data artis untuk pilihan form dan filter

        $data = array( //Menyiapkan struktur data untuk dikirim ke view
            'songs' => array(), //Inisialisasi array daftar lagu
            'artists' => array(), //Inisialisasi array daftar artis
            'edit_data' => null, //Inisialisasi data edit bernilai null secara default
            'filter_artist' => $filterArtist //Menyimpan nilai filter artis aktif untuk diteruskan ke view
        );

        while ($row = $this->song->getResult()) { //Melakukan iterasi setiap baris hasil query lagu
            $data['songs'][] = $row; //Menambahkan baris data lagu ke array $data['songs']
        }

        while ($row = $this->artist->getResult()) { //Melakukan iterasi setiap baris hasil query artis
            $data['artists'][] = $row; //Menambahkan baris data artis ke array $data['artists']
        }

        if (isset($_GET['id_edit'])) { //Mengecek apakah ada parameter id_edit pada URL untuk mode edit
            $this->song->getSongById($_GET['id_edit']); //Mengambil data lagu berdasarkan id_edit
            $data['edit_data'] = $this->song->getResult(); //Menyimpan data lagu yang akan diedit ke $data['edit_data']
        }

        $this->song->close(); //Menutup koneksi database model Song
        $this->artist->close(); //Menutup koneksi database model Artist

        $view = new SongView(); //Membuat instance SongView
        $view->render($data); //Merender tampilan halaman lagu dengan data yang sudah disiapkan
    }

    public function add($data) //Menambahkan data lagu baru
    {
        $this->song->open(); //Membuka koneksi database
        $this->song->add($data); //Menjalankan proses tambah data lagu
        $this->song->close(); //Menutup koneksi database
        header("location:index.php"); //Mengalihkan kembali ke halaman index.php
    }

    public function update($id, $data) //Memperbarui data lagu berdasarkan ID
    {
        $this->song->open(); //Membuka koneksi database
        $this->song->update($id, $data); //Menjalankan proses update data lagu
        $this->song->close(); //Menutup koneksi database
        header("location:index.php"); //Mengalihkan kembali ke halaman index.php
    }

    public function delete($id) //Menghapus data lagu berdasarkan ID
    {
        $this->song->open(); //Membuka koneksi database
        $this->song->delete($id); //Menjalankan proses hapus data lagu
        $this->song->close(); //Menutup koneksi database
        header("location:index.php"); //Mengalihkan kembali ke halaman index.php
    }
}