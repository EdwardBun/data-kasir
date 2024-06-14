<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="d-flex justify-content-center align-items-center flex-column">
    <div class="login-box p-5">
        <h1 class="text-center">Mesin Kasir</h1>
        <form method="POST" action="" class="form-inline">
            <div class="form-group mb-3">
                <input type="text" name="nama" class="form-control btn-lg" placeholder="Nama Barang">
            </div>
            <div class="form-group mb-3">
                <input type="number" name="harga" class="form-control btn-lg" placeholder="Harga">
            </div>
            <div class="form-group mb-3">
                <input type="number" name="jumlah" class="form-control btn-lg" placeholder="Jumlah Barang">
            </div>
            <div class="form-group">
                <button type="submit" name="add" class="btn btn-primary mt-3">Add To Data</button>
                <button type="submit" name="Reset" class="btn btn-danger mt-3">Reset</button>
            </div>
        </form>
    </div>
</div>

<?php
session_start();

if (!isset($_SESSION['Data'])) {
    $_SESSION['Data'] = array();
}

if (isset($_POST['Reset'])) {
    session_unset();
}

if (isset($_GET['hapus'])) {
    $index = $_GET['hapus'];
    unset($_SESSION['Data'][$index]);
}

if (isset($_POST['add']) && !empty($_POST['nama']) && !empty($_POST['harga']) && !empty($_POST['jumlah'])) {
    $_SESSION['Data'][] = [
        'nama' => $_POST['nama'],
        'harga' => $_POST['harga'],
        'jumlah' => $_POST['jumlah']
    ];
    header('Location: index.php');
    exit();
}

if (!empty($_SESSION['Data'])) {
    echo "<table class='table table-striped'>
            <tr>
                <td>Nama Barang</td>
                <td>Harga</td>
                <td>Jumlah Barang</td>
                <td>Action</td>
            </tr>";

    foreach ($_SESSION['Data'] as $index => $value) {
        echo "<tr>
                <td>{$value['nama']}</td>
                <td>" . ($value['harga'] * $value['jumlah']) . "</td>
                <td>{$value['jumlah']}</td>
                <td><a class='btn btn-danger' href='?hapus=$index'>Hapus</a></td>
              </tr>";
    }

    echo "</table><a class='btn btn-primary mt-3' href='checkout.php' style='margin-left: 580px;'>Checkout</a>";
} else {
    echo "<p class='text-center mt-1'>Silahkan Masukan Data Terlebih Dahulu!!</p>";
}

$total_price = array_reduce($_SESSION['Data'], function ($carry, $item) {
    return $carry + $item['harga'] * $item['jumlah'];
}, 0);

if (isset($_POST['make_payment'])) {
    $payment_amount = $_POST['payment_amount'];
    if ($payment_amount < $total_price) {
        echo "<script>alert('Payment amount is less than the total harga.');</script>";
    } else {
        echo "<h2>Receipt</h2><p>Data list:<br>";
        foreach ($_SESSION['Data'] as $item) {
            echo "- {$item['nama']} ({$item['harga']} x {$item['jumlah']})<br>";
        }
        echo "Total harga: {$total_price}<br>";
        echo "Payment amount: {$payment_amount}<br>";
        $change = $payment_amount - $total_price;
        echo "Change: {$change}<br>";

        session_destroy();
        session_start();
    }
}
?>
</body>
</html>
