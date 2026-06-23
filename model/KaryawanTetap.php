<?php
// model/KaryawanTetap.php
require_once 'Karyawan.php';

class KaryawanTetap extends Karyawan {
    // Properti tambahan spesifik sesuai instruksi soal
    private $tunjanganKesehatan;
    private $opsiSahamId;

    public function __construct($db, $id, $nama, $dept, $hari, $gaji, $jenis, $tunjangan, $opsiSaham) {
        parent::__construct($db, $id, $nama, $dept, $hari, $gaji, $jenis);
        $this->tunjanganKesehatan = $tunjangan;
        $this->opsiSahamId = $opsiSaham;
    }

    // Getter untuk properti spesifik anak
    public function getTunjanganKesehatan() { return $this->tunjanganKesehatan; }
    public function getOpsiSahamId() { return $this->opsiSahamId; }

    public function hitungGajiBersih() {
        return ($this->gajiDasarPerHari * $this->hariKerjaMasuk) + $this->tunjanganKesehatan;
    }

    public function tampilkanProfilKaryawan() {
        return "Tetap: Tunjangan Kesehatan Rp " . number_format($this->tunjanganKesehatan, 0, ',', '.') . " | ID Saham: " . $this->opsiSahamId;
    }

    // Metode query spesifik bersyarat (WHERE jenis_karyawan = 'Tetap') sesuai ketentuan Tahap 4
    public static function ambilDataBerdasarkanJenis($db, $keyword = '') {
        $query = "SELECT * FROM tabel_karyawan WHERE jenis_karyawan = 'Tetap'";
        
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
            $daftarKaryawan[] = new KaryawanTetap(
                $db, $row['id_karyawan'], $row['nama_karyawan'], $row['departemen'],
                $row['hari_kerja_masuk'], $row['gaji_dasar_per_hari'], $row['jenis_karyawan'],
                $row['tunjangan_kesehatan'], $row['opsi_saham_id']
            );
        }
        return $daftarKaryawan;
    }
}
?>