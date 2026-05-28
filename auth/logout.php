<?php

require_once '../config/middleware.php';

if (isset($_SESSION['admin_id'])) {
  logout_admin();
} else {
  header("Location: login.php");
  exit;
}
?>
