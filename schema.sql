-- Table Admin
CREATE TABLE admin (
  id_admin INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admin (username, password, nama) VALUES
("admin", "$2y$10$Y1oDwgCiI1S2V5XvK5.3M.eT3g3wKvPxH5p9LqQw3Z5ZvZ5Z5Z5Z5", "Muhammad Akmal Firmansyah");

-- Table Mahasiswa
CREATE TABLE mahasiswa (
  id_mahasiswa INT PRIMARY KEY AUTO_INCREMENT,
  nim VARCHAR(20) UNIQUE NOT NULL,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  no_telp VARCHAR(15),
  alamat TEXT,
  jenis_kelamin ENUM('Laki-laki', 'Perempuan'),
  tanggal_lahir DATE,
  program_studi VARCHAR(50),
  angkatan INT,
  status VARCHAR(20) DEFAULT 'Aktif',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table Dosen
CREATE TABLE dosen (
  id_dosen INT PRIMARY KEY AUTO_INCREMENT,
  nip VARCHAR(20) UNIQUE NOT NULL,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  no_telp VARCHAR(15),
  alamat TEXT,
  jenis_kelamin ENUM('Laki-laki', 'Perempuan'),
  tanggal_lahir DATE,
  program_studi VARCHAR(50),
  gelar_akademik VARCHAR(50),
  status VARCHAR(20) DEFAULT 'Aktif',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);