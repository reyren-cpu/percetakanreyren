<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "percetakan";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil ID pesanan dari URL
$id = $_GET['id'];

// Ambil data pesanan berdasarkan ID
$sql = "SELECT * FROM pemesanan WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data pesanan
    $row = $result->fetch_assoc();
} else {
    echo "Pesanan tidak ditemukan.";
    exit;
}

$conn->close();

// Format pesan WhatsApp
$nomor_hp = preg_replace('/[^0-9]/', '', $row['nomor_hp']); // Membersihkan nomor HP dari karakter selain angka
$pesan = urlencode("Halo " . $row['nama'] . ",\n\nTerima kasih telah memesan di Percetakan Reyren.\n\nDetail Pesanan Anda:\nID Pesanan: " . $row['id'] . "\nJenis Percetakan: " . $row['jenis_percetakan'] . "\nJumlah: " . $row['jumlah'] . "\nTotal Harga: Rp " . number_format($row['total_harga'], 2) . "\n\nSalam,\nPercetakan Reyren");
$whatsapp_link = "https://wa.me/$nomor_hp?text=$pesan";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Slip Pembayaran</title>
    <link rel="icon" href="icon.png" type="image/png"> <!-- Menambahkan favicon -->
    <link rel="stylesheet" href="style.css">
    <style>
        .center-image {
            max-width: 25%; /* Ukuran maksimum gambar */
            height: auto; /* Tinggi otomatis untuk menjaga rasio aspek */
            display: block; /* Membuat gambar sebagai block element */
            margin: 0 auto 3px auto; /* Memusatkan gambar dan memberikan margin bawah */
        }

        /* CSS untuk menyembunyikan tombol saat mencetak */
        @media print {
            .no-print {
                display: none; /* Sembunyikan elemen dengan kelas no-print */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="gambar1.png" alt="Gambar Percetakan" class="center-image">
        <h2>Slip Pembayaran</h2>
        <h2>Percetakan Reyren</h2>
        <p>Terima kasih telah memesan!</p>
        <p><strong>ID Pesanan:</strong> <?php echo $row['id']; ?></p>
        <p><strong>Nama:</strong> <?php echo $row['nama']; ?></p>
        <p><strong>Nomor HP:</strong> <?php echo $row['nomor_hp']; ?></p>
        <p><strong>Jenis Percetakan:</strong> <?php echo $row['jenis_percetakan']; ?></p>
        <p><strong>Jumlah:</strong> <?php echo $row['jumlah']; ?></p>
        <p><strong>Total Harga:</strong> Rp <?php echo number_format($row['total_harga'], 2); ?></p>
        
        <button class="no-print" onclick="window.print()">Cetak Slip</button>
        <a class="no-print" href="index.php"><button>Pesan Lagi</button></a>
        <a class="no-print" href="<?php echo $whatsapp_link; ?>" target="_blank"><button>Kirim Slip via WhatsApp</button></a>
    </div>
</body>
</html>
