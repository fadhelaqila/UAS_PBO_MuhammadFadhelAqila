<?php
// model/KaryawanMagang.php
require_once 'Karyawan.php';

class KaryawanMagang extends Karyawan {
    // Properti tambahan spesifik sesuai instruksi soal
    private $uangSakuBulanan;
    private $sertifikatKampusMerdeka;

    public function __construct($db, $id, $nama, $dept, $hari, $gaji, $jenis, $uangSaku, $sertifikat) {
        parent::__construct($db, $id, $nama, $dept, $hari, $gaji, $jenis);
        $this->uangSakuBulanan = $uangSaku;
        $this->sertifikatKampusMerdeka = $sertifikat;
    }

    // Getter untuk properti spesifik anak
    public function getUangSakuBulanan() { return $this->uangSakuBulanan; }
    public function getSertifikatKampusMerdeka() { return $this->sertifikatKampusMerdeka; }

    public function hitungGajiBersih() {
        return ($this->gajiDasarPerHari * $this->hariKerjaMasuk) * 0.80;
    }

    public function tampilkanProfilKaryawan() {
        return "Magang: " . $this->sertifikatKampusMerdeka . " (Uang Saku Bulanan: Rp " . number_format($this->uangSakuBulanan, 0, ',', '.') . ")";
    }

    // Metode query spesifik bersyarat (WHERE jenis_karyawan = 'Magang') sesuai ketentuan Tahap 4
    public static function ambilDataBerdasarkanJenis($db, $keyword = '') {
        $query = "SELECT * FROM tabel_karyawan WHERE jenis_karyawan = 'Magang'";
        
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
            $daftarKaryawan[] = new KaryawanMagang(
                $db, $row['id_karyawan'], $row['nama_karyawan'], $row['departemen'],
                $row['hari_kerja_masuk'], $row['gaji_dasar_per_hari'], $row['jenis_karyawan'],
                $row['uang_saku_bulanan'], $row['sertifikat_kampus_merdeka']
            );
        }
        return $daftarKaryawan;
    }
}
?>