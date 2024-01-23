<?= view('Layout/header.php') ?>

<div class="container signin">
    <div class="row d-flex justify-content-center">
        <div class="col-md-4 col-10">
            <div class="card border-dark" style="width: 20rem;">
                <img class="img-logo" src="<?= base_url('assets/img/logopindad2.png') ?>" alt="" width="125">
                <h5 class="card-title text-center">Silahkan Masuk</h5>
                <form class="form-sign" id="loginForm" action="<?= site_url('/login') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="ms-3 me-3 mt-2 mb-3">
                        <div class="mb-3">
                            <label for="npp" class="col-form-label">NPP/Email</label>
                            <input type="text" class="form-control" id="npp" name="npp" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid col-12 mx-auto">
                            <button class="btn btn-primary" type="submit">Masuk</button>
                            <p>Belum punya akun? <a href="<?= base_url('signup') ?>" class="card-link">Registrasi</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= view('Layout/footer.php') ?>
<?= view('Layout/js.php') ?>

<script>
    $("#loginForm").validate({
        rules: {
            npp: {
                required: true,
            },
            password: {
                required: true,
            }
        },
        messages: {
            npp: {
                required: "Masukkan NPP atau email",
            },
            password: {
                required: "Masukkan password",
            }
        }
    });
</script>