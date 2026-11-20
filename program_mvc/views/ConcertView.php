<?php

class ConcertView{ //Membuat class ConcertView untuk merender tampilan data konser
    public function render($data){ //Method render menerima array $data dari controller
        $nomor = 1; //Menginisialisasi nomor urut baris tabel mulai dari 1
        $dataConcerts= ""; //Menyiapkan string kosong untuk menampung baris HTML (<tr>) konser

        foreach ($data['concerts'] as $val) { //Melakukan iterasi untuk setiap data konser pada $data['concerts']
            $dataConcerts .= //Menggabungkan string baris <tr> baru ke variabel $dataConcert
            "<tr>" 
                . "<td>" . $nomor++ . "</td>" //Menampilkan nomor urut lalu menaikkan nilainya (post-increment)
                . "<td>" . htmlspecialchars($val['tour_name']) . "</td>" //Menampilkan nama tur dengan escape karakter HTML agar aman dari XSS
                . "<td>" . htmlspecialchars($val['city']) . "</td>" //Menampilkan kota konser dengan htmlspecialchars()
                . "<td>" . htmlspecialchars($val['venue']) . "</td>" //Menampilkan lokasi/venue konser dengan htmlspecialchars()
                . "<td>" . $val['concert_date'] . "</td>" //Menampilkan tanggal konser
                . "<td>"
                    . "<!-- Tombol Edit mengarahkan ke concert.php dengan parameter id_edit -->"
                    . "<a href='concert.php?id_edit=" . $val['id'] . "' class='btn btn-warning btn-sm'>Edit</a>" 
                    . "<!-- Tombol Hapus memunculkan dialog konfirmasi sebelum menghapus -->"
                    . "<a href='concert.php?id_hapus=" . $val['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus jadwal konser ini?\")'>Hapus</a>"
                . "</td>"
            . "</tr>"; 
        }

        $edit = $data['edit_data']; //Mengambil data konser yang akan diedit jika ada, atau null jika mode tambah data
        $tpl = new Template("templates/concert.html"); //Membuat instance Template dengan memuat file templates/concert.html

        $tpl->replace("DATA_TABEL", $dataConcerts); //Mengganti placeholder DATA_TABEL dengan baris tabel konser
        $tpl->replace("DATA_FORM_ACTION", $edit ? "concert.php?id_update=" . $edit['id'] : "concert.php"); //Mengatur action form ke URL update jika mode edit, atau concert.php jika mode tambah
        $tpl->replace("DATA_SUBMIT_NAME", $edit ? "update" : "add"); //Mengatur atribut name tombol submit menjadi 'update' atau 'add'
        $tpl->replace("DATA_SUBMIT_TEXT", $edit ? "Update Konser" : "Tambah Konser"); //Mengatur teks tombol submit sesuai mode edit atau tambah
        $tpl->replace("DATA_TOUR", $edit ? htmlspecialchars($edit['tour_name']) : ""); //Mengisi nilai input nama tur saat mode edit, atau kosong saat mode tambah
        $tpl->replace("DATA_CITY", $edit ? htmlspecialchars($edit['city']) : ""); //Mengisi nilai input kota saat mode edit, atau kosong saat mode tambah
        $tpl->replace("DATA_VENUE", $edit ? htmlspecialchars($edit['venue']) : ""); //Mengisi nilai input venue saat mode edit, atau kosong saat mode tambah
        $tpl->replace("DATA_DATE", $edit ? $edit['concert_date'] : ""); //Mengisi nilai input tanggal konser saat mode edit, atau kosong saat mode tambah

        $tpl->write(); //Mencetak hasil akhir template HTML yang sudah diisi placeholder-nya ke browser

        
    } 
}