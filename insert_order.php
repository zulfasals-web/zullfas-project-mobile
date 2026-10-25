<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'koneksi.php';

// Ambil data langsung dari parameter URL
$user_id     = $_REQUEST['user_id'] ?? 3;
$menu_item   = $_REQUEST['menu_item'] ?? 'Es Krim Vanilla';
$topping     = $_REQUEST['topping'] ?? 'Tanpa Topping';
$jumlah      = $_REQUEST['jumlah'] ?? 1;
$total_harga = $_REQUEST['total_harga'] ?? 0;
$kode_qr     = $_REQUEST['kode_qr'] ?? '-';

$menu_item = trim($menu_item);
$topping   = trim($topping);

$query = "INSERT INTO pesanan (user_id, menu_item, topping, jumlah, total_harga, kode_qr, tanggal_pesan) 
          VALUES ('$user_id', '$menu_item', '$topping', '$jumlah', '$total_harga', '$kode_qr', NOW())";

if (mysqli_query($conn, $query)) {
    echo "SUCCESS";
} else {
    echo "ERROR: " . mysqli_error($conn);
}
?><?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'koneksi.php';

// Ambil data langsung dari parameter URL
$user_id     = $_REQUEST['user_id'] ?? 3;
$menu_item   = $_REQUEST['menu_item'] ?? 'Es Krim Vanilla';
$topping     = $_REQUEST['topping'] ?? 'Tanpa Topping';
$jumlah      = $_REQUEST['jumlah'] ?? 1;
$total_harga = $_REQUEST['total_harga'] ?? 0;
$kode_qr     = $_REQUEST['kode_qr'] ?? '-';

$menu_item = trim($menu_item);
$topping   = trim($topping);

$query = "INSERT INTO pesanan (user_id, menu_item, topping, jumlah, total_harga, kode_qr, tanggal_pesan) 
          VALUES ('$user_id', '$menu_item', '$topping', '$jumlah', '$total_harga', '$kode_qr', NOW())";

if (mysqli_query($conn, $query)) {
    echo "SUCCESS";
} else {
    echo "ERROR: " . mysqli_error($conn);
}
?>