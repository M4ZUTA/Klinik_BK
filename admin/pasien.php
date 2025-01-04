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

// Proses tambah data pasien
if (isset($_POST['tambah'])) {
    if (tambahPasien($_POST)) {
        echo "<script>
              alert('Data pasien berhasil ditambahkan!');
              document.location.href = 'pasien.php';
            </script>";
    } else {
        echo "<script>
              alert('Gagal menambahkan data pasien!');
              document.location.href = 'pasien.php';
            </script>";
    }
}

// Proses edit data pasien (memuat data lama)
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = query("SELECT * FROM pasien WHERE id = $id")[0];
}

// Proses update data pasien
if (isset($_POST['update'])) {
    if (updatePasien($_POST)) {
        echo "<script>
                alert('Data pasien berhasil diperbarui!');
                document.location.href = 'pasien.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data pasien!');
                document.location.href = 'pasien.php';
              </script>";
    }
}

// Proses hapus data pasien
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if (deletePasien($id)) {
        echo "<script>
                alert('Data pasien berhasil dihapus!');
                document.location.href = 'pasien.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data pasien!');
                document.location.href = 'pasien.php';
              </script>";
    }
}

// Query SELECT Data Pasien
$pasien = query("
    SELECT * FROM pasien
");

include '../layouts/admin/header.php';
?>
<?php include '../layouts/admin/sidebar.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Kelola Pasien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Pasien</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <!-- Tabel Data Pasien -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Data Pasien</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 10px">Id</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No KTP</th>
                                <th>No Hp</th>
                                <th>No RM</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pasien as $psn) : ?>
                                <tr>
                                    <td><?= $psn["id"]; ?></td>
                                    <td><?= $psn["nama"]; ?></td>
                                    <td><?= $psn["alamat"]; ?></td>
                                    <td><?= $psn["no_ktp"]; ?></td>
                                    <td><?= $psn["no_hp"]; ?></td>
                                    <td><?= $psn["no_rm"]; ?></td>
                                    <td>
                                        <a href="pasien.php?edit=<?= $psn['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="pasien.php?hapus=<?= $psn['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Tambah/Edit Data Pasien -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= isset($editData) ? 'Edit' : 'Tambah'; ?> Data Pasien</h3>
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
                                    <label for="no_ktp">No KTP</label>
                                    <input type="number" class="form-control" id="no_ktp" name="no_ktp" placeholder="Masukkan No KTP" value="<?= $editData['no_ktp'] ?? ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_hp">No HP</label>
                                    <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan No HP" value="<?= $editData['no_hp'] ?? ''; ?>" required>
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