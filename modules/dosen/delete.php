<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once '../../config/conn.php';

if (!isset($_SESSION['admin_user'])) {
  header("Location: ../../index.php");
  exit;
}

if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $query = "DELETE FROM dosen WHERE id_dosen = $id";
  if ($conn->query($query)) {
    $_SESSION['success'] = 'Data Dosen berhasil dihapus!.';
  }
}
header("Location: index.php");
exit;
?>