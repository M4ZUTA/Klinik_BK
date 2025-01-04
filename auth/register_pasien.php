<?php
session_start();
require '../functions.php';

// Proses registrasi saat form disubmit
if (isset($_POST["submit"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('Registrasi berhasil!');
                document.location.href = 'login_pasien.php';
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal, coba lagi!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pasien</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="#"><b>Registrasi</b> Pasien</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Silakan isi data Anda untuk registrasi</p>

                <!-- Form Registrasi -->
                <form action="" method="POST">
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nama Lengkap" id="nama" name="nama" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Alamat" id="alamat" name="alamat" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-home"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nomor KTP -->
                    <div class="form-group">
                        <label for="no_ktp">Nomor KTP</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nomor KTP" id="no_ktp" name="no_ktp" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-id-card"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nomor HP -->
                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nomor HP" id="no_hp" name="no_hp" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-phone"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-4">
                            <button type="submit" name="submit" class="btn btn-primary btn-block">Registrasi</button>
                        </div>
                    </div>
                </form>

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