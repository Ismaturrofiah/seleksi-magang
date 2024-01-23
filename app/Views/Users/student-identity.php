<?= view('Layout/header.php') ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <div class="content pb-5" id="content">
        <div class="container-fluid">
            <div class="row pt-2">
                <span class="title"><?= $title; ?></span>
            </div>
            <div class="row pt-3 me-5">
                <div class="card mb-3">
                    <form class="form-sign" action="<?= base_url('/user/identity') ?>" method="POST">
                        <?= $validation->listErrors(); ?>
                        <div class="ms-3 mb-3 row mt-5">
                            <label for="posisi" class="col-sm-2 form-label">Universitas</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="select-univ" name="univ" aria-label="Default select example">
                                </select>
                            </div>
                            <label for="posisi" class="col-sm-2 form-label"></label>
                            <p class="text-secondary col-sm-10">Belum ada universitasmu? <a href="#" class="card-link" onclick="addUniv()">Tambah Universitas</a></p>
                        </div>
                        <div class="ms-3 mb-3 row">
                            <label for="division" class="col-sm-2 form-label">Jurusan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= ($validation->hasError('major')) ? 'is-invalid' : ''; ?>" id="major" name="major" placeholder="">
                            </div>
                            <div class="invalid-feedback">
                                <?= $validation->getError('major'); ?>
                            </div>
                        </div>
                        <div class="ms-3 mb-3 row">
                            <label for="month" class="col-sm-2 form-label">Curiculum Vitae</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="cv" name="cv">
                            </div>
                        </div>
                        <div class="ms-3 mb-3 row">
                            <label for="proposal" class="col-sm-2 form-label">Proposal</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="proposal" name="proposal">
                            </div>
                        </div>
                        <input type="text" class="form-control" id="user_id" name="user_id" value="<?= $user_id; ?>" hidden>
                        <input type="text" class="form-control" id="status" name="status" value="1" hidden>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                            <button class="btn btn-primary me-md-2" type="submit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formUniv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Universitas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Universitas</label>
                    <input type="text" class="form-control" id="univ" name="univ" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="region" class="form-label">Provinsi</label>
                    <select class="form-select" id="select-region" aria-label="Default select example">
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addUniversity()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<?= view('Layout/footer.php') ?>
<?= view('Layout/js.php') ?>
<script src="<?= base_url('assets/js/alert.js') ?>"></script>
<script>
    // List Universitas
    async function getUniversity() {
        const api = await fetch('http://localhost/itdash/public/api/internuniversity', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                // 'Authorization': `Bearer ${ token }`
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const {
            data
        } = await api.json()

        let select = '';
        for (var i = 0; i < data.length; i++) {
            select += "<option value='" + data[i].id + "'>" + data[i].university + "</option>"
        }
        document.getElementById("select-univ").innerHTML = select;
    }
    getUniversity();

    // List Provinsi
    async function getRegion() {
        const api = await fetch('http://localhost/itdash/public/api/region', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                // 'Authorization': `Bearer ${ token }`
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const {
            data
        } = await api.json();

        let select = '';
        for (var i = 0; i < data.length; i++) {
            select += "<option value='" + data[i].id + "'>" + data[i].name + "</option>"
        }
        document.getElementById("select-region").innerHTML = select;
    }
    getRegion();

    function addUniv() {
        $('#formIdentity').modal('toggle');
        $("#formUniv").modal("show");
    }

    // Create Data
    function addUniversity() {
        let univ = document.querySelector('#univ').value;
        let region = document.getElementById('select-region').value;

        async function addAPI() {
            const api = await fetch('http://localhost/itdash/public/api/internuniversity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // 'Authorization': `Bearer ${ token }`
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: JSON.stringify({
                    name: univ,
                    region_id: region,
                    year: new Date().getFullYear(),
                })
            })

            const data = await api.json();

            if (data.status == '1') {
                $("#formUniv").modal("toggle");
                location.reload();
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data.message
                });
            }
        }
        addAPI();
    }
</script>