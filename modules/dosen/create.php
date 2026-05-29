<?php
define('BASE_URL', '/Project/');
require_once '../../config/middleware.php';
require_once '../../config/conn.php';

check_auth();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nip = $conn->real_escape_string($_POST['nim']);
  $nama = $conn->real_escape_string($_POST['nama']);
  $email = $conn->real_escape_string($_POST['email']);
  $no_telp = $conn->real_escape_string($_POST['no_telp']);
  $alamat = $conn->real_escape_string($_POST['alamat']);
  $jk = $conn->real_escape_string($_POST['jenis_kelamin']);
  $tgl_lahir = $conn->real_escape_string($_POST['tanggal_lahir']);
  $prodi = $conn->real_escape_string($_POST['program_studi']);
  $gelar_akademik = $conn->real_escape_string($_POST['gelar_akademik']);
  $status = $conn->real_escape_string($_POST['status']);

  $query = "INSERT INTO dosen (nip, nama, email, no_telp, alamat, jenis_kelamin, tanggal_lahir, program_studi, gelar_akademik, status) 
            VALUES ('$nip', '$nama', '$email', '$no_telp', '$alamat', '$jk', '$tgl_lahir', '$prodi', '$gelar_akademik', '$status')";

  if ($conn->query($query)) {
    $_SESSION['success'] = "Data dosen berhasil di tambahkan!";
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
      <h2 class="mb-1" style="color: var(--prussian-blue); font-weight: 700;">Tambah Dosen</h2>
      <a href="index.php" class="text-decoration-none" style="color: var(--orange);"><i class="fi fi-rr-arrow-left"></i>
        Kembali ke data Dosen</a>
    </div>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-4">
        <form action="" method="POST">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">NIP</label>
              <input type="text" class="form-control" name="nim" required placeholder="198312012787007">
            </div>
            <div class="col-md-4">
              <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Nama Lengkap</label>
              <input type="text" class="form-control" name="nama" required placeholder="Nama Lengkap Beserta gelar">
            </div>
            <div class="col-md-4">
              <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Gelar Akademik</label>
              <input type="text" class="form-control" name="gelar_akademik" placeholder="contoh: Dr. , S.Kom., M.Kom." required>
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Email</label>
              <input type="email" class="form-control" name="email" placeholder="nama@prodiupnjatim.ac.id">
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">No. Telepon</label>
              <input type="text" class="form-control" name="no_telp" placeholder="08xxxxxxxxxx">
            </div>
            <div class="col-md-12">
              <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Alamat</label>
              <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat tempat tinggal"></textarea>
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Tanggal Lahir</label>
              <input type="date" class="form-control" name="tanggal_lahir">
            </div>
            <div class="col-md-6">
              <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Jenis Kelamin</label>
              <select class="form-select" name="jenis_kelamin">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
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
                <option value="Lulus">Pensiun</option>
              </select>
            </div>
          </div>
          <div class="mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary px-4 py-2"
              style="background-color: var(--prussian-blue); border-color: var(--prussian-blue);">Simpan Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php require_once '../../templates/footer.php'; ?>