<?php
session_start();
require '../functions.php';

// Cek apakah sesi login admin ada
if (!isset($_SESSION['login']) || $_SESSION['akses'] !== 'admin') {
  echo "<script>
          alert('Anda harus login sebagai admin terlebih dahulu!');
          document.location.href = '../auth/login.php';
        </script>";
  exit;
}

// Proses tambah data dokter
if (isset($_POST['tambah'])) {
  if (tambahDokter($_POST)) {
    echo "<script>
              alert('Data dokter berhasil ditambahkan!');
              document.location.href = 'dokter.php';
            </script>";
  } else {
    echo "<script>
              alert('Gagal menambahkan data dokter!');
              document.location.href = 'dokter.php';
            </script>";
  }
}

// Proses edit data dokter (memuat data lama)
$editData = null;
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $editData = query("SELECT * FROM dokter WHERE id = $id")[0];
}

// Proses update data dokter
if (isset($_POST['update'])) {
  if (updateDokter($_POST)) {
    echo "<script>
                alert('Data dokter berhasil diperbarui!');
                document.location.href = 'dokter.php';
              </script>";
  } else {
    echo "<script>
                alert('Gagal memperbarui data dokter!');
                document.location.href = 'dokter.php';
              </script>";
  }
}

// Proses hapus data dokter
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  if (deleteDokter($id)) {
    echo "<script>
                alert('Data dokter berhasil dihapus!');
                document.location.href = 'dokter.php';
              </script>";
  } else {
    echo "<script>
                alert('Gagal menghapus data dokter!');
                document.location.href = 'dokter.php';
              </script>";
  }
}

// Query SELECT Data Dokter
$dokter = query("
    SELECT dokter.id, dokter.nama, dokter.alamat, dokter.no_hp, dokter.id_poli, poli.nama_poli 
    FROM dokter 
    JOIN poli ON dokter.id_poli = poli.id
");

// Query SELECT Data Poli
$poli = query("SELECT * FROM poli");

include '../layouts/admin/header.php';
?>
<?php include '../layouts/admin/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Kelola Dokter</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dokter</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      <!-- Tabel Data Dokter -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Data Dokter</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">Id</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No Hp</th>
                <th>Poli</th>
                <th style="width: 100px">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dokter as $dktr) : ?>
                <tr>
                  <td><?= $dktr["id"]; ?></td>
                  <td><?= $dktr["nama"]; ?></td>
                  <td><?= $dktr["alamat"]; ?></td>
                  <td><?= $dktr["no_hp"]; ?></td>
                  <td><?= $dktr["nama_poli"]; ?></td>
                  <td>
                    <a href="dokter.php?edit=<?= $dktr['id']; ?>" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="dokter.php?hapus=<?= $dktr['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">
                      <i class="fas fa-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Form Tambah/Edit Data Dokter -->
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title"><?= isset($editData) ? 'Edit' : 'Tambah'; ?> Data Dokter</h3>
            </div>
            <form method="POST" action="">
              <div class="card-body">
                <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">
                <div class="form-group">
                  <label for="nama">Nama</label>
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" value="<?= $editData['nama'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat</label>
                  <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan Alamat" value="<?= $editData['alamat'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                  <label for="no_hp">No HP</label>
                  <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No HP" value="<?= $editData['no_hp'] ?? ''; ?>" required>
                </div>
                <div class="form-group">
                  <label for="id_poli">Poli</label>
                  <select class="form-control" id="id_poli" name="id_poli" required>
                    <option value="" disabled selected>Pilih Poli</option>
                    <?php foreach ($poli as $p) : ?>
                      <option value="<?= $p['id']; ?>" <?= isset($editData) && $editData['id_poli'] == $p['id'] ? 'selected' : ''; ?>><?= $p['nama_poli']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="<?= isset($editData) ? 'update' : 'tambah'; ?>" class="btn btn-primary">
                  <?= isset($editData) ? 'Update' : 'Submit'; ?>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include '../layouts/admin/footer.php'; ?>