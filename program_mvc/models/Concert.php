<?php

class Concert extends DB{ //Membuat class Concert yang mewarisi koneksi dan method dari class DB
	function getConcert(){ //Method untuk mengambil seluruh data jadwal konser dari database
		$query = "SELECT * FROM concert ORDER BY id DESC"; //Menyusun query SQL mengambil semua record konser diurutkan dari ID terbaru
		return $this->execute($query); //Menjalankan query lewat method execute() milik DB dan mengembalikan hasilnya
	}

	function getConcertById($id){ //Method untuk mengambil satu data konser berdasarkan ID tertentu
		$query = "SELECT * FROM concert WHERE id = '$id'"; //Menyusun query SQL filter konser berdasarkan kolom id
		return $this->execute($query); //Menjalankan query dan mengembalikan hasil pencarian data konser
	}

	function add($data){ //Method untuk menambahkan data jadwal konser baru ke tabel concert
		$tour_name = $data['tour_name']; //Mengambil nilai nama tur atau konser dari array $data
		$city = $data['city']; //Mengambil nilai nama kota konser dari array $data
		$venue = $data['venue']; //Mengambil nilai lokasi atau venue konser dari array $data
		$concert_date = $data['concert_date']; //Mengambil nilai tanggal konser dari array $data

		$query = "INSERT INTO concert (tour_name, city, venue, concert_date) " //Menyusun bagian awal query INSERT ke tabel concert
                  . "VALUES " //Menambahkan kata kunci VALUES pada query INSERT
                  . "('$tour_name', '$city', '$venue', '$concert_date')"; //Menggabungkan nilai parameter ke dalam klausa VALUES

        return $this->execute($query); //Mengeksekusi query INSERT dan mengembalikan status/hasil eksekusi
	}

	function update($id, $data){ //Method untuk memperbarui data konser yang sudah ada berdasarkan ID
		$tour_name = $data['tour_name']; //Mengambil nilai nama tur atau konser terbaru dari array $data
		$city = $data['city']; //Mengambil nilai nama kota terbaru dari array $data
		$venue = $data['venue']; //Mengambil nilai lokasi atau venue terbaru dari array $data
		$concert_date = $data['concert_date']; //Mengambil nilai tanggal konser terbaru dari array $data

		$query = "UPDATE concert SET tour_name='$tour_name', city='$city', venue='$venue', concert_date='$concert_date' " //Menyusun query UPDATE kolom-kolom pada tabel concert
                  . "WHERE id='$id'"; //Menambahkan kondisi WHERE agar hanya record dengan id sesuai yang diubah
        return $this->execute($query); //Mengeksekusi query UPDATE dan mengembalikan hasilnya
	}

	function delete($id){ //Method untuk menghapus data konser berdasarkan ID
		$query = "DELETE FROM concert WHERE id = '$id'"; //Menyusun query DELETE untuk menghapus record konser sesuai ID
		return $this->execute($query); //Mengeksekusi query DELETE dan mengembalikan hasilnya
	} 
} 