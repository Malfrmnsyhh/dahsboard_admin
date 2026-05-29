<?php
define('BASE_URL', '/Project/');
require_once '../../config/middleware.php';
require_once '../../config/conn.php';
check_auth();

$id_admin = $_SESSION['admin_id'];


// 1. Proses Update Profil Dasar
if (isset($_POST['update_profil'])) {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);

    $query = "UPDATE admin SET nama='$nama', email='$email' WHERE id_admin=$id_admin";
    if ($conn->query($query)) {
        $_SESSION['admin_nama'] = $nama; // Update session
        $_SESSION['success_profil'] = "Profil berhasil diperbarui!";
    } else {
        $_SESSION['error_profil'] = "Gagal memperbarui profil: " . $conn->error;
    }
    header("Location: index.php");
    exit;
}

// 2. Proses Ganti Password
if (isset($_POST['update_password'])) {
    $pass_lama = $_POST['password_lama'];
    $pass_baru = $_POST['password_baru'];
    $pass_konfirm = $_POST['password_konfirmasi'];

    // Ambil data admin saat ini untuk mengecek password lama
    $res = $conn->query("SELECT password FROM admin WHERE id_admin=$id_admin");
    $admin_data = $res->fetch_assoc();

    if (password_verify($pass_lama, $admin_data['password'])) {
        if ($pass_baru === $pass_konfirm) {
            if (strlen($pass_baru) >= 6) {
                $hash_baru = password_hash($pass_baru, PASSWORD_DEFAULT);
                $conn->query("UPDATE admin SET password='$hash_baru' WHERE id_admin=$id_admin");
                $_SESSION['success_password'] = "Password berhasil diubah! Silakan gunakan password baru pada saat login berikutnya.";
            } else {
                $_SESSION['error_password'] = "Password baru minimal 6 karakter.";
            }
        } else {
            $_SESSION['error_password'] = "Konfirmasi password baru tidak cocok.";
        }
    } else {
        $_SESSION['error_password'] = "Password lama yang Anda masukkan salah.";
    }
    header("Location: index.php");
    exit;
}

// Ambil data Admin terbaru
$query = "SELECT * FROM admin WHERE id_admin=$id_admin";
$admin = $conn->query($query)->fetch_assoc();

require_once '../../templates/header.php';
require_once '../../templates/sidebar.php';
?>

<main class="main-content">
  <div class="container-fluid p-4">
    <div class="mb-4">
        <h2 class="mb-1" style="color: var(--prussian-blue); font-weight: 700;">Profil Saya</h2>
        <p class="text-muted mb-0">Kelola informasi pribadi dan keamanan akun Anda</p>
    </div>

    <div class="row g-4">
        <!-- Kolom Kiri: Info Dasar -->
        <div class="col-lg-6">
            <div class="card border-1 shadow-sm rounded-4 h-100">
                <div class="card-header border-bottom-0 pt-4 pb-0 px-4" style="background-color: var(--navy-mid);">
                    <h5 class="fw-bold text-center mb-3" style="color: white;">Informasi Dasar</h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if (isset($_SESSION['success_profil'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success_profil']; unset($_SESSION['success_profil']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error_profil'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error_profil']; unset($_SESSION['error_profil']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="profile-avatar-large" style="width: 70px; height: 70px; border-radius: 50%; background: var(--prussian-blue); color: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: bold; margin-right: 1rem;">
                            <?= strtoupper(substr($admin['nama'], 0, 2)) ?>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold"><?= htmlspecialchars($admin['nama']) ?></h5>
                            <span class="badge" style="background-color: var(--orange);">@<?= htmlspecialchars($admin['username']) ?></span>
                        </div>
                    </div>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Username (Tidak bisa diubah)</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($admin['username']) ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($admin['nama']) ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Alamat Email</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars(isset($admin['email']) ? $admin['email'] : '') ?>" placeholder="admin@kampus.ac.id">
                        </div>
                        <button type="submit" name="update_profil" class="btn btn-primary px-4 py-2" style="background-color: var(--gold-lt); border-color: var(--gold-lt);">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Ganti Password -->
        <div class="col-lg-6">
            <div class="card border-1 shadow-sm rounded-4 h-100" >
                <div class="card-header border-bottom-0 pt-4 pb-0 px-4" style="background-color: var(--navy-mid)">
                    <h5 class="fw-bold mb-3 text-center" style="color: var(--white);">Keamanan Akun</h5>
                </div>
                <div class="card-body p-4">

                    <?php if (isset($_SESSION['success_password'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success_password']; unset($_SESSION['success_password']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error_password'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error_password']; unset($_SESSION['error_password']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Password Lama</label>
                            <input type="password" class="form-control" name="password_lama" required placeholder="Masukkan password saat ini">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Password Baru</label>
                            <input type="password" class="form-control" name="password_baru" required placeholder="Minimal 6 karakter">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="password_konfirmasi" required placeholder="Ketik ulang password baru">
                        </div>
                        <button type="submit" name="update_password" class="btn btn-warning px-4 py-2" style="background-color: var(--orange); border-color: var(--orange); color: white; font-weight: 500;">
                            <i class="fi fi-rr-key"></i> Perbarui Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</main>

<?php require_once '../../templates/footer.php'; ?>
