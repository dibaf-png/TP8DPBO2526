<?php

class SetlistView{ //Membuat class SetlistView untuk merender tampilan data setlist konser
    public function render($data){ //Method render menerima array $data yang dikirim dari controller
        $nomor = 1; //Menginisialisasi nomor urut lagu dalam tiap grup konser mulai dari 1
        $dataSetLists = ""; //Menyiapkan variabel string kosong untuk menampung baris HTML tabel setlist
        $currentConcertId = null; //Menyimpan ID konser aktif untuk mendeteksi pergantian acara konser

        foreach ($data['setList'] as $val){ //Melakukan perulangan untuk setiap item setlist pada $data['setList']
            //Pemisah otomatis setiap berganti acara konser
            if ($currentConcertId !== $val['concert_id']){ //Mengecek apakah konser pada baris ini berbeda dari konser sebelumnya
                $currentConcertId = $val['concert_id']; //Memperbarui penanda ID konser aktif ke konser saat ini
                $nomor = 1; //Mereset nomor urut kembali ke 1 untuk grup konser baru
                $dataSetLists .= //Menggabungkan baris header grup konser ke variabel $dataSetLists
                "<tr class='table-primary'>" //Membuka baris header grup konser dengan kelas Bootstrap table-primary
                    . "<td colspan='7'>" //Membuka sel header yang membentang di 7 kolom tabel
                        . "<strong>" . htmlspecialchars($val['tour_name']) . " — " . htmlspecialchars($val['city']) . "</strong>" //Menampilkan nama tur dan kota konser dengan escape HTML agar aman dari XSS
                        . "<span class='badge bg-dark ms-2'>" . htmlspecialchars($val['concert_date']) . "</span>" //Menampilkan badge gelap berisi tanggal konser secara aman
                    . "</td>" 
                . "</tr>";
            }

            $badgeColor = "bg-secondary"; //Menetapkan warna badge default abu-abu jika status tidak cocok dengan kondisi khusus
            if ($val['status'] == "Now Playing"){ //Mengecek apakah status lagu sedang diputar saat ini
                $badgeColor = "bg-success"; //Mengubah warna badge menjadi hijau untuk status Now Playing
            } elseif ($val['status'] == "Upcoming"){ //Mengecek apakah status lagu akan segera dimainkan
                $badgeColor = "bg-primary"; //Mengubah warna badge menjadi biru untuk status Upcoming
            } elseif ($val['status'] == "Skipped"){ //Mengecek apakah status lagu dilewati
                $badgeColor = "bg-danger"; //Mengubah warna badge menjadi merah untuk status Skipped
            } //Menutup percabangan penentuan warna badge status

            $dataSetLists .= //Menggabungkan baris data lagu dalam setlist ke variabel $dataSetLists
            "<tr>" //Membuka baris tabel untuk satu item lagu di setlist
                . "<td>" . $nomor++ . "</td>" //Menampilkan nomor urut lalu menaikkan nilainya (post-increment)
                . "<td><small class='text-muted'>" . htmlspecialchars($val['tour_name']) . "</small></td>" //Menampilkan nama tur berukuran kecil dengan escape HTML
                . "<td><span class='badge bg-dark'>#" . htmlspecialchars($val['song_order']) . "</span></td>" //Menampilkan nomor urutan lagu pada setlist di dalam badge gelap
                . "<td>" . htmlspecialchars($val['song_title']) . "</td>" //Menampilkan judul lagu dengan escape HTML
                . "<td>" . htmlspecialchars($val['artist_name']) . "</td>" //Menampilkan nama artis pembawa lagu dengan escape HTML
                . "<td><span class='badge $badgeColor'>" . htmlspecialchars($val['status']) . "</span></td>" //Menampilkan badge status lagu sesuai warna yang sudah ditentukan
                . "<td>" //Membuka kolom tombol aksi pada baris tabel
                    . "<a href='setlist.php?id_edit=" . $val['id'] . "' class='btn btn-warning btn-sm'>Edit</a>"
                    . "<!-- Tombol Hapus memunculkan dialog konfirmasi sebelum menghapus -->" 
                    . "<a href='setlist.php?id_hapus=" . $val['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus lagu dari setlist ini?\")'>Hapus</a>" 
                . "</td>"
            . "</tr>"; 
        }

        //Dropdown untuk Form Input/Edit
        $edit = $data['edit_data']; //Mengambil data setlist yang sedang diedit jika ada, atau null jika mode tambah
        $optionConcerts = "<option value=''>-- Pilih Acara Konser --</option>"; //Menginisialisasi opsi default dropdown konser pada form
        foreach ($data['concert'] as $con){ //Melakukan iterasi daftar konser untuk opsi form input/edit
            $selected = ($edit && $edit['concert_id'] == $con['id']) ? "selected" : ""; //Menandai opsi konser terpilih jika sedang mengedit data setlist tersebut
            $optionConcerts .= "<option value='" . $con['id'] . "' $selected>" . htmlspecialchars($con['tour_name']) . " - " . htmlspecialchars($con['city']) . "</option>"; //Menambahkan tag <option> konser dengan nama tur dan kota yang aman
        }

        //Dropdown untuk Filter Tabel
        $filterVal = isset($data['filter_concert']) ? $data['filter_concert'] : ""; //Mengambil nilai filter konser aktif jika tersedia, atau string kosong
        $filterConcerts = "<option value=''>-- Tampilkan Semua Konser --</option>"; //Menginisialisasi opsi default dropdown filter tabel konser
        foreach ($data['concert'] as $con){ //Melakukan iterasi daftar konser untuk opsi filter tabel
            $selected = ($filterVal == $con['id']) ? "selected" : ""; //Menandai opsi filter konser aktif sesuai ID yang dipilih pengguna
            $filterConcerts .= "<option value='" . $con['id'] . "' $selected>" . htmlspecialchars($con['tour_name']) . " - " . htmlspecialchars($con['city']) . "</option>"; //Menambahkan tag <option> filter konser dengan nama tur dan kota yang aman
        } 

        $optionSongs = "<option value=''>-- Pilih Lagu --</option>"; //Menginisialisasi opsi default dropdown lagu pada form
        foreach ($data['songs'] as $sng){ //Melakukan iterasi daftar lagu untuk opsi form input/edit
            $selected = ($edit && $edit['song_id'] == $sng['id']) ? "selected" : ""; //Menandai opsi lagu terpilih jika sedang mengedit lagu tersebut pada setlist
            $optionSongs .= "<option value='" . $sng['id'] . "' $selected>" . htmlspecialchars($sng['title']) . " (" . htmlspecialchars($sng['artist_name']) . ")</option>"; //Menambahkan tag <option> lagu beserta nama artis yang di-escape
        }

        $statusList = ["Upcoming", "Now Playing", "Played", "Skipped"]; //Menyimpan daftar pilihan status lagu yang tersedia pada setlist
        $optionStatus = ""; //Menyiapkan variabel string kosong untuk menampung opsi <option> status
        foreach ($statusList as $st){ //Melakukan iterasi setiap status pada $statusList
            $selected = ($edit && $edit['status'] == $st) ? "selected" : ""; //Menandai status terpilih saat mode edit sesuai nilai status data yang diubah
            $optionStatus .= "<option value='$st' $selected>" . htmlspecialchars($st) . "</option>"; //Menambahkan tag <option> status dengan escape HTML
        } 

        $tpl = new Template("templates/setlist.html"); //Membuat instance Template dengan memuat file templates/setlist.html

        $tpl->replace("DATA_TABEL", $dataSetLists); //Mengganti placeholder DATA_TABEL dengan seluruh baris tabel setlist
        $tpl->replace("DATA_FILTER_CONCERT", $filterConcerts); //Mengganti placeholder DATA_FILTER_CONCERT dengan opsi dropdown filter konser
        $tpl->replace("DATA_OPTION_CONCERT", $optionConcerts); //Mengganti placeholder DATA_OPTION_CONCERT dengan opsi dropdown konser pada form
        $tpl->replace("DATA_OPTION_SONG", $optionSongs); //Mengganti placeholder DATA_OPTION_SONG dengan opsi dropdown lagu pada form
        $tpl->replace("DATA_OPTION_STATUS", $optionStatus); //Mengganti placeholder DATA_OPTION_STATUS dengan opsi dropdown status pada form
        $tpl->replace("DATA_FORM_ACTION", $edit ? "setlist.php?id_update=" . $edit['id'] : "setlist.php"); //Mengatur action form ke URL update saat edit, atau setlist.php saat tambah
        $tpl->replace("DATA_SUBMIT_NAME", $edit ? "update" : "add"); //Mengatur atribut name tombol submit menjadi 'update' atau 'add'
        $tpl->replace("DATA_SUBMIT_TEXT", $edit ? "Update Setlist" : "Tambah ke Setlist"); //Mengatur label tombol submit sesuai mode edit atau tambah
        $tpl->replace("DATA_ORDER", $edit ? htmlspecialchars($edit['song_order']) : ""); //Mengisi nilai awal input urutan lagu saat edit, atau kosong saat tambah

        $tpl->write(); //Mencetak hasil akhir template HTML yang sudah diisi placeholder-nya ke browser
    }
}