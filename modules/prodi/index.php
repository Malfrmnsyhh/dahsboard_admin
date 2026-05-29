<?php
define('BASE_URL', '/Project/');
require_once '../../config/middleware.php';
require_once '../../config/conn.php';
check_auth();

$resInfor = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi='Teknik Informatika'");
$totMhsInformatika = $resInfor->fetch_assoc()['total'];

$resSifo = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi='Sistem Informasi'");
$totMhsSiformasi = $resSifo->fetch_assoc()['total'];

$resIlkom = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi='Ilmu Komputer'");
$totMhsIlkom = $resIlkom->fetch_assoc()['total'];

$resElka = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi='Teknik Elektro'");
$totMhsElka = $resElka->fetch_assoc()['total'];

$resSada = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi='Sains Data'");
$totMhsSada = $resSada->fetch_assoc()['total'];

$resBisdi = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi='Bisnis Digital'");
$totMhsBisdi = $resBisdi->fetch_assoc()['total'];

$resTI = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE program_studi='Teknologi Informasi'");
$totMhsTI = $resTI->fetch_assoc()['total'];

require_once '../../templates/header.php';
require_once '../../templates/sidebar.php';
?>

<style>
  .scroll-horizontal {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
  }

  .scroll-horizontal::-webkit-scrollbar {
    height: 6px;
  }

  .scroll-horizontal::-webkit-scrollbar-track {
    background: transparent;
  }

  .scroll-horizontal::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 10px;
  }

  .scroll-horizontal::-webkit-scrollbar-thumb:hover {
    background-color: #94a3b8;
  }
</style>

<main class="main-content">
  <div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-1" style="color: var(--prussian-blue); font-weight: 700;">Detail Statistik Program Studi</h2>
        <p class="text-muted mb-0">Selamat datang kembali,
          <strong><?= htmlspecialchars($_SESSION['user']['nama'] ?? 'Admin') ?></strong>!
        </p>
      </div>
    </div>

    <div class="d-flex flex-nowrap overflow-auto pb-3 mb-4 scroll-horizontal">

      <div class="card border-0 shadow-sm rounded-4 me-3" style="min-width: 250px; flex: 0 0 auto; background-color: var(--cream)">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-primary-subtle text-primary rounded-3 px-3 py-2">IF</span>
            <i class="fi fi-rr-graduation-cap text-muted fs-4"></i>
          </div>
          <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
            Teknik Informatika</h6>
          <h2 class="fw-bold mb-0" style="color: var(--prussian-blue);"><?= $totMhsInformatika ?> <span
              class="fs-6 fw-normal text-muted">Mhs</span></h2>
        </div>
      </div>

      <div class="card border-0 shadow-sm rounded-4 me-3" style="min-width: 250px; flex: 0 0 auto; background-color: var(--cream);">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-success-subtle text-success rounded-3 px-3 py-2">SI</span>
            <i class="fi fi-rr-stats text-muted fs-4"></i>
          </div>
          <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
            Sistem Informasi</h6>
          <h2 class="fw-bold mb-0" style="color: var(--prussian-blue);"><?= $totMhsSiformasi ?> <span
              class="fs-6 fw-normal text-muted">Mhs</span></h2>
        </div>
      </div>

      <div class="card border-0 shadow-sm rounded-4 me-3" style="min-width: 250px; flex: 0 0 auto;background-color: var(--cream);">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-info-subtle text-info rounded-3 px-3 py-2">IK</span>
            <i class="fi fi-rr-computer text-muted fs-4"></i>
          </div>
          <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">Ilmu
            Komputer</h6>
          <h2 class="fw-bold mb-0" style="color: var(--prussian-blue);"><?= $totMhsIlkom ?> <span
              class="fs-6 fw-normal text-muted">Mhs</span></h2>
        </div>
      </div>

      <div class="card border-0 shadow-sm rounded-4 me-3" style="min-width: 250px; flex: 0 0 auto;background-color: var(--cream);">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-warning-subtle text-warning rounded-3 px-3 py-2">TE</span>
            <i class="fi fi-rr-bolt text-muted fs-4"></i>
          </div>
          <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
            Teknik Elektro</h6>
          <h2 class="fw-bold mb-0" style="color: var(--prussian-blue);"><?= $totMhsElka ?> <span
              class="fs-6 fw-normal text-muted">Mhs</span></h2>
        </div>
      </div>

      <div class="card border-0 shadow-sm rounded-4 me-3" style="min-width: 250px; flex: 0 0 auto; background-color: var(--cream);">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-danger-subtle text-danger rounded-3 px-3 py-2">SD</span>
            <i class="fi fi-rr-chart-pie-alt text-muted fs-4"></i>
          </div>
          <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
            Sains Data</h6>
          <h2 class="fw-bold mb-0" style="color: var(--prussian-blue);"><?= $totMhsSada ?> <span
              class="fs-6 fw-normal text-muted">Mhs</span></h2>
        </div>
      </div>

      <div class="card border-0 shadow-sm rounded-4 me-3" style="min-width: 250px; flex: 0 0 auto; background-color: var(--cream);">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge text-secondary rounded-3 px-3 py-2" style="background-color: #e2e8f0;">BD</span>
            <i class="fi fi-rr-shop text-muted fs-4"></i>
          </div>
          <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
            Bisnis Digital</h6>
          <h2 class="fw-bold mb-0" style="color: var(--prussian-blue);"><?= $totMhsBisdi ?> <span
              class="fs-6 fw-normal text-muted">Mhs</span></h2>
        </div>
      </div>

      <div class="card border-0 shadow-sm rounded-4 me-0" style="min-width: 250px; flex: 0 0 auto; background-color: var(--cream);">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-dark-subtle text-muted rounded-3 px-3 py-2">TI</span>
            <i class="fi fi-rr-network text-muted fs-4"></i>
          </div>
          <h6 class="text-muted mb-1 text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
            Teknologi Informasi</h6>
          <h2 class="fw-bold mb-0" style="color: var(--prussian-blue);"><?= $totMhsTI ?> <span
              class="fs-6 fw-normal text-muted">Mhs</span></h2>
        </div>
      </div>

    </div>
    <?php require_once '../../templates/footer.php'; ?>