<?php
require_once __DIR__ . '/config/conn.php';

echo "<h2>Mulai proses seeding data ..</h2>";

$namad_depan_laki = ['Muhammad', 'Dimas', 'Eka', 'Ahmad', 'Bagus', 'Rahmad', 'Nur'];
$nama_depan_cewe = ['Siti', 'Ayu', 'Dwi', 'Putri', 'Nurul', 'Sari', 'Indah', 'Dian', 'Najma'];
$nama_akhir = ['Saffa','Akmal','Dzaky','Ferdi','Gibran','Raka','Kurniawan','Ali','Tio','Rico','Putra','Satria','Herlangga'];

$prodi_list = [
  'Teknik Informatika' => '810',
  'Sistem Informasi' => '820', 
  'Ilmu Komputer' => '830',
  'Teknik Elektro' => '840', 
  'Sains Data' => '850', 
  'Bisnis Digital' => '860', 
  'Teknologi Informasi' => '870'
];

$statusMhs = ['Aktif','Aktif','Aktif','Aktif','Aktif','Cuti','Lulus'];

function randomDate($start_date, $end_date) {
  return date('Y-m-d', rand(strtotime($start_date), strtotime($end_date)));
}

echo "<p>Menyisipkan 300 data mahasiswa...</p>";

$stmt = $conn->prepare("INSERT INTO mahasiswa 
(nim, nama, email, no_telp, alamat, jenis_kelamin, tanggal_lahir, program_studi, angkatan, status) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

for ($i = 1; $i <= 300; $i++) {

  $gender = rand(0, 1) ? 'Laki-laki' : 'Perempuan';

  $fname = $gender === 'Laki-laki' 
    ? $namad_depan_laki[array_rand($namad_depan_laki)] 
    : $nama_depan_cewe[array_rand($nama_depan_cewe)];

  $lname = $nama_akhir[array_rand($nama_akhir)];
  $nama = $fname . " " . $lname;
  $prodi_nama = array_rand($prodi_list);
  $kode_prodi = $prodi_list[$prodi_nama];
  $tahun = rand(2020, 2024);
  $angkatan = $tahun;
  $kode_fakultas = '10';
  $no_urut = str_pad($i, 3, '0', STR_PAD_LEFT);
  $nim = $kode_prodi . $tahun . $kode_fakultas . $no_urut;
  $email = strtolower($fname) . "." . strtolower($lname) . $i . "@upnjatim.ac.id";
  $no_telp = "0812" . rand(10000000, 99999999);
  $alamat = "Jl. Veteran No. " . rand(1, 100);
  $tgl_lahir = randomDate('2000-01-01', '2005-12-31');
  $status = $statusMhs[array_rand($statusMhs)];

  $stmt->bind_param(
    "ssssssssss",
    $nim,
    $nama,
    $email,
    $no_telp,
    $alamat,
    $gender,
    $tgl_lahir,
    $prodi_nama,
    $angkatan,
    $status
  );

  $stmt->execute();
}

$stmt->close();

echo "<p>Data mahasiswa berhasil di-seed!</p>";
?>