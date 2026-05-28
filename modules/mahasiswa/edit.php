<?php
define('BASE_URL', '/Project/');
require_once '../../config/middleware.php';
require_once '../../config/conn.php';
check_auth();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM mahasiswa WHERE id_mahasiswa = $id";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    header("Location: index.php");
    exit;
}
$mhs = $result->fetch_assoc();

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

    $updateQuery = "UPDATE mahasiswa SET 
                    nim='$nim', nama='$nama', email='$email', no_telp='$no_telp', 
                    alamat='$alamat', jenis_kelamin='$jk', tanggal_lahir='$tgl_lahir', 
                    program_studi='$prodi', angkatan=$angkatan, status='$status'
                    WHERE id_mahasiswa=$id";
              
    if ($conn->query($updateQuery)) {
        $_SESSION['success'] = "Data mahasiswa berhasil diperbarui!";
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
        <h2 class="mb-1" style="color: var(--prussian-blue); font-weight: 700;">Edit Mahasiswa</h2>
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
                    <input type="text" class="form-control" name="nim" required value="<?= htmlspecialchars($mhs['nim']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama" required value="<?= htmlspecialchars($mhs['nama']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($mhs['email']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">No. Telepon</label>
                    <input type="text" class="form-control" name="no_telp" value="<?= htmlspecialchars($mhs['no_telp']) ?>">
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="3"><?= htmlspecialchars($mhs['alamat']) ?></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin">
                        <option value="Laki-laki" <?= $mhs['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $mhs['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Tanggal Lahir</label>
                    <input type="date" class="form-control" name="tanggal_lahir" value="<?= htmlspecialchars($mhs['tanggal_lahir']) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Angkatan</label>
                    <input type="number" class="form-control" name="angkatan" required min="2000" max="2099" value="<?= htmlspecialchars($mhs['angkatan']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Program Studi</label>
                    <select class="form-select" name="program_studi" required>
                        <?php 
                        $prodis = ['Teknik Informatika', 'Sistem Informasi', 'Ilmu Komputer', 'Teknik Elektro', 'Manajemen Bisnis'];
                        foreach($prodis as $p) {
                            $sel = ($mhs['program_studi'] == $p) ? 'selected' : '';
                            echo "<option value='$p' $sel>$p</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-bold" style="font-size: 0.85rem;">Status</label>
                    <select class="form-select" name="status">
                        <option value="Aktif" <?= $mhs['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Cuti" <?= $mhs['status'] == 'Cuti' ? 'selected' : '' ?>>Cuti</option>
                        <option value="Lulus" <?= $mhs['status'] == 'Lulus' ? 'selected' : '' ?>>Lulus</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 pt-3 border-top">
                <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--prussian-blue); border-color: var(--prussian-blue);">Update Data</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php require_once '../../templates/footer.php'; ?>
