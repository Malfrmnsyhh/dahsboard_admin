<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

function check_auth() {
  if (!isset($_SESSION['admin_id'])) {
    header("Location: /Project/auth/login.php");
    exit;
  }
}

function logout_admin() {
  session_start();
  session_destroy();
  unset($_SESSION['admin_id']);
  unset($_SESSION['admin_nama']);
  unset($_SESSION['admin_user']);
  setcookie("PHPSESSID", "", time() - 3600, "/");
  header("Location: /Project/auth/login.php?logout=success");
  exit;
}

function get_admin_info() {
  return [
    'id' => $_SESSION['admin_id'] ?? null,
    'nama' => $_SESSION['admin_nama'] ?? 'Admin',
    'username' => $_SESSION['admin_user'] ?? 'admin',
  ];
}
?>
