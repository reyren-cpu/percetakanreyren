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

// Ambil semua data dari tabel laporan
$sql = "SELECT * FROM laporan ORDER BY tanggal_pemesanan DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan</title>
    <link rel="icon" href="icon.png" type="image/png"> <!-- Menambahkan favicon -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }

        .header {
            display: flex; /* Menggunakan Flexbox untuk menyusun header */
            justify-content: space-between; /* Mengatur jarak antara tombol dan judul */
            align-items: center; /* Vertikal center */
            background-color: #333; /* Latar belakang hitam */
            padding: 10px; /* Jarak di dalam header */
            color: #fff; /* Warna teks putih */
        }

        h2 {
            margin: 0; /* Menghilangkan margin default */
            flex: 1; /* Memungkinkan judul mengambil ruang yang tersisa */
            text-align: center; /* Pusatkan teks */
        }

        .search-container {
            display: flex;
            align-items: center; /* Vertikal center */
        }

        input[type="text"] {
            padding: 8px;
            margin-left: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 250px; /* Lebar input pencarian */
            position: relative;
        }

        .search-icon {
            width: 20px; /* Atur lebar gambar */
            height: 20px; /* Atur tinggi gambar */
            position: absolute;
            left: 10px; /* Jarak gambar dari kiri */
            top: 50%; /* Pusatkan secara vertikal */
            transform: translateY(-50%); /* Pusatkan secara vertikal */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px 0;
            text-decoration: none;
            border-radius: 5px;
            color: white;
            text-align: center;
        }

        .btn-edit {
            background-color: #4CAF50;
        }

        .btn-delete {
            background-color: #f44336;
        }

        .btn-back {
            background-color: #d9534f; /* Merah untuk tombol kembali */
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header"> <!-- Menambahkan div header untuk Flexbox -->
            <a class="btn btn-back" href="index.php">Kembali</a> <!-- Tombol Kembali -->
            <h2>Laporan Pemesanan</h2>
            <div class="search-container">
                <img src="cari1.png" alt="Search Icon" class="search-icon" /> <!-- Gambar Ikon Pencarian -->
                <input type="text" placeholder="Cari data..." id="searchInput" onkeyup="searchData()" /> <!-- Input Pencarian -->
            </div>
        </div>
        <table id="dataTable">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Nomor HP</th>
                <th>Jenis Percetakan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal Pemesanan</th>
                <th>Aksi</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['nomor_hp']; ?></td>
                        <td><?php echo $row['jenis_percetakan']; ?></td>
                        <td><?php echo $row['jumlah']; ?></td>
                        <td>Rp <?php echo number_format($row['total_harga'], 2); ?></td>
                        <td><?php echo $row['tanggal_pemesanan']; ?></td>
                        <td>
                            <a class="btn btn-edit" href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                            <a class="btn btn-delete" href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Tidak ada laporan pemesanan.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <script>
        function searchData() {
            let input = document.getElementById("searchInput");
            let filter = input.value.toLowerCase();
            let table = document.getElementById("dataTable");
            let tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those that don't match the search query
            for (let i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                let td = tr[i].getElementsByTagName("td");
                let rowVisible = false;

                // Check if any of the td elements match the search query
                for (let j = 0; j < td.length; j++) {
                    if (td[j]) {
                        let txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            rowVisible = true;
                            break;
                        }
                    }
                }

                tr[i].style.display = rowVisible ? "" : "none"; // Show row if a match is found
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
