<?php

include ("config.php"); //Memuat file konfigurasi database sekali saja
include ("models/Artist.php"); //Memuat model Artist sekali saja
include ("views/ArtistView.php"); //Memuat view ArtistView sekali saja

class ArtistController{ //Membuat class ArtistController untuk mengatur alur data artis
	private $artist; //Menyimpan instance model Artist

	function __construct(){ //Konstruktor yang dijalankan saat controller diinstansiasi
		$this->artist = new Artist(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name); //Membuat objek model Artist dengan kredensial dari Config
	}

	public function index(){ //Menampilkan halaman utama daftar dan form artis
		$this ->artist->open(); //Membuka koneksi database
		$this->artist ->getArtist(); //Mengambil seluruh data artis

		$data = array( //Menyiapkan struktur data untuk dikirim ke view
			'artist' => array(), 'edit_data' => null); //Inisialisasi daftar artis kosong dan edit_data null

		while($row = $this->artist->getResult()){ //Melakukan iterasi setiap baris hasil query artis
			$data['artist'][] = $row; //Menambahkan baris data artis ke array $data['artist']
		}

		if(isset($_GET['id_edit'])){ //Mengecek apakah ada parameter id_edit pada URL untuk mode edit
			$this->artist->getArtistById($_GET['id_edit']); //Mengambil data artis berdasarkan id_edit
			$data['edit_data'] = $this->artist->getResult(); //Menyimpan data artis yang akan diedit ke $data['edit_data']
		}

		$this->artist->close(); //Menutup koneksi database

		$view = new ArtistView(); //Membuat instance ArtistView
		$view->render($data); //Merender tampilan halaman artis dengan data yang sudah disiapkan
	}

	public function add($data){ //Menambahkan data artis baru
		$this ->artist->open(); //Membuka koneksi database
		$this ->artist->add($data); //Menjalankan proses tambah data artis
		$this ->artist->close(); //Menutup koneksi database
		header("location:artist.php"); //Mengalihkan kembali ke halaman artist.php
	}

	public function update($id, $data){ //Memperbarui data artis berdasarkan ID
		$this ->artist->open(); //Membuka koneksi database
		$this ->artist->update($id, $data); //Menjalankan proses update data artis
		$this->artist->close(); //Menutup koneksi database
		header("location:artist.php"); //Mengalihkan kembali ke halaman artist.php
	}

	public function delete($id){ //Menghapus data artis berdasarkan ID
		$this->artist->open(); //Membuka koneksi database
		$this ->artist->delete($id); //Menjalankan proses hapus data artis
		$this->artist->close(); //Menutup koneksi database
		header("location:artist.php"); //Mengalihkan kembali ke halaman artist.php
	}

}