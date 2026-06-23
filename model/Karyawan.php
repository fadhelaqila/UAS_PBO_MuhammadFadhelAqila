<?php
// model/Karyawan.php

abstract class Karyawan {
    // Properti terenkapsulasi (protected) sesuai instruksi soal
    protected $db;
    protected $id_karyawan;
    protected $nama_karyawan;
    protected $departemen;
    protected $hariKerjaMasuk;
    protected $gajiDasarPerHari;
    protected $jenis_karyawan;

    // Constructor untuk menginisialisasi data objek induk
    public function __construct($db, $id, $nama, $dept, $hari, $gaji, $jenis) {
        $this->db = $db;
        $this->id_karyawan = $id;
        $this->nama_karyawan = $nama;
        $this->departemen = $dept;
        $this->hariKerjaMasuk = $hari;
        $this->gajiDasarPerHari = $gaji;
        $this->jenis_karyawan = $jenis;
    }

    // Metode Getter/Setter Publik (Agar kelas View/index.php bisa menampilkan data yang di-protect)
    public function getIdKaryawan() { return $this->id_karyawan; }
    public function getNamaKaryawan() { return $this->nama_karyawan; }
    public function getDepartemen() { return $this->departemen; }
    public function getHariKerjaMasuk() { return $this->hariKerjaMasuk; }
    public function getGajiDasarPerHari() { return $this->gajiDasarPerHari; }
    public function getJenisKaryawan() { return $this->jenis_karyawan; }

    // METODE ABSTRAK (Wajib dideklarasikan tanpa isi/body sesuai rubrik)
    abstract public function hitungGajiBersih();
    abstract public function tampilkanProfilKaryawan();
}
?>