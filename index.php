<?php
session_start();

if (!isset($_SESSION['user_type'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['user_type'] !== 'admin') {

    $_SESSION['error_message'] = "Access denied. You do not have permission to view this page.";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=".css">

    <script>
        function showNotification(message) {
            var notification = document.getElementById('notification');
            notification.innerText = message;
            notification.style.display = 'block';
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000); // 3000 milliseconds (3 seconds)
        }
    </script>
    <style>
        body {
        font-family: 'Arial', sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        color: #333;
    }

    header {
        background-color: #007acc;
        color: #fff;
        text-align: center;
        padding: 20px 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table, th, td {
        border: 1px solid #ddd;
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #007acc;
        color: #fff;
    }

    table tr:hover {
        background-color: #f5f5f5;
    }

    form {
        margin-top: 20px;
    }

    label {
        display: block;
        font-weight: bold;
    }

    input[type="text"] {
        width: 97%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"], .logout-button {
        background-color: #007acc;
        color: #fff;
        border: none;
        padding: 12px 20px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover, .logout-button:hover {
    background-color: #005a9e;
    transform: scale(1.05); /* Add a scaling effect on hover */
    transition: background-color 0.3s, transform 0.3s;
    }


    .add-student-form {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 5px;
        margin-top: 20px;
    }

    .student-log-table {
        margin-top: 20px;
    }

    h1 {
        font-size: 36px;
        border: 2px solid #005a9e;
        padding: 10px 20px;
        display: inline-block;
        margin: 0 auto;
        margin-top: 20px;
        border-radius: 10px;
    }

    .notification {
        display: none;
        background-color: #4CAF50;
        color: white;
        text-align: center;
        padding: 10px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9999;
    }

        .logout-container {
            text-align: center;
            margin-top: 20px;
        }

        .logout-button {
            background-color: #007acc;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            display: inline-block;
            margin-bottom: 20px;
        }

        .logout-button:hover {
            background-color: #005a9e;
        }
    </style>
    
    <title>Absensi Jumat</title>
</head>
<div id="notification" class="notification"></div>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <header>
            <h1>Data Absensi Shalat Jumat</h1>
    </header>


    <?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "absensi_jumat";

    $conn = mysqli_connect($host, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_add_student"])) {
        $nama = $_POST["nama"];
        $nis = $_POST["nis"];
        $rayon = $_POST["rayon"];
        $rombel = $_POST["rombel"];
        $jk = $_POST["jk"];
    
        $insert_sql = "INSERT INTO murid (nama, nis, rayon, rombel, jk) VALUES ('$nama', '$nis', '$rayon', '$rombel', '$jk')";
        if (mysqli_query($conn, $insert_sql) or die(mysqli_error($conn))) {
            echo "<script>showNotification('Student data added successfully.');</script>";
        } else {    
            echo "Error adding student data: " . mysqli_error($conn);
        }        
    }
    

    $sql = "SELECT * FROM murid ORDER BY rayon";
    $result = mysqli_query($conn, $sql);

    ?>
    <div class="container">
    <?php

    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Student ID</th><th>Name</th><th>Rayon</th><th>Attendance</th><th>Edit</th></tr>"; 
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["nis"] . "</td>";
            echo "<td>" . $row["nama"] . "</td>";
            echo "<td>" . $row["rayon"] . "</td>";
            echo "<td>";
            echo "<form method='post' action='update.php'>";
            echo "<input type='hidden' name='student_id' value='" . $row["nis"] . "'>";
            echo "<input type='radio' name='attendance' value='Present' checked> Present ";
            echo "<input type='radio' name='attendance' value='Absent'> Absent ";
            echo "</td>";
            echo "<td>";
            echo "<input type='submit' value=' Submit '>";
            echo "</form>";
            echo "<form method='post' action='remove.php'>";
            echo "<input type='hidden' name='student_id' value='" . $row["nis"] . "'>";
            echo "<input type='submit' name='remove_student' value='Remove'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        

        echo "</table>";
    } else {
        echo "No students found.";
    }

    mysqli_close($conn);
    ?>
        <!-- Add Student Form -->
        <h2>Add Student</h2>
        <form method="post" action="">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" required><br>
        <label for="nis">NIS (Student ID):</label>
        <input type="text" name="nis" required><br>
        <label for="rayon">Rayon:</label>
        <input type="text" name="rayon" required><br>
        <label for="rombel">Rombel:</label>
        <input type="text" name="rombel" required><br>
        <label for="jk">Jenis Kelamin:</label>
        <input type="text" name="jk" required><br>
        <input type="submit" name="submit_add_student" value="Add Student">
    </form>
        <h2>Student Log</h2>
        <table id="log-table">
            <?php
                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "absensi_jumat";

                $conn = mysqli_connect($host, $username, $password, $database);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $sql = "SELECT * FROM murid ORDER BY rayon";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    echo "<tr><th>Student ID</th><th>Name</th><th>Rayon</th><th>Attendance</th></tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["nis"] . "</td>";
                        echo "<td>" . $row["nama"] . "</td>";
                        echo "<td>" . $row["rayon"] . "</td>";
                        echo "<td>" . $row["hadir"] . "</td>"; 
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No students found.</td></tr>";
                }
                mysqli_close($conn);
            ?>
        </table>
    </div>
    <div class="logout-container">
        <a class="logout-button" href="logout.php">Logout</a>
    </div>
</body>
</html>


