<?php
// $uri = \Config\Services::request();
$uri = new \CodeIgniter\HTTP\URI(current_url());
?>
<!-- Sidebar -->
<div class="sidebar-content" id="sidebar">
    <!-- Sidebar Icon -->
    <ul class="navbar-nav sidebar accordion" id="sidebar-icon">
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link sidenav <?php if ($uri->getSegment(4) === "dashboard") {
                                            echo 'active';
                                        } ?>" href="<?= base_url('/dashboard/e-learning') ?>">
                <i style="font-size: 2rem;" class="material-icons">grid_view</i>
            </a>
        </li>
        <?php if (session()->get('role') == 1) { ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link sidenav <?php if ($uri->getSegment(4) === "intern") {
                                                echo 'active';
                                            } ?>">
                    <i style="font-size: 2rem;" class="material-icons">laptop_mac</i>
                </a>
            </li>
        <?php } ?>
        <?php if (session()->get('role') == 0) { ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link sidenav <?php if ($uri->getSegment(4) === "data-user") {
                                                echo 'active';
                                            } ?>" href="<?= base_url('/data-user') ?>">
                    <i style="font-size: 2rem;" class="material-icons">group</i>
                </a>
            </li>
        <?php } ?>
        <?php if (session()->get('role') == 0) { ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link sidenav <?php if ($uri->getSegment(4) === "setting") {
                                                echo 'active';
                                            } ?>">
                    <i style="font-size: 2rem;" class="material-icons">display_settings</i>
                </a>
            </li>
        <?php } ?>
    </ul>
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar accordion" id="sidebar-utama" hidden>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <a class="nav-link sidenav <?php if ($uri->getSegment(4) == "dashboard") {
                                            echo 'active';
                                        } ?>" href="<?= base_url('/dashboard/e-learning') ?>">
                <i class="material-icons">grid_view</i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php if (session()->get('role') == 1) { ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link sidenav <?php if ($uri->getSegment(4) == "intern") {
                                                echo 'active';
                                            } ?>" data-bs-toggle="collapse" data-bs-target="#intern-collapse" aria-expanded="false">
                    <i class="material-icons">laptop_mac</i>
                    <span>Magang</span>
                    <i class="expand ms-5 material-icons">expand_circle_down</i>
                </a>
                <div id="intern-collapse" class="collapse">
                    <div class="collapse-inner ms-5 me-3">
                        <a class="collapse-item <?php if ($uri->getSegment(4) == "intern" && $uri->getSegment(5) == "schedule") {
                                                    echo 'active';
                                                } ?>" href="<?= base_url('/intern/schedule') ?>">Jadwal Seleksi</a>
                    </div>
                </div>
                <div id="intern-collapse" class="collapse">
                    <div class="collapse-inner ms-5 me-3">
                        <a class="collapse-item <?php if ($uri->getSegment(4) == "intern" && $uri->getSegment(5) == "position") {
                                                    echo 'active';
                                                } ?>" href="<?= base_url('/intern/position') ?>">Posisi</a>
                    </div>
                </div>
                <div id="intern-collapse" class="collapse">
                    <div class="collapse-inner ms-5 me-3">
                        <a class="collapse-item <?php if ($uri->getSegment(4) == "intern" && $uri->getSegment(5) == "selection-administrative") {
                                                    echo 'active';
                                                } ?>" href="<?= base_url('/intern/selection-administrative') ?>">Seleksi Administrasi</a>
                    </div>
                </div>
                <div id="intern-collapse" class="collapse">
                    <div class="collapse-inner ms-5 me-3">
                        <a class="collapse-item <?php if ($uri->getSegment(4) == "intern" && $uri->getSegment(5) == "selection-technical") {
                                                    echo 'active';
                                                } ?>" href="<?= base_url('/intern/selection-technical') ?>">Seleksi Wawancara</a>
                    </div>
                </div>
                <div id="intern-collapse" class="collapse">
                    <div class="collapse-inner ms-5 me-3">
                        <a class="collapse-item <?php if ($uri->getSegment(4) == "intern" && $uri->getSegment(5) == "student") {
                                                    echo 'active';
                                                } ?>" href="<?= base_url('/intern/student') ?>">Mahasiswa</a>
                    </div>
                </div>
            </li>
        <?php } ?>
        <?php if (session()->get('role') == 0) { ?>
            <!-- Nav Item - Dashboard -->
            <li class=" nav-item">
                <a class="nav-link sidenav <?php if ($uri->getSegment(4) == "data-user") {
                                                echo 'active';
                                            } ?>" href="<?= base_url('/data-user') ?>">
                    <i class="material-icons">group</i>
                    <span>Users</span>
                </a>
            </li>
        <?php } ?>
        <?php if (session()->get('role') == 0) { ?>
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link sidenav <?php if ($uri->getSegment(4) == "setting") {
                                                echo 'active';
                                            } ?>" data-bs-toggle="collapse" data-bs-target="#setting-collapse" aria-expanded="false">
                    <i class="material-icons">display_settings</i>
                    <span>Pengaturan</span>
                    <i class="expand ms-5 material-icons">expand_circle_down</i>
                </a>
                <div id="setting-collapse" class="collapse">
                    <div class="collapse-inner ms-5 me-3">
                        <a class="collapse-item <?php if ($uri->getSegment(4) == "setting" && $uri->getSegment(5) == "display") {
                                                    echo 'active';
                                                } ?>" href="<?= base_url('/setting/display') ?>">Landing Page</a>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>
<!-- End of Sidebar -->