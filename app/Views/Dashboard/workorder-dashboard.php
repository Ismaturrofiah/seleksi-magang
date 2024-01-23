<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row">
                <?= view('Dashboard/tabs-dashboard'); ?>
            </div>
            <div class="row">
                <h4>Work Order</h4>
            </div>
        </div>
        <?= view('Layout/footer'); ?>
    </div>
</div>
<?= view('Layout/js'); ?>