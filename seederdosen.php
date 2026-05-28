<?php
require_once __DIR__ . '/config/conn.php';

echo 'Proses dimulai...<br>';

$nDepanLaki    = ['Muhammad', 'Rizky', 'Nur', 'Taufiq', 'Ahmad', 'Syarif', 'Eka'];
$nBelakangLaki = ['Pratama', 'Parlika', 'Kholis', 'Mahendra', 'Syaroni', 'Cahyadi', 'Mulyadi', 'Hidayat'];
$nDepanCewe    = ['Siti', 'Ayu', 'Kurnia', 'Putri', 'Dewi', 'Indah', 'Dian'];
$nBelakangCewe = ['Citra', 'Novel', 'Fatimah', 'Kumalasari', 'Sari', 'Septiani', 'Setiyani', 'Henni', 'Ari'];

$prodi_list = [
    'Teknik Informatika'   => ['kode' => '810', 'email' => 'if'],
    'Sistem Informasi'     => ['kode' => '820', 'email' => 'si'],
    'Ilmu Komputer'        => ['kode' => '830', 'email' => 'ik'],
    'Teknik Elektro'       => ['kode' => '840', 'email' => 'te'],
    'Sains Data'           => ['kode' => '850', 'email' => 'sd'],
    'Bisnis Digital'       => ['kode' => '860', 'email' => 'bd'],
    'Teknologi Informasi'  => ['kode' => '870', 'email' => 'ti'],
];

$statusDsn    = ['Aktif', 'Aktif', 'Cuti', 'Pensiun']; 
$gelarDepan   = ['', '', 'Prof.', 'Dr.'];
$gelarBelakang = ['S.Kom., M.Kom.', 'S.T., M.T.', 'S.Si., M.Si.', 'S.E., M.M.'];

function randomDate($start_date, $end_date) {
    $min = strtotime($start_date);
    $max = strtotime($end_date);
    return date('Y-m-d', rand($min, $max));
}

$stmt = $conn->prepare("INSERT INTO dosen (nip, nama, email, no_telp, alamat, jenis_kelamin, tanggal_lahir, program_studi, gelar_akademik, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

for ($i = 1; $i <= 75; $i++) {
    $gender = rand(0, 1);
    if ($gender == 1) {
        $jenis_kelamin = 'Laki-laki';
        $fname = $nDepanLaki[array_rand($nDepanLaki)];
        $lname = $nBelakangLaki[array_rand($nBelakangLaki)];
    } else {
        $jenis_kelamin = 'Perempuan';
        $fname = $nDepanCewe[array_rand($nDepanCewe)];
        $lname = $nBelakangCewe[array_rand($nBelakangCewe)];
    }

    $nama_asli = $fname . ' ' . $lname;
    $prodi_key = array_rand($prodi_list);           
    $kode_nip  = $prodi_list[$prodi_key]['kode'];    
    $kode_email = $prodi_list[$prodi_key]['email'];  
    $gDepan    = $gelarDepan[array_rand($gelarDepan)];
    $gBelakang = $gelarBelakang[array_rand($gelarBelakang)];
    $gelar_akademik = ($gDepan ? $gDepan . ' ' : '') . $nama_asli . ', ' . $gBelakang;
    $nip = '19' . rand(70, 95) . '120127' . $kode_nip . str_pad($i, 2, '0', STR_PAD_LEFT);
    $nama_email = strtolower(str_replace(' ', '.', $fname . '.' . $lname));
    $email      = $nama_email . '@' . $kode_email . 'upnjatim.ac.id';
    $no_telp   = '0812' . rand(10000000, 99999999);
    $alamat    = 'Perumahan Dosen Blok ' . chr(rand(65, 90)) . ' No ' . rand(1, 50);
    $tgl_lahir = randomDate('1970-01-01', '1994-12-31');
    $status    = $statusDsn[array_rand($statusDsn)]; 

    $stmt->bind_param(
        'ssssssssss',
        $nip, $gelar_akademik, $email, $no_telp,
        $alamat, $jenis_kelamin, $tgl_lahir,
        $prodi_key, $gBelakang, $status
    );

    if ($stmt->execute()) {
        echo "✅ [$i] $gelar_akademik — $email<br>";
    } else {
        echo "❌ [$i] Gagal: " . $stmt->error . "<br>";
    }
}

$stmt->close();
echo '<br><b>Selesai! Hapus file ini sekarang.</b>';
?>