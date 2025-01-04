<?php
session_start();

// Mendapatkan role dari session atau dari tempat lain sesuai kebutuhan
if (isset($_SESSION['role_id'])) {
    $role = $_SESSION['role_id'];

    // Tentukan file sidebar yang akan dimuat berdasarkan role
    if ($role === 1) {
        $sidebar_file = 'components/sidebar_admin.php';
        $home_file = 'pages/home_admin.php';
    } elseif ($role === 2) {
        $sidebar_file = 'components/sidebar_dokter.php';
        $home_file = 'pages/home_dokter.php';
    } else {
        // Atur default jika $_SESSION['role_id'] tidak terdefinisi atau tidak sesuai
        $sidebar_file = 'components/sidebar_pasien.php';
        $home_file = 'pages/home_pasien.php';
    }
} else {
    // Atur default jika $_SESSION['role_id'] belum terdefinisi
    $sidebar_file = 'components/sidebar_pasien.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('components/head.php'); ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include('components/navbar.php'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include($sidebar_file); ?>
    <!-- /.sidebar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <?php include($home_file); ?>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include('components/footer.php'); ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- ... -->
</body>
</html>
