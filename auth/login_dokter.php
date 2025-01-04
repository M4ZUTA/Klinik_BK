<?php
// Mulai session
session_start();

// Impor fungsi dan koneksi database
require '../functions.php';

// Logika login
if (isset($_POST['submit'])) {
    $username = stripslashes($_POST['nama']);
    $password = $_POST['alamat'];

    if ($username === 'admin' && $password === 'admin') {
        // Login sebagai admin
        $_SESSION['login'] = true;
        $_SESSION['akses'] = 'admin';
        $_SESSION['username'] = 'admin';
        $_SESSION['id'] = null;
        header('Location: ../admin/index.php');
        exit;
    } else {
        // Cek login sebagai dokter
        $cek_username = $conn->prepare("SELECT * FROM dokter WHERE nama = :username");
        $cek_username->bindParam(':username', $username);
        try {
            $cek_username->execute();
            if ($cek_username->rowCount() === 1) {
                $baris = $cek_username->fetch(PDO::FETCH_ASSOC);
                if ($password === $baris['alamat']) {
                    // Login berhasil
                    $_SESSION['login'] = true;
                    $_SESSION['akses'] = 'dokter'; // Menambahkan akses dokter
                    $_SESSION['username'] = $baris['nama'];
                    $_SESSION['id'] = $baris['id'];
                    header('Location: ../dokter/index.php');
                    exit;
                }
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: login_dokter.php');
            exit;
        }
    }
    // Jika login gagal
    $_SESSION['error'] = 'Username dan Password Tidak Cocok';
    header('Location: login_dokter.php');
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Poliklinik</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- Login Logo -->
        <div class="login-logo">
            <a href="#"><b>Poli</b>Klinik</a>
        </div>
        <!-- Login Card -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silahkan Login ke Akun Anda</p>
                <!-- Form Login -->
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" id="nama" name="nama" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="alamat" name="alamat" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Error Notification -->
                    <?php if (isset($_SESSION['error'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= $_SESSION['error']; ?>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>
                    <div class="row">
                        <!-- Submit Button -->
                        <div class="col-12">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>

                <!-- Link to go back to index -->
                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <a href="../index.php" class="secondary">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AdminLTE JS -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>