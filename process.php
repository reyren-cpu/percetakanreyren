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

// Periksa apakah data telah dikirim dari formulir
if (isset($_POST['nama'], $_POST['nomor_hp'], $_POST['jenis_percetakan'], $_POST['jumlah'], $_POST['total_harga'])) {
    // Ambil data dari formulir
    $nama = $_POST['nama'];
    $nomor_hp = $_POST['nomor_hp'];
    $jenis_percetakan = $_POST['jenis_percetakan'];
    $jumlah = $_POST['jumlah'];
    $total_harga = str_replace('Rp ', '', $_POST['total_harga']); // Menghapus "Rp " jika ada
    $total_harga = floatval($total_harga); // Konversi ke float

    // Masukkan data ke tabel pemesanan
    $sql = "INSERT INTO pemesanan (nama, nomor_hp, jenis_percetakan, jumlah, total_harga) 
            VALUES ('$nama', '$nomor_hp', '$jenis_percetakan', $jumlah, $total_harga)";

    if ($conn->query($sql) === TRUE) {
        // Ambil ID terakhir yang baru dimasukkan
        $last_id = $conn->insert_id;
        
        // Salin data ke tabel laporan tanpa mengganggu slip.php
        $sql_laporan = "INSERT INTO laporan (nama, nomor_hp, jenis_percetakan, jumlah, total_harga) 
                        VALUES ('$nama', '$nomor_hp', '$jenis_percetakan', $jumlah, $total_harga)";
        
        // Eksekusi query untuk memasukkan data ke tabel laporan
        if ($conn->query($sql_laporan) === TRUE) {
            // Redirect ke halaman slip hanya jika data laporan juga berhasil disimpan
            header("Location: slip.php?id=" . $last_id);
            exit;
        } else {
            echo "Error: " . $sql_laporan . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Data tidak lengkap. Pastikan semua field sudah diisi.";
}

$conn->close();
?>
