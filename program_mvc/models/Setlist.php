<?php

class Setlist extends DB{ //Membuat class Setlist yang mewarisi koneksi dan method dari class DB
    public function getSetlist($concert_id = ""){ //Method untuk mengambil data setlist beserta detail konser, lagu, dan artis
        $where = ""; //Menyiapkan klausa WHERE kosong secara default
        if (!empty($concert_id)) { //Mengecek apakah parameter filter $concert_id diisi
            $where = "WHERE setlist.concert_id = '$concert_id'"; //Menyusun klausa WHERE berdasarkan ID konser
        }

        ////Query ini bertujuan untuk mengambil data setlist lengkap dengan detail konser, judul lagu, dan nama artis secara terurut
        $query = "SELECT setlist.*, concert.tour_name, concert.city, concert.concert_date, 
                         song.title AS song_title, artist.name AS artist_name 
                  FROM setlist
                  JOIN concert ON setlist.concert_id = concert.id
                  JOIN song ON setlist.song_id = song.id
                  JOIN artist ON song.artist_id = artist.id
                  $where
                  ORDER BY concert.concert_date ASC, concert.id DESC, setlist.song_order ASC"; 
        return $this->execute($query); //Menjalankan query dan mengembalikan hasilnya
    }

    public function getSetlistById($id){ //Method untuk mengambil satu data setlist berdasarkan ID
        $query = "SELECT * FROM setlist WHERE id = '$id'"; //Menyusun query filter setlist berdasarkan id
        return $this->execute($query); //Menjalankan query dan mengembalikan hasilnya
    }

    public function add($data){ //Method untuk menambahkan data lagu ke setlist
        $concert_id = $data['concert_id']; //Mengambil ID konser dari $data
        $song_id = $data['song_id']; //Mengambil ID lagu dari $data
        $song_order = $data['song_order']; //Mengambil urutan lagu dari $data
        $status = $data['status']; //Mengambil status pelaksanaan lagu dari $data

        $query = "INSERT INTO setlist (concert_id, song_id, song_order, status) 
                  VALUES ('$concert_id', '$song_id', '$song_order', '$status')"; //Menyusun query INSERT data setlist baru
        return $this->execute($query); //Menjalankan query INSERT dan mengembalikan hasilnya
    }

    public function update($id, $data){ //Method untuk memperbarui data setlist berdasarkan ID
        $concert_id = $data['concert_id']; //Mengambil ID konser terbaru dari $data
        $song_id = $data['song_id']; //Mengambil ID lagu terbaru dari $data
        $song_order = $data['song_order']; //Mengambil urutan lagu terbaru dari $data
        $status = $data['status']; //Mengambil status terbaru dari $data

        $query = "UPDATE setlist SET 
                  concert_id = '$concert_id', 
                  song_id = '$song_id', 
                  song_order = '$song_order', 
                  status = '$status' 
                  WHERE id = '$id'"; //Menyusun query UPDATE data setlist sesuai ID
        return $this->execute($query); //Menjalankan query UPDATE dan mengembalikan hasilnya
    }

    public function delete($id){ //Method untuk menghapus data setlist berdasarkan ID
        $query = "DELETE FROM setlist WHERE id = '$id'"; //Menyusun query DELETE data setlist sesuai ID
        return $this->execute($query); //Menjalankan query DELETE dan mengembalikan hasilnya
    }
}