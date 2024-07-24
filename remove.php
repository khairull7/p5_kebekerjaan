<?php
// Sertakan kode koneksi database di sini
$host = "localhost";
$username = "root";
$password = "";
$database = "absensi_jumat";

// Membuat koneksi ke database menggunakan mysqli_connect
$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$response = ""; // Variabel untuk menyimpan pesan respons

// Memeriksa jika permintaan datang melalui metode POST dan tombol "remove_student" telah diklik
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_student"])) {
    $student_id = $_POST["student_id"]; // Mengambil ID murid yang akan dihapus

    // Membuat query SQL untuk menghapus data murid berdasarkan ID mereka
    $delete_sql = "DELETE FROM murid WHERE nis = '$student_id'";

    // Menjalankan query delete menggunakan mysqli_query
    if (mysqli_query($conn, $delete_sql)) {
        $response = "Data murid berhasil dihapus.";
    } else {
        $response = "Error saat menghapus data murid: " . mysqli_error($conn);
    }
}

// Menutup koneksi database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hapus Murid</title>
    <script>
        // Menggunakan JavaScript untuk menampilkan notifikasi
        window.onload = function () {
            alert("<?php echo $response; ?>");
            // Mengarahkan pengguna kembali ke halaman sebelumnya (Anda dapat mengubah URL ini)
            window.location.href = "index.php";
        };
    </script>
</head>
</html>
