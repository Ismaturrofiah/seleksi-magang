<?php
// $uri = \Config\Services::request();
$uri = new \CodeIgniter\HTTP\URI(current_url());
?>

<!-- Nav tabs -->
<div class="col-12 mt-3 mb-3">
    <ul class="nav nav-tabs nav-justified flex-sm-row" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link <?php if ($uri->getSegment(4) === "dashboard" && $uri->getSegment(5) == "e-learning") {
                                    echo 'active';
                                } ?>" id="tab-dashboard-1-tab" href="<?= base_url('/dashboard/e-learning') ?>">
                <div class="text-center">
                    <h6 class="text-pills mb-0">E-Learning</h6>
                </div>
            </a>
        </li>
        <!-- <li class="nav-item" role="presentation">
            <a class="nav-link <?php if ($uri->getSegment(4) === "dashboard" && $uri->getSegment(5) == "work-order") {
                                    echo 'active';
                                } ?>" id="tab-dashboard-1-tab" href="<?= base_url('/dashboard/work-order') ?>">
                <div class="text-center">
                    <h6 class="text-pills mb-0">Work Order</h6>
                </div>
            </a>
        </li> -->
    </ul>
</div>