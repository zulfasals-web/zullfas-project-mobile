<?php
include 'koneksi.php';

// Ambil data pesanan & hitung total ringkasan
$query = "SELECT pesanan.*, users.nama, users.email 
          FROM pesanan 
          LEFT JOIN users ON pesanan.user_id = users.id 
          ORDER BY pesanan.id_pesanan DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

// Hitung statistik ringkasan
$total_transaksi = mysqli_num_rows($result);
$total_pendapatan = 0;
$data_pesanan = [];

while ($row = mysqli_fetch_assoc($result)) {
    $total_pendapatan += $row['total_harga'];
    $data_pesanan[] = $row;
}

date_default_timezone_set('Asia/Jakarta');
$tanggal_cetak = date('d-m-Y H:i:s');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - 17' Ice Cream</title>
    
    <!-- Google Fonts & Bootstrap 5 & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-pink: #ff4757;
            --soft-pink: #ffeaa7;
            --bg-gradient: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            --card-gradient: linear-gradient(135deg, #ff6b81 0%, #ff4757 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
            color: #2d3436;
        }

        .main-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .stat-card {
            border: none;
            border-radius: 16px;
            padding: 20px;
            transition: transform 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
        }

        .stat-card.primary {
            background: linear-gradient(135deg, #ff6b81 0%, #ff4757 100%);
            color: #fff;
        }
        
        .stat-card.secondary {
            background: linear-gradient(135deg, #70a1ff 0%, #1e90ff 100%);
            color: #fff;
        }

        .table-custom {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table-custom thead th {
            border: none;
            background-color: #f1f2f6;
            color: #57606f;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 14px 16px;
        }

        .table-custom tbody tr {
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .table-custom tbody tr:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
            background-color: #fffafb;
        }

        .table-custom td {
            border: none;
            padding: 16px;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .table-custom td:first-child { border-radius: 10px 0 0 10px; }
        .table-custom td:last-child { border-radius: 0 10px 10px 0; }

        .badge-qris {
            background-color: #eccc68;
            color: #2f3542;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: monospace;
        }

        .btn-action {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        /* ========================================================
           CSS KHUSUS CETAK PDF / PRINT (TAMPILAN TEKS LAPORAN POLOS)
           ======================================================== */
        @media print {
            /* 1. Sembunyikan elemen UI web yang tidak perlu */
            .no-print, 
            .stat-card, 
            .badge-admin, 
            .badge-qris i, 
            .bi, 
            button, 
            .btn {
                display: none !important;
            }

            /* 2. Reset Latar Belakang & Warna Teks ke Hitam Putih */
            body {
                background: #ffffff !important;
                color: #000000 !important;
                padding: 0 !important;
                margin: 0 !important;
                font-family: 'Times New Roman', Times, serif, Arial !important;
            }

            .main-card {
                box-shadow: none !important;
                padding: 0 !important;
                background: transparent !important;
            }

            h2 {
                font-size: 18pt !important;
                text-align: center !important;
                color: #000000 !important;
                margin-bottom: 5px !important;
            }

            .text-muted {
                color: #333333 !important;
            }

            /* 3. Format Tabel Laporan Sederhana dengan Garis Pembatas */
            .table-responsive {
                overflow: visible !important;
            }

            table, .table-custom {
                width: 100% !important;
                border-collapse: collapse !important;
                border-spacing: 0 !important;
                margin-top: 15px !important;
            }

            .table-custom thead th {
                background-color: #f2f2f2 !important;
                color: #000000 !important;
                border: 1px solid #000000 !important;
                padding: 8px !important;
                font-size: 10pt !important;
                text-align: center !important;
            }

            .table-custom tbody tr {
                box-shadow: none !important;
                background: transparent !important;
            }

            .table-custom td {
                border: 1px solid #000000 !important;
                padding: 6px 8px !important;
                font-size: 10pt !important;
                color: #000000 !important;
                border-radius: 0 !important;
            }

            /* Reset warna-warni teks di dalam tabel */
            .text-danger, .text-success, .text-dark, .badge {
                color: #000000 !important;
                background: transparent !important;
                border: none !important;
                padding: 0 !important;
                font-weight: normal !important;
            }

            .badge-qris {
                background: transparent !important;
                color: #000000 !important;
                padding: 0 !important;
            }
        }
    </style>
</head>
<body class="p-3 p-md-5">

    <div class="container-fluid max-width-xl">
        <div class="main-card p-4 p-md-5">
            
            <!-- HEADER & TOMBOL ACTION -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <div>
                    <span class="badge bg-danger-subtle text-danger mb-2 px-3 py-2 rounded-pill fw-bold badge-admin">
                        🍦 Admin Control Panel
                    </span>
                    <h2 class="fw-extrabold m-0 text-dark">Dashboard Penjualan 17' Ice Cream</h2>
                </div>

                <div class="no-print d-flex gap-2">
                    <a href="export_excel.php" class="btn btn-success btn-action shadow-sm">
                        <i class="bi bi-file-earmark-excel-fill me-2"></i> Export Excel
                    </a>
                    <button onclick="window.print()" class="btn btn-danger btn-action shadow-sm">
                        <i class="bi bi-printer-fill me-2"></i> Cetak / PDF
                    </button>
                </div>
            </div>

            <!-- CARDS STATISTIK (Ringkasan Ringkas) -->
            <div class="row g-3 mb-4 no-print">
                <div class="col-md-6">
                    <div class="stat-card primary shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50 text-uppercase fw-bold">Total Pendapatan</small>
                                <h2 class="fw-bold m-0 mt-1">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h2>
                            </div>
                            <div class="fs-1 text-white-50"><i class="bi bi-wallet2"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card secondary shadow-sm">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-white-50 text-uppercase fw-bold">Total Pesanan Masuk</small>
                                <h2 class="fw-bold m-0 mt-1"><?= $total_transaksi; ?> Order</h2>
                            </div>
                            <div class="fs-1 text-white-50"><i class="bi bi-cart-check-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-muted small mb-3">
                <i class="bi bi-clock-history me-1 no-print"></i> Data diperbarui pada: <strong><?= $tanggal_cetak; ?></strong>
            </div>

            <!-- TABEL DATA MODERN -->
            <div class="table-responsive">
                <table class="table table-custom align-middle" id="tabel-pesanan">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Pelanggan</th>
                            <th>Menu</th>
                            <th>Topping</th>
                            <th class="text-center">Jumlah</th>
                            <th>Total Harga</th>
                            <th>Kode QRIS</th>
                            <th class="text-center">Status</th>
                            <th>Waktu Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if (!empty($data_pesanan)) :
                            foreach ($data_pesanan as $row) : 
                        ?>
                            <tr>
                                <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama'] ?? 'Guest'); ?></div>
                                    <small class="text-muted"><?= htmlspecialchars($row['email'] ?? '-'); ?></small>
                                </td>
                                <td><span class="fw-semibold text-danger"><?= htmlspecialchars($row['menu_item']); ?></span></td>
                                <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($row['topping']); ?></span></td>
                                <td class="text-center fw-bold"><?= htmlspecialchars($row['jumlah']); ?></td>
                                <td class="fw-bold text-success">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if (!empty($row['kode_qr'])) : ?>
                                        <span class="badge-qris"><i class="bi bi-qr-code-scan me-1"></i><?= htmlspecialchars($row['kode_qr']); ?></span>
                                    <?php else : ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                    </span>
                                </td>
                                <td class="text-muted small"><?= htmlspecialchars($row['tanggal_pesan']); ?></td>
                            </tr>
                        <?php 
                            endforeach; 
                        else : 
                        ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary no-print"></i>
                                    Belum ada data pesanan masuk.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</body>
</html>