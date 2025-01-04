<?php

// Koneksi ke database menggunakan PDO
try {
    $conn = new PDO("mysql:host=localhost;dbname=poli_bk", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Menangani error
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
// Registrasi Pasien
function registrasi($data)
{
    global $conn;

    // Ambil data dari tiap elemen dalam form
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_ktp = htmlspecialchars($data["no_ktp"]);
    $no_hp = htmlspecialchars($data["no_hp"]);

    // Ambil tahun dan bulan saat ini
    $tahun = date('Y');
    $bulan = date('m');

    // Hitung jumlah data pasien untuk menentukan nomor urut
    $query = "SELECT COUNT(*) AS jumlah FROM pasien";
    $result = $conn->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $jumlah = $row['jumlah'] + 1; // Tambahkan 1 untuk data yang baru ditambahkan

    // Format no_rm: TahunBulanNomorUrut (contoh: 202412001)
    $no_rm = $tahun . $bulan . "-" . str_pad($jumlah, 3, '0', STR_PAD_LEFT);

    // Query insert data menggunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES (:nama, :alamat, :no_ktp, :no_hp, :no_rm)");
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':no_ktp', $no_ktp);
    $stmt->bindParam(':no_hp', $no_hp);
    $stmt->bindParam(':no_rm', $no_rm);

    // Eksekusi dan kembalikan status
    return $stmt->execute();
}



//Menampilkan values table
function query($query)
{
    global $conn;

    // Eksekusi query
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Ambil semua hasil
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Tambah Data Dokter
function tambahDokter($data)
{
    global $conn;

    // Ambil data dari tiap elemen dalam form
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_hp = htmlspecialchars($data["no_hp"]);
    $id_poli = htmlspecialchars($data["id_poli"]);

    // Query insert data menggunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO dokter (nama, alamat, no_hp, id_poli) VALUES (:nama, :alamat, :no_hp, :id_poli)");
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':no_hp', $no_hp);
    $stmt->bindParam(':id_poli', $id_poli);

    // Eksekusi dan kembalikan status
    return $stmt->execute();
}

// Update Data Dokter
function updateDokter($data)
{
    global $conn;

    // Ambil data dari form
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_hp = htmlspecialchars($data["no_hp"]);
    $id_poli = htmlspecialchars($data["id_poli"]);

    // Query Update Data Dokter
    $query = "UPDATE dokter SET
                nama = :nama,
                alamat = :alamat,
                no_hp = :no_hp,
                id_poli = :id_poli
              WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':no_hp', $no_hp);
    $stmt->bindParam(':id_poli', $id_poli);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

// Hapus Data Dokter
function deleteDokter($id)
{
    global $conn;

    // Query Delete Data Dokter
    $query = "DELETE FROM dokter WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

// Tambah Data Pasien
function tambahPasien($data)
{
    global $conn;

    // Ambil data dari tiap elemen dalam form
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_ktp = htmlspecialchars($data["no_ktp"]);
    $no_hp = htmlspecialchars($data["no_hp"]);

    // Ambil tahun dan bulan saat ini
    $tahun = date('Y');
    $bulan = date('m');

    // Hitung jumlah data pasien untuk menentukan nomor urut
    $query = "SELECT COUNT(*) AS jumlah FROM pasien";
    $result = $conn->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $jumlah = $row['jumlah'] + 1; // Tambahkan 1 untuk data yang baru ditambahkan

    // Format no_rm: TahunBulanNomorUrut (contoh: 202412001)
    $no_rm = $tahun . $bulan . "-" . str_pad($jumlah, 3, '0', STR_PAD_LEFT);

    // Query insert data menggunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES (:nama, :alamat, :no_ktp, :no_hp, :no_rm)");
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':no_ktp', $no_ktp);
    $stmt->bindParam(':no_hp', $no_hp);
    $stmt->bindParam(':no_rm', $no_rm);

    // Eksekusi dan kembalikan status
    return $stmt->execute();
}



// Update Data Pasien
function updatePasien($data)
{
    global $conn;

    // Ambil data dari form
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $no_ktp = htmlspecialchars($data["no_ktp"]);
    $no_hp = htmlspecialchars($data["no_hp"]);

    // Ambil tahun dan bulan saat ini
    $tahun = date('Y');
    $bulan = date('m');

    // Hitung jumlah data pasien untuk menentukan nomor urut
    $query = "SELECT COUNT(*) AS jumlah FROM pasien";
    $result = $conn->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $jumlah = $row['jumlah'] + 1; // Tambahkan 1 untuk data yang baru ditambahkan

    // Format no_rm: TahunBulanNomorUrut (contoh: 202412001)
    $no_rm = $tahun . $bulan . "-" . str_pad($jumlah, 3, '0', STR_PAD_LEFT);

    // Query Update Data Pasien
    $query = "UPDATE pasien SET
                nama = :nama,
                alamat = :alamat,
                no_ktp = :no_ktp,
                no_hp = :no_hp,
                no_rm = :no_rm
              WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':alamat', $alamat);
    $stmt->bindParam(':no_ktp', $no_ktp);
    $stmt->bindParam(':no_hp', $no_hp);
    $stmt->bindParam(':no_rm', $no_rm);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

// Hapus Data Pasien
function deletePasien($id)
{
    global $conn;

    // Query Delete Data Pasien
    $query = "DELETE FROM pasien WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

// Tambah Data Poli
function tambahPoli($data)
{
    global $conn;

    // Ambil data dari tiap elemen dalam form
    $nama_poli = htmlspecialchars($data["nama_poli"]);
    $keterangan = htmlspecialchars($data["keterangan"]);

    // Query insert data menggunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO poli (nama_poli, keterangan) VALUES (:nama_poli, :keterangan)");
    $stmt->bindParam(':nama_poli', $nama_poli);
    $stmt->bindParam(':keterangan', $keterangan);

    // Eksekusi dan kembalikan status
    return $stmt->execute();
}

// Update Data Poli
function updatePoli($data)
{
    global $conn;

    // Ambil data dari form
    $id = $data["id"];
    $nama_poli = htmlspecialchars($data["nama_poli"]);
    $keterangan = htmlspecialchars($data["keterangan"]);

    // Query Update Data Poli
    $query = "UPDATE poli SET
                nama_poli = :nama_poli,
                keterangan = :keterangan
              WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nama_poli', $nama_poli);
    $stmt->bindParam(':keterangan', $keterangan);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}


// Hapus Data Poli
function deletePoli($id)
{
    global $conn;

    // Query Delete Data Poli
    $query = "DELETE FROM poli WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

// Tambah Data Obat
function tambahObat($data)
{
    global $conn;
    // Ambil data dari tiap elemen dalam form
    $nama_obat = htmlspecialchars($data["nama_obat"]);
    $kemasan = htmlspecialchars($data["kemasan"]);
    $harga = htmlspecialchars($data["harga"]);

    // Query insert data menggunakan prepared statement
    $stmt = $conn->prepare("INSERT INTO obat (nama_obat, kemasan, harga) VALUES (:nama_obat, :kemasan, :harga)");
    $stmt->bindParam(':nama_obat', $nama_obat);
    $stmt->bindParam(':kemasan', $kemasan);
    $stmt->bindParam(':harga', $harga);

    // Eksekusi dan kembalikan status
    return $stmt->execute();
}

// Update Data Obat
function updateObat($data)
{
    global $conn;

    // Ambil data dari form
    $id = $data["id"];
    $nama_obat = htmlspecialchars($data["nama_obat"]);
    $kemasan = htmlspecialchars($data["kemasan"]);
    $harga = htmlspecialchars($data["harga"]);

    // Query Update Data Obat
    $query = "UPDATE obat SET
                nama_obat = :nama_obat,
                kemasan = :kemasan,
                harga = :harga
              WHERE id = :id";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nama_obat', $nama_obat);
    $stmt->bindParam(':kemasan', $kemasan);
    $stmt->bindParam(':harga', $harga);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}

// Hapus Data Obat
function deleteObat($id)
{
    global $conn;

    // Query Delete Data Obat
    $query = "DELETE FROM obat WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);

    return $stmt->execute();
}
