<?php

class ArtistView{ //Membuat class ArtistView untuk merender tampilan halaman data artist
    public function render($data){ //Method render menerima array $data yang dikirim dari controller
        $nomor = 1; //Menginisialisasi nomor urut baris tabel yang dimulai dari 1
        $dataArtists = ""; //Menyiapkan variabel string kosong untuk menampung baris HTML (<tr>) data artist

        foreach ($data['artist'] as $val) { //Melakukan perulangan untuk setiap record artist pada $data['artist']
            $dataArtists .= //Menggabungkan string baris <tr> baru ke variabel $dataArtists
            "<tr>"
                . "<td>" . $nomor++ . "</td>" //Menampilkan nomor urut lalu menaikkan nilainya (post-increment)
                . "<td>" . htmlspecialchars($val['name']) . "</td>" //Menampilkan nama artist dengan escape karakter HTML agar aman dari XSS
                . "<td>" . htmlspecialchars($val['country']) . "</td>" //Menampilkan negara asal artist dengan htmlspecialchars()
                . "<td>" . $val['debut_year'] . "</td>" //Menampilkan tahun debut artist
                . "<td>" . htmlspecialchars($val['genre']) . "</td>" //Menampilkan genre musik artist dengan htmlspecialchars()
                . "<td>"
                    . "<!-- Tombol Edit mengarahkan ke artist.php dengan parameter id_edit -->" 
                    . "<a href='artist.php?id_edit=" . $val['id'] . "' class='btn btn-warning btn-sm'>Edit</a>" 
                    . "<!-- Tombol Hapus memunculkan dialog konfirmasi sebelum menghapus -->" 
                    . "<a href='artist.php?id_hapus=" . $val['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus artis ini?\")'>Hapus</a>" 
                . "</td>" 
            . "</tr>"; 
        }

        $edit = $data['edit_data']; //Mengambil data artist yang sedang diedit (jika ada), atau null jika mode tambah data
        $tpl = new Template("templates/artist.html"); //Membuat objek Template dengan memuat file HTML di templates/artist.html

        $tpl->replace("DATA_TABEL", $dataArtists); //Mengganti placeholder DATA_TABEL di template dengan baris tabel artist
        $tpl->replace("DATA_FORM_ACTION", $edit ? "artist.php?id_update=" . $edit['id'] : "artist.php"); //Mengatur action form ke URL update jika mode edit, atau artist.php jika mode tambah
        $tpl->replace("DATA_SUBMIT_NAME", $edit ? "update" : "add"); //Mengatur atribut name tombol submit menjadi 'update' atau 'add'
        $tpl->replace("DATA_SUBMIT_TEXT", $edit ? "Update Artis" : "Tambah Artis"); //Mengatur teks tombol submit sesuai mode edit atau tambah
        $tpl->replace("DATA_NAME", $edit ? htmlspecialchars($edit['name']) : ""); //Mengisi nilai input nama saat mode edit, atau kosong saat mode tambah
        $tpl->replace("DATA_COUNTRY", $edit ? htmlspecialchars($edit['country']) : ""); //Mengisi nilai input negara saat mode edit, atau kosong saat mode tambah
        $tpl->replace("DATA_DEBUT", $edit ? $edit['debut_year'] : ""); //Mengisi nilai input tahun debut saat mode edit, atau kosong saat mode tambah
        $tpl->replace("DATA_GENRE", $edit ? htmlspecialchars($edit['genre']) : ""); //Mengisi nilai input genre saat mode edit, atau kosong saat mode tambah

        $tpl->write(); //Mencetak hasil akhir template HTML yang sudah diganti placeholder-nya ke browser
    } 

} 