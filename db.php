<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pelajar_1"; // Nama DB baru

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Gagal sambung ke DB: " . $conn->connect_error);
}
?>