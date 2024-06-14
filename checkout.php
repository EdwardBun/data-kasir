<?php
session_start();


if (!isset($_SESSION['Data'])) {
    $_SESSION['Data'] = [];
}


if (isset($_POST['nama'], $_POST['harga'], $_POST['jumlah'])) {
    $_SESSION['Data'][] = [
        'nama' => $_POST['nama'],
        'harga' => $_POST['harga'],
        'jumlah' => $_POST['jumlah']
    ];
}


$total_price = array_reduce($_SESSION['Data'], function($carry, $item) {
    return $carry + ($item['harga'] * $item['jumlah']);
}, 0);

if (isset($_POST['Data'])) {
    $Data = $_POST['Data'];
    if ($Data < $total_price) {
        echo "Error: Uang anda kurang.";
    } else {
        $kembalian = $Data - $total_price;
        echo "Transaksi selesai. Kembalian Anda Rp. $kembalian. <a href='struk.php'>Lihat struk</a>";
    }
}


echo "<h2>Data:</h2>";
if (!empty($_SESSION['Data'])) {
    echo "<ul>";
    foreach ($_SESSION['Data'] as $item) {
        echo "<li>{$item['nama']} x {$item['jumlah']} = Rp. " . ($item['harga'] * $item['jumlah']) . "</li>";
    }
    echo "</ul>";
    echo "<p>Total Harga: Rp. $total_price</p>";
    echo "<form action='' method='post'>
            <label for='Data'>Bayar:</label><br>
            <input type='number' id='Data' name='Data' required><br>
            <input type='submit' value='Checkout'>
          </form>";
} else {
    echo "<p>Data kosong.</p>";
}
?>
