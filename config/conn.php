<?php
$host = "127.0.0.1:3308";
$user = "root";
$pass = "admin";
$db = "kampus_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die ("koneksi gagal: ".$conn->connect_error);
}
?>