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

// Proses tambah data obat
if (isset($_POST['tambah'])) {
    if (tambahObat($_POST)) {
        echo "<script>
              alert('Data obat berhasil ditambahkan!');
              document.location.href = 'obat.php';
            </script>";
    } else {
        echo "<script>
              alert('Gagal menambahkan data obat!');
              document.location.href = 'obat.php';
            </script>";
    }
}

// Proses edit data obat (memuat data lama)
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = query("SELECT * FROM obat WHERE id = $id")[0];
}

// Proses update data obat
if (isset($_POST['update'])) {
    if (updateObat($_POST)) {
        echo "<script>
                alert('Data obat berhasil diperbarui!');
                document.location.href = 'obat.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data obat!');
                document.location.href = 'obat.php';
              </script>";
    }
}

// Proses hapus data obat
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if (deleteObat($id)) {
        echo "<script>
                alert('Data obat berhasil dihapus!');
                document.location.href = 'obat.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data obat!');
                document.location.href = 'obat.php';
              </script>";
    }
}

// Query SELECT Data Obat
$obat = query("
    SELECT * FROM obat
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
                    <h1 class="m-0">Kelola Obat</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Obat</li>
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
                                <th>Nama Obat</th>
                                <th>Kemasan</th>
                                <th>Harga</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($obat as $obt) : ?>
                                <tr>
                                    <td><?= $obt["id"]; ?></td>
                                    <td><?= $obt["nama_obat"]; ?></td>
                                    <td><?= $obt["kemasan"]; ?></td>
                                    <td>Rp <?= number_format($obt["harga"], 0, ',', '.'); ?></td>
                                    <td>
                                        <a href="obat.php?edit=<?= $obt['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="obat.php?hapus=<?= $obt['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Tambah/Edit Data Obat -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= isset($editData) ? 'Edit' : 'Tambah'; ?> Data Obat</h3>
                        </div>
                        <form method="POST" action="">
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">
                                <div class="form-group">
                                    <label for="nama_obat">Nama Obat</label>
                                    <input type="text" class="form-control" id="nama_obat" name="nama_obat" placeholder="Masukkan Nama Obat" value="<?= $editData['nama_obat'] ?? ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="kemasan">Kemasan</label>
                                    <input type="text" class="form-control" id="kemasan" name="kemasan" placeholder="Masukkan Kemasan Obat" value="<?= $editData['kemasan'] ?? ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan Harga Obat" value="<?= $editData['harga'] ?? ''; ?>" required>
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