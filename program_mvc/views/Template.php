<?php

class Template{ //Membuat class Template untuk membaca dan memproses file template HTML
    var $filename = ''; //Menyimpan path atau nama file template yang akan dimuat
    var $content = ''; //Menyimpan isi konten string dari file template

    function __construct($filename = ''){ //Constructor yang dijalankan otomatis saat objek Template dibuat
        $this->filename = $filename; //Menyimpan parameter $filename ke properti $this->filename
        $this->content = implode('', @file($filename)); //Membaca baris file ke array lalu menggabungkannya menjadi satu string
    } 

    function clear(){ //Method untuk membersihkan placeholder DATA_* yang belum terganti
        $this->content = preg_replace("/DATA_[A-Z|_|0-9]+/", "", $this->content); //Menghapus semua pola DATA_ diikuti huruf kapital, underscore, atau angka
    } 

    function write(){ //Method untuk membersihkan sisa placeholder lalu mencetak hasil template ke output
        $this->clear(); //Memanggil method clear() sebelum menampilkan konten
        print $this->content; //Mencetak isi $this->content ke browser
    } 

    function getContent(){ //Method untuk membersihkan sisa placeholder lalu mengembalikan hasil template sebagai string
        $this->clear(); //Memanggil method clear() agar placeholder sisa tidak ikut terbawa
        return $this->content; //Mengembalikan isi $this->content kepada pemanggil
    } 

    function replace($old = '', $new = ''){ //Method untuk mengganti placeholder ($old) dengan nilai baru ($new)
        if (is_int($new)) { //Mengecek apakah nilai pengganti bertipe integer
            $value = sprintf("%d", $new); //Memformat nilai integer menjadi string desimal
        }
        elseif (is_float($new)) { //Jika bukan integer, cek apakah nilai pengganti bertipe float/desimal
            $value = sprintf("%f", $new); //Memformat nilai float menjadi string desimal
        }
        elseif (is_array($new)) { //Jika bukan int maupun float, cek apakah nilai pengganti berupa array
            $value = ''; //Menyiapkan variabel string kosong untuk menampung elemen array
            foreach ($new as $item) { //Melakukan iterasi setiap elemen pada array $new
                $value .= $item . ' '; //Menggabungkan setiap elemen array diikuti spasi ke $value
            } 
        }
        else { //Jika tipe data bukan int, float, maupun array (misalnya string)
            $value = $new; //Menggunakan nilai $new apa adanya sebagai string pengganti
        }

        $this->content = preg_replace("/$old/", $value, $this->content); //Mengganti pola placeholder $old di dalam $this->content dengan $value
    } 
}