<?= view('Layout/header.php') ?>

<div class="container signin">
    <div class="row d-flex justify-content-center">
        <div class="col-md-4 col-10">
            <div class="card border-dark" style="width: 20rem;">
                <img class="img-logo" src="<?= base_url('assets/img/logopindad2.png') ?>" alt="" width="125">
                <h5 class="card-title text-center">Silahkan Mendaftar</h5>
                <form class="form-sign" id="form-registrasi" method="">
                    <div class="ms-3 me-3 mt-2 mb-3">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="col-form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Kata Sandi</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="col-form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <div class="d-grid col-12 mx-auto">
                            <button class="btn btn-primary" type="submit" onclick="SignUp()">Mendaftar</button>
                            <p>Sudah punya akun? <a href="<?= base_url('login') ?>" class="card-link">Masuk</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= view('Layout/footer.php') ?>
<?= view('Layout/js.php') ?>
<script src="<?= base_url('assets/js/alert.js') ?>"></script>
<script>
    function SignUp() {
        $("#form-registrasi").validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password",
                }
            },
            messages: {
                name: {
                    required: "Masukkan nama lengkap",
                },
                email: {
                    required: "Masukkan email",
                    email: "Masukkan email yang valid",
                },
                password: {
                    required: "Masukkan kata sandi",
                },
                confirm_password: {
                    required: "Masukkan ulang kata sandi",
                    equalTo: "Kata sandi tidak sama",
                }
            }
        });
        let name = document.getElementById("name").value;
        let email = document.querySelector('#email').value;
        let password = document.querySelector('#password').value;
        let confirmpassword = document.querySelector('#confirm_password').value;

        if (password != confirmpassword) {
            Toast.fire({
                icon: 'error',
                title: 'Kata sandi tidak sama',
            })
        } else {
            async function hitAPI() {
                const api = await fetch('http://localhost/itdash/public/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        nama: name,
                        npp: "",
                        email: email,
                        password: password,
                        role: "3",
                        status: "active"
                    })
                })

                const data = await api.json();

                if (data.status == "1") {
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    })
                    window.location = "<?= base_url('/login') ?>"
                }
            }

            hitAPI();
        }
    }
</script>