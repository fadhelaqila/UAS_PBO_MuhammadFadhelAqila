<?php
// index.php

require_once 'koneksi.php'; 
require_once 'model/KaryawanKontrak.php';
require_once 'model/KaryawanTetap.php';
require_once 'model/KaryawanMagang.php';

// 1. Inisialisasi Koneksi Database
$database = new Database();
$db = $database->getConnection();

// 2. Mengambil kata kunci pencarian jika ada input dari user
$kataKunci = isset($_GET['cari']) ? $_GET['cari'] : '';

// 3. Mengambil data terpisah/berkelompok lewat subclass masing-masing (Sesuai Perintah Tahap 6)
$dataTetap   = KaryawanTetap::ambilDataBerdasarkanJenis($db, $kataKunci);
$dataKontrak = KaryawanKontrak::ambilDataBerdasarkanJenis($db, $kataKunci);
$dataMagang  = KaryawanMagang::ambilDataBerdasarkanJenis($db, $kataKunci);

// 4. Polimorfisme: Menggabungkan semua objek anak ke dalam satu array besar induk
$semuaKaryawan = array_merge($dataTetap, $dataKontrak, $dataMagang);

// 5. Logika mempertahankan Tab Aktif saat melakukan searching/pencarian
$tabAktif = "all";
if (!empty($kataKunci)) {
    if (count($dataTetap) > 0 && count($dataKontrak) == 0 && count($dataMagang) == 0) $tabAktif = "tetap";
    elseif (count($dataKontrak) > 0 && count($dataTetap) == 0 && count($dataMagang) == 0) $tabAktif = "kontrak";
    elseif (count($dataMagang) > 0 && count($dataTetap) == 0 && count($dataKontrak) == 0) $tabAktif = "magang";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penggajian Karyawan - UAS PBO</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        :root {
            --bg-main: #090d16;
            --bg-sidebar: #0f1524;
            --bg-card: rgba(20, 29, 47, 0.7);
            --primary-gradient: linear-gradient(135deg, #3b82f6, #7c3aed);
            --text-muted-custom: #94a3b8;
            --border-custom: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-main);
            color: #f1f5f9;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR (MENU SAMPING STATIS PREMIUM) */
        .sidebar {
            width: 280px;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-custom);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 24px;
            font-size: 1.3rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            border-bottom: 1px solid var(--border-custom);
        }

        .sidebar-menu {
            padding: 20px 14px;
            flex-grow: 1;
        }

        .nav-pills-custom .nav-link {
            color: var(--text-muted-custom);
            background: transparent;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            width: 100%;
            text-align: left;
            transition: all 0.2s ease;
        }

        .nav-pills-custom .nav-link i {
            font-size: 1.2rem;
            margin-right: 12px;
        }

        .nav-pills-custom .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.03);
        }

        .nav-pills-custom .nav-link.active {
            background: var(--primary-gradient);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        /* AREA KONTEN UTAMA KANAN */
        .main-content {
            flex-grow: 1;
            margin-left: 280px;
            padding: 40px;
            min-width: 0;
        }

        .top-search-bar {
            background: var(--bg-card);
            border: 1px solid var(--border-custom);
            border-radius: 12px;
            padding: 8px 16px;
        }

        .search-input {
            background: transparent;
            border: none;
            color: #ffffff;
            outline: none;
            width: 100%;
        }

        /* GLASSMORPHISM CARD PANEL */
        .glass-panel {
            background: var(--bg-card);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-custom);
            border-radius: 16px;
            padding: 28px;
            margin-top: 30px;
        }

        /* STYLING TABEL KONTRAST TINGGI (CERAH) */
        .table-premium th {
            background-color: #0f172a !important;
            color: #ffffff !important;
            font-weight: 600;
            border-bottom: 2px solid var(--border-custom);
        }

        .table-premium td {
            color: #e2e8f0 !important; /* Membuat teks data umum sangat terang */
        }

        .text-id { color: #3b82f6 !important; font-weight: 600; }
        .text-nama { color: #ffffff !important; font-weight: 600; }
        .text-dept { color: #cbd5e1 !important; }
        .text-spesifik-info { color: #f8fafc !important; font-size: 0.85rem; line-height: 1.4; }

        /* BADGE KAPSUL STATUS JABATAN */
        .badge-karyawan { padding: 6px 12px; font-weight: 600; border-radius: 6px; display: inline-block; }
        .badge-tetap { background-color: rgba(59, 130, 246, 0.15); color: #3b82f6; border: 1px solid #3b82f6; }
        .badge-kontrak { background-color: rgba(234, 179, 8, 0.15); color: #eab308; border: 1px solid #eab308; }
        .badge-magang { background-color: rgba(236, 72, 153, 0.15); color: #ec4899; border: 1px solid #ec4899; }
    </style>
</head>
<body>

<div class="wrapper">
    
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-building-gear me-2"></i><span>HRIS Payroll</span>
        </div>
        
        <div class="sidebar-menu">
            <div class="nav flex-column nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link <?php echo ($tabAktif == 'all') ? 'active' : ''; ?>" id="v-pills-all-tab" data-bs-toggle="pill" data-bs-target="#v-pills-all" type="button" role="tab">
                    <i class="bi bi-people-fill"></i><span>Semua Karyawan</span>
                </button>
                <button class="nav-link <?php echo ($tabAktif == 'tetap') ? 'active' : ''; ?>" id="v-pills-tetap-tab" data-bs-toggle="pill" data-bs-target="#v-pills-tetap" type="button" role="tab">
                    <i class="bi bi-shield-check"></i><span>Karyawan Tetap</span>
                </button>
                <button class="nav-link <?php echo ($tabAktif == 'kontrak') ? 'active' : ''; ?>" id="v-pills-kontrak-tab" data-bs-toggle="pill" data-bs-target="#v-pills-kontrak" type="button" role="tab">
                    <i class="bi bi-file-earmark-text"></i><span>Karyawan Kontrak</span>
                </button>
                <button class="nav-link <?php echo ($tabAktif == 'magang') ? 'active' : ''; ?>" id="v-pills-magang-tab" data-bs-toggle="pill" data-bs-target="#v-pills-magang" type="button" role="tab">
                    <i class="bi bi-mortarboard"></i><span>Karyawan Magang</span>
                </button>
            </div>
        </div>
        
        <div class="p-3 border-top border-secondary border-opacity-25 text-center text-white-50 small">
            <i class="bi bi-person-badge text-success me-1"></i> M. Fadhel Aqila
        </div>
    </div>

    <div class="main-content">
        
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <h2 class="fw-bold m-0 text-white">Sistem Slip Gaji Terintegrasi</h2>
                <p class="text-muted small m-0">Aplikasi Penggajian Berbasis Polimorfisme Objek Murni</p>
            </div>
            <div class="col-md-6">
                <form action="" method="GET">
                    <div class="d-flex top-search-bar align-items-center">
                        <i class="bi bi-search text-muted me-3"></i>
                        <input type="text" name="cari" class="search-input" placeholder="Cari nama karyawan..." value="<?php echo htmlspecialchars($kataKunci); ?>">
                        <?php if (!empty($kataKunci)): ?>
                            <a href="index.php" class="text-danger me-2 text-decoration-none small">Clear</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-primary btn-sm px-3 rounded-8 fw-semibold">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-content" id="v-pills-tabContent">
            
            <div class="tab-pane fade <?php echo ($tabAktif == 'all') ? 'show active' : ''; ?>" id="v-pills-all" role="tabpanel">
                <?php cetakMasterTabelKaryawan($semuaKaryawan, "Seluruh Anggota Perusahaan (" . count($semuaKaryawan) . " Orang)"); ?>
            </div>

            <div class="tab-pane fade <?php echo ($tabAktif == 'tetap') ? 'show active' : ''; ?>" id="v-pills-tetap" role="tabpanel">
                <?php cetakMasterTabelKaryawan($dataTetap, "Kategori Ketenagakerjaan: Tetap"); ?>
            </div>

            <div class="tab-pane fade <?php echo ($tabAktif == 'kontrak') ? 'show active' : ''; ?>" id="v-pills-kontrak" role="tabpanel">
                <?php cetakMasterTabelKaryawan($dataKontrak, "Kategori Ketenagakerjaan: Kontrak"); ?>
            </div>

            <div class="tab-pane fade <?php echo ($tabAktif == 'magang') ? 'show active' : ''; ?>" id="v-pills-magang" role="tabpanel">
                <?php cetakMasterTabelKaryawan($dataMagang, "Kategori Ketenagakerjaan: Magang"); ?>
            </div>

        </div>

    </div>
</div>

<?php
// FUNGSI UTAMA RENDER TABEL DATA POLIMORFISME
function cetakMasterTabelKaryawan($arrayKaryawan, $judulTabel) {
    ?>
    <div class="glass-panel shadow-lg">
        <h4 class="mb-4 fw-bold text-white"><i class="bi bi-layers-half text-primary me-2"></i><?php echo $judulTabel; ?></h4>
        
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle border-0 table-premium">
                <thead>
                    <tr>
                        <th class="py-3">ID</th>
                        <th class="py-3">NAMA KARYAWAN</th>
                        <th class="py-3">DEPARTEMEN</th>
                        <th class="py-3 text-center">HARI KERJA</th>
                        <th class="py-3">GAJI/HARI</th>
                        <th class="py-3 text-success">GAJI BERSIH (POLIMORFISME)</th>
                        <th class="py-3">SPESIFIKASI JABATAN & ATRIBUT ANAK</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($arrayKaryawan) > 0): ?>
                        <?php foreach ($arrayKaryawan as $karyawan): 
                            $classObjek = get_class($karyawan);
                            $badgeClass = "badge-tetap";
                            if ($classObjek == 'KaryawanKontrak') $badgeClass = "badge-kontrak";
                            if ($classObjek == 'KaryawanMagang') $badgeClass = "badge-magang";
                        ?>
                            <tr>
                                <td class="text-id">#<?php echo $karyawan->getIdKaryawan(); ?></td>
                                
                                <td class="text-nama"><i class="bi bi-person-circle text-primary text-opacity-70 me-2"></i><?php echo $karyawan->getNamaKaryawan(); ?></td>
                                
                                <td class="text-dept"><?php echo $karyawan->getDepartemen(); ?></td>
                                
                                <td class="text-center">
                                    <span class="badge bg-light text-dark fw-bold px-2 py-1"><?php echo $karyawan->getHariKerjaMasuk(); ?> Hari</span>
                                </td>
                                
                                <td class="text-white fw-medium">Rp <?php echo number_format($karyawan->getGajiDasarPerHari(), 0, ',', '.'); ?></td>
                                
                                <td class="fw-bold text-success fs-6">Rp <?php echo number_format($karyawan->hitungGajiBersih(), 0, ',', '.'); ?></td>
                                
                                <td>
                                    <span class="badge-karyawan <?php echo $badgeClass; ?> mb-1 small"><?php echo $karyawan->getJenisKaryawan(); ?></span>
                                    <div class="text-spesifik-info mt-1">
                                        <i class="bi bi-info-circle text-warning me-1"></i><?php echo $karyawan->tampilkanProfilKaryawan(); ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-danger py-5">
                                <i class="bi bi-folder-x fs-1 d-block mb-2"></i>Data karyawan tidak ditemukan.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>