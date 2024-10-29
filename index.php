<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Percetakan Reyren</title>
    <link rel="icon" href="icon.png" type="image/png"> <!-- Menambahkan favicon -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS untuk memusatkan gambar */
        .center-image {
            max-width: 25%; /* Ukuran maksimum gambar */
            height: auto; /* Tinggi otomatis untuk menjaga rasio aspek */
            display: block; /* Membuat gambar sebagai block element */
            margin: 0 auto 3px auto; /* Memusatkan gambar dan memberikan margin bawah */
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="gambar1.png" alt="Gambar Percetakan" class="center-image"> <!-- Menggunakan kelas CSS untuk memusatkan gambar -->
        <h2>Formulir Pemesanan Percetakan ReyRen</h2>
        <form action="process.php" method="post" id="orderForm">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="nomor_hp">Nomor HP:</label>
            <input type="text" id="nomor_hp" name="nomor_hp" required>

            <label for="jenis_percetakan">Jenis Percetakan:</label>
            <select id="jenis_percetakan" name="jenis_percetakan" required onchange="calculateTotal()">
                <option value="print" data-price="500">Print (Rp 500)</option>
                <option value="scan/foto copy" data-price="300">Scan/Foto Copy (Rp 300)</option>
                <option value="scan berwarna" data-price="700">Scan Berwarna (Rp 700)</option>
            </select>

            <label for="jumlah">Jumlah:</label>
            <input type="number" id="jumlah" name="jumlah" min="1" required onchange="calculateTotal()">

            <label for="total_harga">Total Harga:</label>
            <input type="text" id="total_harga" name="total_harga" readonly>

            <button type="submit">Pesan</button>
            <a href="laporan.php" class="btn btn-view">Lihat Laporan</a> <!-- Tombol Lihat Laporan -->
        </form>
    </div>

    <script>
        function calculateTotal() {
            let jenisPercetakan = document.getElementById('jenis_percetakan');
            let jumlah = document.getElementById('jumlah').value || 0;
            let selectedOption = jenisPercetakan.options[jenisPercetakan.selectedIndex];
            let price = parseFloat(selectedOption.getAttribute('data-price'));
            let total = price * jumlah;

            document.getElementById('total_harga').value = total ? 'Rp ' + total : '';
        }
    </script>

    <style>
        /* CSS untuk tombol Lihat Laporan */
        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 10px; /* Jarak antara tombol pesan dan tombol lihat laporan */
            background-color: #007BFF; /* Warna biru */
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3; /* Warna biru gelap saat hover */
        }
    </style>
</body>
</html>
