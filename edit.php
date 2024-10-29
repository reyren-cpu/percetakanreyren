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
$sql = "SELECT * FROM laporan WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Pesanan tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $nama = $_POST['nama'];
    $nomor_hp = $_POST['nomor_hp'];
    $jenis_percetakan = $_POST['jenis_percetakan'];
    $jumlah = $_POST['jumlah'];
    $total_harga = $_POST['total_harga'];

    // Update data di tabel laporan
    $sql_update = "UPDATE laporan SET 
                    nama = '$nama', 
                    nomor_hp = '$nomor_hp', 
                    jenis_percetakan = '$jenis_percetakan', 
                    jumlah = $jumlah, 
                    total_harga = $total_harga 
                    WHERE id = $id";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: laporan.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Laporan Pemesanan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Laporan Pemesanan</h2>
        <form action="" method="post">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>

            <label for="nomor_hp">Nomor HP:</label>
            <input type="text" id="nomor_hp" name="nomor_hp" value="<?php echo $row['nomor_hp']; ?>" required>

            <label for="jenis_percetakan">Jenis Percetakan:</label>
            <select id="jenis_percetakan" name="jenis_percetakan" required>
                <option value="print" <?php echo ($row['jenis_percetakan'] == 'print') ? 'selected' : ''; ?>>Print</option>
                <option value="scan/foto copy" <?php echo ($row['jenis_percetakan'] == 'scan/foto copy') ? 'selected' : ''; ?>>Scan/Foto Copy</option>
                <option value="scan berwarna" <?php echo ($row['jenis_percetakan'] == 'scan berwarna') ? 'selected' : ''; ?>>Scan Berwarna</option>
            </select>

            <label for="jumlah">Jumlah:</label>
            <input type="number" id="jumlah" name="jumlah" value="<?php echo $row['jumlah']; ?>" min="1" required>

            <label for="total_harga">Total Harga:</label>
            <input type="text" id="total_harga" name="total_harga" value="<?php echo $row['total_harga']; ?>" readonly>

            <button type="submit">Update</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
