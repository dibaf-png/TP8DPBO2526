<?php

class Song extends DB{ //Membuat class Song yang mewarisi koneksi dan method dari class DB
    public function getSong($artist_id = ""){ //Method untuk mengambil data lagu beserta detail artis
        $where = ""; //Menyiapkan klausa WHERE kosong secara default
        if (!empty($artist_id)){ //Mengecek apakah parameter filter $artist_id diisi
            $where = "WHERE song.artist_id = '$artist_id'"; //Menyusun klausa WHERE berdasarkan ID artis
        }

        //Query ini bertujuan untuk mengambil data lagu lengkap dengan informasi artis secara terurut
        $query = "SELECT song.*, artist.name AS artist_name, artist.country, artist.genre
                  FROM song
                  JOIN artist ON song.artist_id = artist.id
                  $where
                  ORDER BY artist.name ASC, song.id DESC"; //Mengelompokkan berdasarkan nama artis (A-Z), lalu mengurutkan lagu dari ID terbaru (paling atas)
        return $this->execute($query); //Menjalankan query dan mengembalikan hasilnya
    }

    public function getSongById($id){ //Method untuk mengambil satu data lagu berdasarkan ID
    
        $query = "SELECT * FROM song WHERE id = '$id'"; //Menyusun query filter lagu berdasarkan id
        return $this->execute($query); //Menjalankan query dan mengembalikan hasilnya
    }

    public function add($data){ //Method untuk menambahkan data lagu baru
        $artist_id = $data['artist_id']; //Mengambil ID artis dari $data
        $title = $data['title']; //Mengambil judul lagu dari $data
        $release_year = $data['release_year']; //Mengambil tahun rilis lagu dari $data

        //Menyusun query INSERT data lagu baru
        $query = "INSERT INTO song (artist_id, title, release_year) 
                  VALUES ('$artist_id', '$title', '$release_year')"; 
        return $this->execute($query); //Menjalankan query INSERT dan mengembalikan hasilnya
    }

    public function update($id, $data) { //Method untuk memperbarui data lagu berdasarkan ID
        $artist_id = $data['artist_id']; //Mengambil ID artis terbaru dari $data
        $title = $data['title']; //Mengambil judul lagu terbaru dari $data
        $release_year = $data['release_year']; //Mengambil tahun rilis terbaru dari $data

        //Menyusun query UPDATE data lagu sesuai ID
        $query = "UPDATE song SET 
                  artist_id = '$artist_id', 
                  title = '$title', 
                  release_year = '$release_year' 
                  WHERE id = '$id'"; 
        return $this->execute($query); //Menjalankan query UPDATE dan mengembalikan hasilnya
    }

    public function delete($id){ //Method untuk menghapus data lagu berdasarkan ID
        $query = "DELETE FROM song WHERE id = '$id'"; //Menyusun query DELETE data lagu sesuai ID
        return $this->execute($query); //Menjalankan query DELETE dan mengembalikan hasilnya
    }
}