<?php
// Include your database connection code here
$host = "localhost";
$username = "root";
$password = "";
$database = "absensi_jumat";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["student_id"]) && isset($_POST["attendance"])) {
    // Retrieve data from the form
    $student_id = $_POST["student_id"];
    $attendance = $_POST["attendance"];

    // Update the attendance status in the database
    $update_sql = "UPDATE murid SET hadir = '$attendance' WHERE nis = '$student_id'";
    if (mysqli_query($conn, $update_sql)) {
        $message = "Attendance updated successfully.";
        echo "<script>
            alert('$message');
            window.history.back();
        </script>";
    } else {
        echo "Error updating attendance: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>
