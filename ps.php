<?php
session_start();

if (!isset($_SESSION['user_type'])) {
    header("Location: login.php");
    exit();
}
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <title>PS Page</title>
</head>
<body>
<body>
    <header>
    <h1>Data Absensi Shalat Jumat</h1>
    </header>

    <div class="container">
        <table border='1'>
            <tr><th>Student ID</th><th>Name</th><th>Rayon</th><th>Attendance</th></tr>

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
