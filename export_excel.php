<?php
include 'koneksi.php';

// Header HTTP resmi agar browser mengenali ini sebagai file unduhan aman
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Rekap_Penjualan_17IceCream.xls");
header("Pragma: no-cache");
header("Expires: 0");

$query = "SELECT pesanan.*, users.nama, users.email 
          FROM pesanan 
          LEFT JOIN users ON pesanan.user_id = users.id 
          ORDER BY pesanan.id_pesanan DESC";

$result = mysqli_query($conn, $query);
?>

<h3 style="text-align: center;">REKAPITULASI PENJUALAN 17' ICE CREAM</h3>
<table border="1">
    <thead>
        <tr style="background-color: #ff4757; color: white;">
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Email</th>
            <th>Menu Pesanan</th>
            <th>Jumlah</th>
            <th>Topping</th>
            <th>Total Harga</th>
            <th>Kode QRIS</th>
            <th>Status</th>
            <th>Tanggal Order</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        if (mysqli_num_rows($result) > 0) :
            while ($row = mysqli_fetch_assoc($result)) : 
        ?>
            <tr>
                <td style="text-align: center;"><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama'] ?? 'Guest'); ?></td>
                <td><?= htmlspecialchars($row['email'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($row['menu_item']); ?></td>
                <td style="text-align: center;"><?= htmlspecialchars($row['jumlah']); ?></td>
                <td><?= htmlspecialchars($row['topping']); ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td>'<?= htmlspecialchars($row['kode_qr']); ?></td>
                <td style="text-align: center;">Selesai</td>
                <td><?= htmlspecialchars($row['tanggal_pesan']); ?></td>
            </tr>
        <?php 
            endwhile; 
        else:
        ?>
            <tr>
                <td colspan="10" style="text-align: center;">Belum ada data pesanan.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>