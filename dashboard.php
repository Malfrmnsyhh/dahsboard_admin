<?php
define('BASE_URL', '/Project/');
require_once 'config/middleware.php';
require_once 'config/conn.php';
check_auth();

// Query Statistik
$resMhs = $conn->query("SELECT COUNT(*) as total FROM mahasiswa");
$totMhs = $resMhs->fetch_assoc()['total'];

$resDsn = $conn->query("SELECT COUNT(*) as total FROM dosen");
$totDsn = $resDsn->fetch_assoc()['total'];

$resMhsAktif = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE status = 'Aktif'");
$totMhsAktif = $resMhsAktif->fetch_assoc()['total'];

$resMhsLulus = $conn->query("SELECT COUNT(*) as total FROM mahasiswa WHERE status = 'Lulus'");
$totMhsLulus = $resMhsLulus->fetch_assoc()['total'];

$resDsnAktif = $conn->query("SELECT COUNT(*) as total FROM dosen WHERE status = 'Aktif'");
$totDsnAktif = $resDsnAktif->fetch_assoc()['total'];

require_once 'templates/header.php';
require_once 'templates/sidebar.php'; 
?>

<!-- Main Content Area -->
<main class="main-content">
  <div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1" style="color: var(--prussian-blue); font-weight: 700;">Dashboard</h2>
            <p class="text-muted mb-0">Selamat datang kembali, <strong><?= htmlspecialchars($_SESSION['user']['nama'] ?? 'Admin') ?></strong>!</p>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-5">
        <!-- Card Total Mahasiswa -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, var(--space-indigo) 0%, var(--prussian-blue) 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 opacity-75 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem; text-primary">Total Mahasiswa</p>
                            <h2 class="display-5 fw-bold mb-0"><?= number_format($totMhs) ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                            <i class="fi fi-rr-users-class fs-3" style="color: var(--orange)"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Mahasiswa Aktif -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: white; border-left: 5px solid var(--orange) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem; color: white;">Mahasiswa Aktif</p>
                            <h2 class="display-5 fw-bold mb-0" style="color: var(--space-indigo);"><?= number_format($totMhsAktif) ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(252, 163, 17, 0.1);">
                            <i class="fi fi-rr-student fs-3" style="color: var(--orange);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: white; border-left: 5px solid var(--orange) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem; color: white;">Mahasiswa Lulus</p>
                            <h2 class="display-5 fw-bold mb-0" style="color: var(--space-indigo);"><?= number_format($totMhsLulus) ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(252, 163, 17, 0.1);">
                            <i class="fi fi-rr-graduation-cap fs-3" style="color: var(--orange);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Total Dosen -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: white; border-left: 5px solid var(--prussian-blue) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem;">Total Dosen</p>
                            <h2 class="display-5 fw-bold mb-0" style="color: var(--space-indigo);"><?= number_format($totDsn) ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(34, 34, 59, 0.1);">
                            <i class="fi fi-rr-chalkboard-user fs-3" style="color: var(--gold-lt);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- total dosen aktif -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: white; border-left: 5px solid var(--prussian-blue) !important;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.8rem;">Total Dosen Aktif</p>
                            <h2 class="display-5 fw-bold mb-0" style="color: var(--space-indigo);"><?= number_format($totDsnAktif) ?></h2>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background: rgba(34, 34, 59, 0.1);">
                            <i class="fi fi-rr-user-check fs-3" style="color: var(--gold-lt);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

  </div>
</main>

<?php require_once 'templates/footer.php'; ?>