<?php

class Artist extends DB{ //Membuat class Artist yang mewarisi koneksi dan method dari class DB
	function getArtist(){ //Method untuk mengambil seluruh data artist dari database
		$query = "SELECT * FROM artist ORDER BY id DESC"; //Menyusun query SQL mengambil semua record artist diurutkan dari ID terbaru
		return $this -> execute($query); //Menjalankan query lewat method execute() milik DB dan mengembalikan hasilnya
	}

	function getArtistById($id){ //Method untuk mengambil satu data artist berdasarkan ID tertentu
		$query = "SELECT * FROM artist WHERE id = '$id'"; //Menyusun query SQL filter artist berdasarkan kolom id
		return $this->execute($query); //Menjalankan query dan mengembalikan hasil pencarian data artist
	}

	function add($data){ //Method untuk menambahkan data artist baru ke tabel artist
		$name = $data['name']; //Mengambil nilai nama artist dari array $data
		$country = $data['country']; //Mengambil nilai negara asal artist dari array $data
		$debut_year = $data['debut_year']; //Mengambil nilai tahun debut artist dari array $data
		$genre = $data['genre']; //Mengambil nilai genre musik artist dari array $data


		$query = "INSERT INTO artist (name, country, debut_year, genre)
		          VALUES  
		          ('$name', '$country', '$debut_year', '$genre')"; 
		return $this->execute($query); //Mengeksekusi query INSERT dan mengembalikan status/hasil eksekusi
	}

	function update($id, $data){ //Method untuk memperbarui data artist yang sudah ada berdasarkan ID
		$name = $data['name']; //Mengambil nilai nama artist terbaru dari array $data
		$country = $data['country']; //Mengambil nilai negara asal (perhatikan typo: seharusnya $data['country'], bukan $date)
		$debut_year = $data['debut_year']; //Mengambil nilai tahun debut terbaru dari array $data
		$genre = $data['genre']; //Mengambil nilai genre musik terbaru dari array $data

		$query = "UPDATE artist SET name='$name', country='$country', debut_year='$debut_year', genre='$genre' " //Menyusun query UPDATE kolom-kolom pada tabel artist
                  . "WHERE id='$id'"; //Menambahkan kondisi WHERE agar hanya record dengan id sesuai yang diubah
		return $this->execute($query); //Mengeksekusi query UPDATE dan mengembalikan hasilnya
	}

	function delete($id){ //Method untuk menghapus data artist berdasarkan ID
		$query = "DELETE FROM artist WHERE id ='$id'"; //Menyusun query DELETE untuk menghapus record artist sesuai ID
		return $this->execute($query); //Mengeksekusi query DELETE dan mengembalikan hasilnya
	} //Menutup method delete()
}