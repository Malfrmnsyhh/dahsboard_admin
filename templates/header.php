<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$nama_admin = $_SESSION['admin_nama'] ?? 'Admin';
$user_admin = $_SESSION['admin_user'] ?? 'admin';
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SiKampus — Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet"
    href="https://cdn-uicons.flaticon.com/4.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
  <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/4.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css">
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display:ital@0;1&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/variables.css?v=<?= time() ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css?v=<?= time() ?>">
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/sidebar.css?v=<?= time() ?>">

  <style>
    .main-navbar {
      height: 64px;
      padding: 0 1.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid rgba(0, 0, 0, 0.08);
      background: #ffffff;
      position: sticky;
      top: 0;
      z-index: 1030;
      transition: background 0.3s, border-color 0.3s;
    }

    [data-bs-theme="dark"] .main-navbar {
      background: #1a1f2e;
      border-bottom-color: rgba(255, 255, 255, 0.08);
    }

    /* ── Kiri: toggle + logo ── */
    .nav-left {
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .btn-sidebar-toggle {
      width: 38px;
      height: 38px;
      border: none;
      background: transparent;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--navy);
      font-size: 1.2rem;
      transition: background 0.2s;
    }

    .btn-sidebar-toggle:hover {
      background: rgba(15, 31, 61, 0.07);
    }

    [data-bs-theme="dark"] .btn-sidebar-toggle {
      color: #e2e8f0;
    }

    [data-bs-theme="dark"] .btn-sidebar-toggle:hover {
      background: rgba(255, 255, 255, 0.07);
    }

    .brand-logo {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      text-decoration: none;
    }

    .brand-icon {
      width: 34px;
      height: 34px;
      background: var(--navy);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem;
    }

    [data-bs-theme="dark"] .brand-icon {
      background: var(--gold);
    }

    .brand-text {
      font-family: 'DM Serif Display', serif;
      font-size: 1.15rem;
      color: var(--navy);
      line-height: 1;
    }

    [data-bs-theme="dark"] .brand-text {
      color: #f1f5f9;
    }

    .brand-sub {
      font-size: 0.62rem;
      text-transform: uppercase;
      letter-spacing: 0.07em;
      color: #94a3b8;
      font-weight: 300;
    }

    /* ── Kanan: darkmode + profile ── */
    .nav-right {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* Dark mode button */
    .btn-darkmode {
      width: 38px;
      height: 38px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      background: transparent;
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 1.05rem;
      color: #64748b;
      transition: all 0.2s;
    }

    .btn-darkmode:hover {
      background: rgba(15, 31, 61, 0.06);
      color: var(--navy);
    }

    [data-bs-theme="dark"] .btn-darkmode {
      border-color: rgba(255, 255, 255, 0.1);
      color: #94a3b8;
    }

    [data-bs-theme="dark"] .btn-darkmode:hover {
      background: rgba(255, 255, 255, 0.07);
      color: var(--gold);
    }

    /* Profile dropdown */
    .profile-btn {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      padding: 0.3rem 0.75rem 0.3rem 0.3rem;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 30px;
      background: transparent;
      cursor: pointer;
      transition: background 0.2s;
      text-decoration: none;
    }

    .profile-btn:hover {
      background: rgba(15, 31, 61, 0.05);
    }

    [data-bs-theme="dark"] .profile-btn {
      border-color: rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme="dark"] .profile-btn:hover {
      background: rgba(255, 255, 255, 0.06);
    }

    .profile-avatar {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: var(--navy);
      color: var(--gold);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      flex-shrink: 0;
    }

    [data-bs-theme="dark"] .profile-avatar {
      background: var(--gold);
      color: var(--navy);
    }

    .profile-name {
      font-size: 0.85rem;
      font-weight: 500;
      color: var(--navy);
      max-width: 120px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    [data-bs-theme="dark"] .profile-name {
      color: #e2e8f0;
    }

    .profile-chevron {
      font-size: 0.7rem;
      color: #94a3b8;
    }

    /* Dropdown menu */
    .dropdown-menu {
      border: 1px solid rgba(0, 0, 0, 0.08);
      border-radius: 10px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      padding: 0.4rem;
      min-width: 180px;
    }

    .dropdown-item {
      border-radius: 6px;
      font-size: 0.85rem;
      padding: 0.5rem 0.75rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .dropdown-item.text-danger:hover {
      background: #fff0f0;
    }
  </style>
</head>

<body>

  <nav class="main-navbar">
    <div class="nav-left">
      <button class="btn-sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
        <i class="fi fi-rr-bars-staggered"></i>
      </button>

      <!-- Logo -->
      <a href="../dashboard.php" class="brand-logo">
        <div class="brand-icon">🎓</div>
        <div>
          <div class="brand-text">SiKampus</div>
          <div class="brand-sub">Sistem Informasi Akademik</div>
        </div>
      </a>
    </div>

    <div class="nav-right">

      <button class="btn-darkmode" id="darkModeBtn" title="Toggle Dark Mode">
        <i class="fi fi-rr-moon" id="darkModeIcon"></i>
      </button>

      <div class="dropdown">
        <a class="profile-btn dropdown-toggle-custom" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="profile-avatar">
            <?= strtoupper(substr($nama_admin, 0, 2)) ?>
          </div>
          <span class="profile-name"><?= htmlspecialchars($nama_admin) ?></span>
          <i class="fi fi-rr-angle-small-down profile-chevron"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <span class="dropdown-item-text text-muted" style="font-size:0.75rem; padding: 0.4rem 0.75rem;">
              @<?= htmlspecialchars($user_admin) ?>
            </span>
          </li>
          <li>
            <hr class="dropdown-divider my-1">
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <i class="fi fi-rr-user"></i> Profil Saya
            </a>
          </li>
          <li>
            <a class="dropdown-item text-danger" href="<?= BASE_URL ?>auth/logout.php">
              <i class="fi fi-rr-sign-out-alt"></i> Logout
            </a>
          </li>
        </ul>
      </div>

    </div>
  </nav>
  <!-- Mulai Wrapper (Sidebar & Main Content) -->
  <div class="wrapper">