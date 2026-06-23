<?php
// model/KaryawanKontrak.php
require_once 'Karyawan.php';

class KaryawanKontrak extends Karyawan {
    // Properti tambahan spesifik sesuai instruksi soal
    private $durasiKontrakBulan;
    private $agensiPenyalur;

    public function __construct($db, $id, $nama, $dept, $hari, $gaji, $jenis, $durasi, $agensi) {
        // Memanggil constructor milik parent class (Karyawan)
        parent::__construct($db, $id, $nama, $dept, $hari, $gaji, $jenis);
        $this->durasiKontrakBulan = $durasi;
        $this->agensiPenyalur = $agensi;
    }

    // Getter untuk properti spesifik anak
    public function getDurasiKontrakBulan() { return $this->durasiKontrakBulan; }
    public function getAgensiPenyalur() { return $this->agensiPenyalur; }

    // Implementasi sementara metode abstrak dari parent class
    public function hitungGajiBersih() {
        return 0; // Akan diisi di Tahap 5
    }

    public function tampilkanProfilKaryawan() {
        return "Karyawan Kontrak via agensi " . $this->agensiPenyalur; // Akan dioptimalkan di Tahap 5
    }

    // Metode query spesifik bersyarat (WHERE jenis_karyawan = 'Kontrak') sesuai ketentuan Tahap 4
    public static function ambilDataBerdasarkanJenis($db, $keyword = '') {
        $query = "SELECT * FROM tabel_karyawan WHERE jenis_karyawan = 'Kontrak'";
        
        // Menambahkan filter pencarian jika kata kunci input tidak kosong
        if (!empty($keyword)) {
            $query .= " AND nama_karyawan LIKE :keyword";
        }
        
        $stmt = $db->prepare($query);
        
        if (!empty($keyword)) {
            $search = "%{$keyword}%";
            $stmt->bindParam(':keyword', $search);
        }
        
        $stmt->execute();
        $daftarKaryawan = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $daftarKaryawan[] = new KaryawanKontrak(
                $db, $row['id_karyawan'], $row['nama_karyawan'], $row['departemen'],
                $row['hari_kerja_masuk'], $row['gaji_dasar_per_hari'], $row['jenis_karyawan'],
                $row['durasi_kontrak_bulan'], $row['agensi_penyalur']
            );
        }
        return $daftarKaryawan;
    }
}
?>