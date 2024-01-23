<nav class="navbar navbar-expand navbar-light bg-body-light topbar m-0 position-fixed">
    <div class="d-flex align-items-center">
        <img src="<?= base_url('assets/img/logopindad.png') ?>" height="35" class="logo-light-mode ms-3 me-3" alt="">
        <h4 class="navbar-title mb-0">SELEKSI MAGANG MAHASISWA</h4>
    </div>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto me-3">
        <?php if (!session()->has('isLoggedIn')) { ?>
            <a class="btn btn-primary" href="<?= base_url('login') ?>">Masuk</a>
        <?php } else { ?>
            <li class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                    $id = session()->get('id');
                    $profile = 'photo/' . $id . '_photo.png';
                    ?>
                    <img class="img-profile rounded-circle ms-3 me-3" src="<?= base_url($profile) ?>">
                    <span class="d-none d-lg-inline username"><?= session()->get('nama'); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-light">
                    <li><a class="dropdown-item" href="<?= base_url('user/profile') ?>"><i class="material-icons me-2">person</i>Akun</a></li>
                    <div class="dropdown-divider"></div>
                    <?php if (session()->get('role') == '3') { ?>
                        <li><a class="dropdown-item" href="<?= base_url('user/apply') ?>"><i class="material-icons me-2">laptop</i>Magang</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a class="dropdown-item" href="<?= base_url('user/info') ?>"><i class="material-icons me-2">info</i>Info</a></li>
                        <div class="dropdown-divider"></div>
                    <?php } ?>
                    <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="material-icons me-2">logout</i>Keluar</a></li>
                </ul>
            </li>
        <?php } ?>
    </ul>
</nav>