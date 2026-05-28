<?php

session_start();

if (isset($_SESSION['admin_id'])) {
  header("Location: ../dashboard.php");
  exit;
}

require_once "../config/conn.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
    $error = "Username dan Password wajib diisi";
  } else {
    $stmt = $conn->prepare("SELECT id_admin, username, password, nama FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
      $admin = $result->fetch_assoc();
      if (password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_nama'] = $admin['nama'];
        $_SESSION['admin_user'] = $admin['username'];
        header("Location: ../dashboard.php");
        exit;
      } else {
        $error = "Password salah. Silahkan coba lagi";
      }
    } else {
      $error = "Username tidak ditemukan";
    }
    $stmt->close();
  }

}

$resMhs = $conn->query("SELECT COUNT(*) as total FROM mahasiswa");
$totMhs = $resMhs->fetch_assoc()['total'];

$resDsn = $conn->query("SELECT COUNT(*) as total FROM dosen");
$totDsn = $resDsn->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Indformasi Kampus</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap"
    rel="stylesheet">
  <link rel='stylesheet'
    href='https://cdn-uicons.flaticon.com/4.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
  <link rel="stylesheet" href="../assets/css/variables.css">
  <style>
    body {
      font-family: 'DM Sans', sans-serif;
      background-color: var(--cream);
      overflow-x: hidden;
    }

    h1,
    h2,
    .brand-name,
    .stat-num {
      font-family: 'DM Serif Display', serif;
    }

    .bg-navy {
      background-color: var(--navy);
    }

    .text-gold {
      color: var(--gold);
    }

    .btn-custom {
      background-color: var(--navy);
      color: white;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #1a3260;
      color: white;
      transform: translateY(-2px);
    }

    .content-z {
      z-index: 1;
      position: relative;
    }

    .input-group-text {
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">

      <div
        class="col-md-5 bg-navy text-white d-flex flex-column justify-content-between p-5 position-relative overflow-hidden">
        <div class="panel-left-overlay"></div>

        <div class="d-flex align-items-center gap-3 content-z mt-3">
          <div class="bg-warning text-dark rounded px-3 py-2 fs-4">🎓</div>
          <div class="brand-name lh-1">
            <span class="fs-4">SiKampus</span><br>
            <small class="text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Sistem
              Informasi Akademik</small>
          </div>
        </div>

        <div class="content-z my-5">
          <h1 class="display-4 fw-bold lh-sm mb-4">Kelola data<br>kampus dengan<br><em class="text-gold">mudah.</em>
          </h1>
          <p class="text-white-50" style="max-width: 300px;">Platform administrasi terpusat untuk manajemen data
            mahasiswa dan dosen.</p>
        </div>

        <div class="d-flex gap-4 content-z border-top border-secondary pt-4 mb-3">
          <div>
            <div class="stat-num text-gold fs-2"><?= number_format($totMhs) ?></div>
            <div class="text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Mahasiswa</div>
          </div>
          <div>
            <div class="stat-num text-gold fs-2"><?= number_format($totDsn) ?></div>
            <div class="text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Dosen</div>
          </div>
          <div>
            <div class="stat-num text-gold fs-2">1</div>
            <div class="text-white-50 text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Admin</div>
          </div>
        </div>
      </div>

      <div class="col-md-7 d-flex align-items-center justify-content-center p-4">
        <div class="w-100" style="max-width: 400px;">
          <h2 class="mb-1 text-dark">Selamat datang</h2>
          <p class="text-muted mb-4">Masuk menggunakan akun admin Anda</p>

          <?php if ($error): ?>
            <div class="alert alert-danger d-flex align-items-center p-3" role="alert">
              <span class="me-2"><i class="fi fi-sr-diamond-exclamation"></i></span> <?= htmlspecialchars($error) ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="">
            <div class="mb-4">
              <label for="username" class="form-label text-uppercase fw-semibold"
                style="font-size: 0.8rem; letter-spacing: 1px;">Username</label>
              <div class="input-group">
                <span class="input-group-text bg-white"><i class="fi fi-rr-user"></i></span>
                <input type="text" class="form-control border-start-0 ps-0" id="username" name="username"
                  placeholder="Username" autocomplete="username" required>
              </div>
            </div>

            <div class="mb-4">
              <label for="password" class="form-label text-uppercase fw-semibold"
                style="font-size: 0.8rem; letter-spacing: 1px;">Password</label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="fi fi-rr-lock"></i></span>
                <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="password"
                  name="password" placeholder="Password" autocomplete="current-password" required>
                <span class="input-group-text bg-white border-start-0" id="toggleBtn" onclick="togglePw()">
                  <i class="fi fi-rr-eye"></i>
                </span>
              </div>
            </div>

            <button type="submit" class="btn btn-custom w-100 py-2 fw-bold text-uppercase">
              LOGIN
            </button>
          </form>

          <div class="text-center mt-5 text-muted" style="font-size: 0.8rem;">
            &copy; <?= date('Y') ?> SiKampus &mdash; Admin Only
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const togglePw = () => {
      const input = document.getElementById('password');
      const btn = document.getElementById('toggleBtn');
      if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = '<i class="fi fi-rr-eye-crossed"></i>';
      } else {
        input.type = 'password';
        btn.innerHTML = '<i class="fi fi-rr-eye"></i>';
      }
    }
  </script>
</body>

</html>