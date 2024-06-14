<?php
session_start();

$total_price = array_reduce($_SESSION['Data'], function($carry, $item) {
    return $carry + ($item['harga'] * $item['jumlah']);
}, 0);


$Data = $_POST['Data'] ?? 0;
$kembalian = $Data - $total_price;

echo "<h2>STRUK</h2>";
echo "<h3>BARANG YANG DIBELI:</h3>";
echo "<ul>";
foreach($_SESSION['Data'] as $item) {
    $item_total = $item['harga'] * $item['jumlah'];
    echo "<li>{$item['nama']} x {$item['jumlah']} = Rp. {$item_total}</li>";
}
echo "</ul>";
echo "<p>Total: Rp. $total_price</p>";
echo "<p>Bayar: Rp. $Data</p>";
echo "<p>Kembalian: Rp. $kembalian</p>";

echo '<form action="index.php" method="post">';
echo '<input type="hidden" name="reset" value="true">';
echo '<button type="submit">Reset</button>';
echo '</form>';


if (isset($_POST['reset'])) {
    session_unset();
    header('Location: index.php');
    exit();
}
?>
