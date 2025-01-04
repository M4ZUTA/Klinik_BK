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
// Proses tambah data poli
if (isset($_POST['tambah'])) {
    if (tambahPoli($_POST)) {
        echo "<script>
              alert('Data poli berhasil ditambahkan!');
              document.location.href = 'poli.php';
            </script>";
    } else {
        echo "<script>
              alert('Gagal menambahkan data poli!');
              document.location.href = 'poli.php';
            </script>";
    }
}

// Proses edit data poli (memuat data lama)
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editData = query("SELECT * FROM poli WHERE id = $id")[0];
}

// Proses update data poli
if (isset($_POST['update'])) {
    if (updatePoli($_POST)) {
        echo "<script>
                alert('Data poli berhasil diperbarui!');
                document.location.href = 'poli.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui data poli!');
                document.location.href = 'poli.php';
              </script>";
    }
}

// Proses hapus data poli
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if (deletePoli($id)) {
        echo "<script>
                alert('Data poli berhasil dihapus!');
                document.location.href = 'poli.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data poli!');
                document.location.href = 'poli.php';
              </script>";
    }
}

// Query SELECT Data Poli
$poli = query("
    SELECT * FROM poli
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
                    <h1 class="m-0">Kelola Poli</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Poli</li>
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
                                <th>Nama Poli</th>
                                <th>keterangan</th>
                                <th style="width: 100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($poli as $pl) : ?>
                                <tr>
                                    <td><?= $pl["id"]; ?></td>
                                    <td><?= $pl["nama_poli"]; ?></td>
                                    <td><?= $pl["keterangan"]; ?></td>
                                    <td>
                                        <a href="poli.php?edit=<?= $pl['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="poli.php?hapus=<?= $pl['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Form Tambah/Edit Data Poli -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><?= isset($editData) ? 'Edit' : 'Tambah'; ?> Data Poli</h3>
                        </div>
                        <form method="POST" action="">
                            <div class="card-body">
                                <input type="hidden" name="id" value="<?= $editData['id'] ?? ''; ?>">
                                <div class="form-group">
                                    <label for="nama_poli">Nama Poli</label>
                                    <input type="text" class="form-control" id="nama_poli" name="nama_poli" placeholder="Masukkan Nama Poli" value="<?= $editData['nama_poli'] ?? ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" rows="4" required><?= $editData['keterangan'] ?? ''; ?></textarea>
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