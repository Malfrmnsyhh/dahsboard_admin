<?php
define('BASE_URL', '/Project/');
require_once '../../config/middleware.php';
require_once '../../config/conn.php';
check_auth();

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

// Search functionality
$search = isset($_GET['q']) ? $_GET['q'] : '';
$queryString = $search ? '&q=' . urlencode($search) : '';
$where = "";
if ($search != '') {
  $search_esc = $conn->real_escape_string($search);
  $where = "WHERE nim LIKE '%$search_esc%' OR nama LIKE '%$search_esc%' OR program_studi LIKE '%$search_esc%'";
}

// Get total records
$result = $conn->query("SELECT COUNT(id_mahasiswa) AS total FROM mahasiswa $where");
$total = $result->fetch_assoc()['total'];
$pages = ceil($total / $limit);

// Fetch data
$query = "SELECT * FROM mahasiswa $where ORDER BY created_at DESC LIMIT $start, $limit";
$mahasiswa = $conn->query($query);

require_once '../../templates/header.php';
require_once '../../templates/sidebar.php';
?>

<div class="modal fade" id="modalHapus" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-body p-4 text-center">
        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
          style="width:64px;height:64px;background:rgba(220,53,69,0.1);">
          <i class="fi fi-rr-trash fs-3 text-danger"></i>
        </div>
        <h5 class="fw-bold mb-1">Hapus Data Mahasiswa?</h5>
        <p class="text-muted mb-0">Anda akan menghapus data:</p>
        <p class="fw-semibold mb-3" id="namaHapus" style="color:var(--prussian-blue)"></p>
        <p class="text-muted" style="font-size:0.85rem;">
          Konfirmasi untuk menghapus data!
        </p>
      </div>
      <div class="modal-footer border-0 justify-content-center pb-4 gap-2">
        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
          Batal
        </button>
        <a href="#" id="linkHapus" class="btn btn-danger px-4">
          Ya, Hapus
        </a>
      </div>
    </div>
  </div>
</div>

<main class="main-content">
  <div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="mb-1" style="color: var(--prussian-blue); font-weight: 700;">Data Mahasiswa</h2>
        <p class="text-muted mb-0">Manajemen data mahasiswa SiKampus</p>
      </div>
      <a href="create.php" class="btn btn-primary"
        style="background-color: var(--orange); border-color: var(--orange);">
        <i class="fi fi-rr-plus"></i> Tambah Mahasiswa
      </a>
    </div>

    <!-- Alert Success -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success'];
        unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4">
      <div class="card-body p-4">

        <!-- Filter & Search -->
        <div class="row mb-3">
          <div class="col-md-4 ms-auto">
            <form action="" method="GET">
              <div class="input-group">
                <input type="text" class="form-control" name="q" placeholder="Cari Nama/NIM..."
                  value="<?= htmlspecialchars($search) ?>">
                <button class="btn btn-outline-secondary" type="submit"
                  style="color: var(--space-indigo); border-color: #ced4da;">Cari</button>
              </div>
            </form>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama Lengkap</th>
                <th>Program Studi</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($mahasiswa->num_rows > 0): ?>
                <?php $no = $start + 1;
                while ($row = $mahasiswa->fetch_assoc()): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><span class="badge bg-secondary"><?= htmlspecialchars($row['nim']) ?></span></td>
                    <td>
                      <strong><?= htmlspecialchars($row['nama']) ?></strong><br>
                      <small class="text-muted"><?= htmlspecialchars($row['email']) ?></small>
                    </td>
                    <td><?= htmlspecialchars($row['program_studi']) ?> (<?= htmlspecialchars($row['angkatan']) ?>)</td>
                    <td>
                      <?php if ($row['status'] == 'Aktif'): ?>
                        <span class="badge" style="background-color: var(--space-indigo);">Aktif</span>
                      <?php elseif ($row['status'] == 'Lulus'): ?>
                        <span class="badge bg-success">Lulus</span>
                      <?php else: ?>
                        <span class="badge bg-warning text-dark">Cuti</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <a href="edit.php?id=<?= $row['id_mahasiswa'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                        <i class="fi fi-rr-edit"></i>
                      </a>
                      <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalHapus"
                        data-id="<?= $row['id_mahasiswa'] ?>" data-nama="<?= htmlspecialchars($row['nama']) ?>" title="Hapus">
                        <i class="fi fi-rr-trash"></i>
                      </button>
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">Belum ada data mahasiswa.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <?php if ($pages > 1): ?>
          <nav aria-label="Navigasi Halaman" class="mt-4">
            <ul class="pagination justify-content-center">

              <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($page <= 1) ? '#' : '?page=' . ($page - 1) . $queryString ?>"
                  tabindex="-1" <?= ($page <= 1) ? 'aria-disabled="true"' : '' ?> style="color: var(--prussian-blue);">
                  Previous
                </a>
              </li>

              <?php
              $range = 1;
              $show_initial_dots = true;
              $show_end_dots = true;

              for ($i = 1; $i <= $pages; $i++) {
                if ($i == 1 || $i == $pages || ($i >= $page - $range && $i <= $page + $range)) {
                  if ($page == $i): ?>
                    <li class="page-item active" aria-current="page">
                      <a class="page-link" href="#"
                        style="background-color: var(--prussian-blue); border-color: var(--prussian-blue); color: white;">
                        <?= $i ?> <span class="visually-hidden">(current)</span>
                      </a>
                    </li>
                  <?php else: ?>
                    <li class="page-item">
                      <a class="page-link" href="?page=<?= $i ?><?= $queryString ?>" style="color: var(--prussian-blue);">
                        <?= $i ?>
                      </a>
                    </li>
                  <?php endif;
                } else {
                  if ($i < $page - $range && $show_initial_dots) {
                    echo '<li class="page-item disabled"><span class="page-link" style="border: none; background: none; color: var(--prussian-blue);">...</span></li>';
                    $show_initial_dots = false;
                    $i = $page - $range - 1;
                  } elseif ($i > $page + $range && $show_end_dots) {
                    echo '<li class="page-item disabled"><span class="page-link" style="border: none; background: none; color: var(--prussian-blue);">...</span></li>';
                    $show_end_dots = false;
                    $i = $pages - 1;
                  }
                }
              }
              ?>

              <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= ($page >= $pages) ? '#' : '?page=' . ($page + 1) . $queryString ?>"
                  <?= ($page >= $pages) ? 'aria-disabled="true"' : '' ?> style="color: var(--prussian-blue);">
                  Next
                </a>
              </li>

            </ul>
          </nav>
        <?php endif; ?>

      </div>
    </div>
  </div>
</main>
<script>
  document.getElementById('modalHapus').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    const id = btn.getAttribute('data-id');
    const nama = btn.getAttribute('data-nama');

    document.getElementById('namaHapus').textContent = nama;
    document.getElementById('linkHapus').href = 'delete.php?id=' + id;
  });
</script>
<?php require_once '../../templates/footer.php'; ?>