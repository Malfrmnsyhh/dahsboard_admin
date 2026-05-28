<?php
define('BASE_URL', '/Project/');
require_once '../../config/middleware.php';
require_once '../../config/conn.php';
check_auth();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $conn->real_escape_string($_POST['nim']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $no_telp = $conn->real_escape_string($_POST['no_telp']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $jk = $conn->real_escape_string($_POST['jenis_kelamin']);
    $tgl_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
    $prodi = $conn->real_escape_string($_POST['program_studi']);
    $angkatan = (int)$_POST['angkatan'];
    $status = $conn->real_escape_string($_POST['status']);

    $query = "INSERT INTO mahasiswa (nim, nama, email, no_telp, alamat, jenis_kelamin, tanggal_lahir, program_studi, angkatan, status) 
              VALUES ('$nim', '$nama', '$email', '$no_telp', '$alamat', '$jk', '$tgl_lahir', '$prodi', $angkatan, '$status')";
              
    if ($conn->query($query)) {
        $_SESSION['success'] = "Data mahasiswa berhasil ditambahkan!";
        header("Location: index.php");
        exit;
    } else {
        $error = "Error: " . $conn->error;
    }
}

require_once '../../templates/header.php';
require_once '../../templates/sidebar.php';
?>

<main class="main-content">
  <div class="container-fluid p-4">
    <div class="mb-4">
        <h2 class="mb-1" style="color: var(--prussian-blue); font-weight: 700;">Tambah Mahasiswa</h2>
        <a href="index.php" class="text-decoration-none" style="color: var(--orange);"><i class="fi fi-rr-arrow-left"></i> Kembali ke data mahasiswa</a>
    </div>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-4">
        <form action="" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">NIM</label>
                    <input type="text" class="form-control" name="nim" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Email</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">No. Telepon</label>
                    <input type="text" class="form-control" name="no_telp">
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3"></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Angkatan</label>
                    <input type="number" class="form-control" name="angkatan" required min="2000" max="2099" value="<?= date('Y') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Program Studi</label>
                    <select class="form-select" name="program_studi" required>
                        <option value="Teknik Informatika">Teknik Informatika</option>
                        <option value="Sistem Informasi">Sistem Informasi</option>
                        <option value="Ilmu Komputer">Ilmu Komputer</option>
                        <option value="Teknik Elektro">Teknik Elektro</option>
                        <option value="Manajemen Bisnis">Manajemen Bisnis</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Status</label>
                    <select class="form-select" name="status">
                        <option value="Aktif">Aktif</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Lulus">Lulus</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--prussian-blue); border-color: var(--prussian-blue);">Simpan Data</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php require_once '../../templates/footer.php'; ?>
