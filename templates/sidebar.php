<?php
// Deteksi halaman aktif berdasarkan URL sekarang
// basename() → ambil nama file saja dari full path
// Contoh: /project/modules/mahasiswa/index.php → index.php
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));

// Helper: return class 'active' kalau cocok
function isActive($dir = '', $file = '')
{
  global $current_dir, $current_page;
  if ($dir && $current_dir !== $dir)
    return '';
  if ($file && $current_page !== $file)
    return '';
  return 'active';
}
?>

<aside class="sidebar" id="sidebar">

  <nav class="sidebar-nav">

    <!-- ── Group: Utama ── -->
    <ul class="nav-list">
      <li>
        <a href="<?= BASE_URL ?>dashboard.php" class="nav-item <?= isActive('', 'dashboard.php') ?>">
          <i class="fi fi-rr-chart-pie nav-icon"></i>
          <span class="nav-label">Dashboard</span>
        </a>
      </li>
    </ul>

    <!-- ── Group: Data Akademik ── -->
    <div class="nav-group-label">Data Akademik</div>
    <ul class="nav-list">
      <li>
        <a href="<?= BASE_URL ?>modules/mahasiswa/index.php" class="nav-item <?= isActive('mahasiswa') ?>">
          <i class="fi fi-rr-user nav-icon"></i>
          <span class="nav-label">Mahasiswa</span>
        </a>
      </li>
      <li>
        <a href="<?= BASE_URL ?>modules/dosen/index.php" class="nav-item <?= isActive('dosen') ?>">
          <i class="fi fi-rr-chalkboard-user nav-icon"></i>
          <span class="nav-label">Dosen</span>
        </a>
      </li>
    </ul>

    <!-- ── Group: Sistem ── -->
    <div class="nav-group-label">Sistem</div>
    <ul class="nav-list">
      <li>
        <a href="#" class="nav-item <?= isActive('', 'settings.php') ?>">
          <i class="fi fi-rr-settings nav-icon"></i>
          <span class="nav-label">Pengaturan</span>
        </a>
      </li>
    </ul>

  </nav>

  <!-- ── Logout di bawah ── -->
  <div class="sidebar-footer">
    <a href="<?= BASE_URL ?>auth/logout.php" class="nav-item nav-logout">
      <i class="fi fi-rr-sign-out-alt nav-icon"></i>
      <span class="nav-label">Logout</span>
    </a>
  </div>

</aside>