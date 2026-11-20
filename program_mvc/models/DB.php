<?php

class DB{ //Class ini sebagai parent yang menangani semua operasi dasar pada database
	var $db_host = ""; //Digunakan untuk menyimpan alamat host
	var $db_user = ""; //Digunakan untuk menyimpan username
	var $db_pass = ""; //Digunakan untuk menyimpan password
	var $db_name = ""; //Digunakan untuk menyimpan nama database
	var $db_link = ""; //Digunakan untuk menyimpan koneksi aktif MySQL
	var $result = 0; //Digunakan untuk menyimpan hasil eksekusi query

	function __construct($db_host, $db_user, $db_pass, $db_name){ //Konstruktor yang akan otomatis berjalan saat objek model dibuat
		$this->db_host = $db_host; //Mengisi properti db_host
		$this->db_user = $db_user; //Mengisi properti db_user
		$this->db_pass = $db_pass; //Mengisi properti db_pass
		$this->db_name = $db_name; //Mengisi properti db_name
	}

	function open(){ //Digunakan untuk membuka jalur koneksi ke server database
		$this->db_link = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name); //Membuka koneksi ke database MySQL menggunakan mysqli_connect()
	}

	function execute($query){ //Digunakan untuk menjalankan perintah SQL seperti SELECT, INSERT, dll. ke database
		$this->result = mysqli_query($this->db_link, $query); //Menyimpan hasil eksekusi ke $this->result
		return $this->result; //Mengembalikan hasil query
	}

	function getResult(){ //Digunakan untuk mengambil satu baris data dari hasil query SELECT dalam bentuk array
		return mysqli_fetch_array($this->result); //Mengambil baris berikutnya dari $this->result sebagai array asosiatif/numerik
	}

	function close(){ //Digunakan untuk menutup koneksi database setelah selesai digunakan
		mysqli_close($this->db_link); //Menutup koneksi aktif MySQLi pada $this->db_link
	}
	
}