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

// Hapus data dari tabel laporan
$sql = "DELETE FROM laporan WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: laporan.php");
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
