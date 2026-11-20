<?php

class SongView{ //Membuat class SongView untuk merender tampilan data lagu
    public function render($data){ //Method render menerima array $data yang dikirim dari controller
        $nomor = 1; //Menginisialisasi nomor urut lagu dalam tiap grup artis mulai dari 1
        $dataSongs = ""; //Menyiapkan variabel string kosong untuk menampung baris HTML tabel lagu
        $currentArtistId = null; //Menyimpan ID artis aktif untuk mendeteksi pergantian grup artis

        foreach ($data['songs'] as $val){ //Melakukan perulangan untuk setiap record lagu pada $data['songs']
            if ($currentArtistId !== $val['artist_id']){ //Mengecek apakah artis pada baris ini berbeda dari artis sebelumnya
                $currentArtistId = $val['artist_id']; //Memperbarui penanda ID artis aktif ke artis saat ini
                $nomor = 1; //Mereset nomor urut kembali ke 1 untuk grup artis baru
                $dataSongs .= //Menggabungkan baris header grup artis ke variabel $dataSongs
                "<tr class='table-primary'>" //Membuka baris header grup artis dengan kelas Bootstrap table-primary
                    . "<td colspan='5'>" //Membuka sel header yang membentang di 5 kolom tabel
                        . "<strong>" . htmlspecialchars($val['artist_name']) . "</strong>" //Menampilkan nama artis dengan escape HTML agar aman dari XSS
                        . "<span class='badge bg-dark ms-2'>" . htmlspecialchars($val['country']) . " • " . htmlspecialchars($val['genre']) . "</span>" //Menampilkan badge negara dan genre artis secara aman
                    . "</td>" 
                . "</tr>"; 
            } 

            $dataSongs .= //Menggabungkan baris data lagu ke variabel $dataSongs
            "<tr>"
                . "<td>" . $nomor++ . "</td>" //Menampilkan nomor urut lalu menaikkan nilainya (post-increment)
                . "<td><small class='text-muted'>" . htmlspecialchars($val['artist_name']) . "</small></td>" //Menampilkan nama artis berukuran kecil dengan escape HTML
                . "<td><strong>" . htmlspecialchars($val['title']) . "</strong></td>" //Menampilkan judul lagu dengan huruf tebal dan escape HTML
                . "<td><span class='badge bg-secondary'>" . htmlspecialchars($val['release_year']) . "</span></td>" //Menampilkan tahun rilis lagu di dalam badge
                . "<td>"
                    . "<a href='index.php?id_edit=" . $val['id'] . "' class='btn btn-warning btn-sm'>Edit</a>" 
                    . "<!-- Tombol Hapus memunculkan dialog konfirmasi sebelum menghapus -->" 
                    . "<a href='index.php?id_hapus=" . $val['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus lagu ini?\")'>Hapus</a>" 
                . "</td>"
            . "</tr>"; 
        }

        //Dropdown Artis untuk Form Input/Edit
        $edit = $data['edit_data']; //Mengambil data lagu yang sedang diedit jika ada, atau null jika mode tambah
        $optionArtists = "<option value=''>-- Pilih Artis --</option>"; //Menginisialisasi opsi default dropdown artis pada form
        foreach ($data['artists'] as $art){ //Melakukan iterasi daftar artis untuk opsi form input/edit
            $selected = ($edit && $edit['artist_id'] == $art['id']) ? "selected" : ""; //Menandai opsi terpilih jika sedang mengedit lagu milik artis tersebut
            $optionArtists .= "<option value='" . $art['id'] . "' $selected>" . htmlspecialchars($art['name']) . "</option>"; //Menambahkan tag <option> artis dengan nama yang di-escape
        }

        //Dropdown Artis untuk Filter Tabel
        $filterVal = isset($data['filter_artist']) ? $data['filter_artist'] : ""; //Mengambil nilai filter artis aktif jika tersedia, atau string kosong
        $filterArtists = "<option value=''>-- Tampilkan Semua Artis --</option>"; //Menginisialisasi opsi default dropdown filter tabel
        foreach ($data['artists'] as $art){ //Melakukan iterasi daftar artis untuk opsi filter
            $selected = ($filterVal == $art['id']) ? "selected" : ""; //Menandai opsi filter aktif sesuai ID artis yang dipilih pengguna
            $filterArtists .= "<option value='" . $art['id'] . "' $selected>" . htmlspecialchars($art['name']) . "</option>"; //Menambahkan tag <option> filter artis dengan nama yang aman
        }

        $tpl = new Template("templates/index.html"); //Membuat instance Template dengan memuat file templates/index.html

        $tpl->replace("DATA_TABEL", $dataSongs); //Mengganti placeholder DATA_TABEL dengan seluruh baris tabel lagu
        $tpl->replace("DATA_FILTER_ARTIST", $filterArtists); //Mengganti placeholder DATA_FILTER_ARTIST dengan opsi dropdown filter
        $tpl->replace("DATA_OPTION_ARTIST", $optionArtists); //Mengganti placeholder DATA_OPTION_ARTIST dengan opsi dropdown form
        $tpl->replace("DATA_FORM_ACTION", $edit ? "index.php?id_update=" . $edit['id'] : "index.php"); //Mengatur action form ke URL update saat edit, atau index.php saat tambah
        $tpl->replace("DATA_SUBMIT_NAME", $edit ? "update" : "add"); //Mengatur atribut name tombol submit menjadi 'update' atau 'add'
        $tpl->replace("DATA_SUBMIT_TEXT", $edit ? "Update Lagu" : "Tambah Lagu"); //Mengatur label tombol submit sesuai mode edit atau tambah
        $tpl->replace("DATA_TITLE", $edit ? htmlspecialchars($edit['title']) : ""); //Mengisi nilai awal input judul saat edit, atau kosong saat tambah
        $tpl->replace("DATA_YEAR", $edit ? htmlspecialchars($edit['release_year']) : ""); //Mengisi nilai awal input tahun rilis saat edit, atau kosong saat tambah

        $tpl->write(); //Mencetak hasil akhir template HTML ke browser
    }
}