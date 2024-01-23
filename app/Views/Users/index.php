<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row pt-2">
                <span class="title">Data Pengguna</span>
            </div>
            <div class="row d-flex pt-3 ms-3 me-2 justify-content-between">
                <div class="col">
                    <div class="row d-flex">
                        <div class="col-5">
                            <button class="btn btn-primary" type="submit" onclick="showModal()">Tambah Data</button>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
                <div class="col">
                    <div class="row d-flex">
                    </div>
                </div>
            </div>
            <div class="row pt-3 ms-2 me-2 mb-5">
                <table class="display cell-border" id="list-data" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 5rem;">No</th>
                            <th>NPP</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <?= view('Layout/footer'); ?>
    </div>
</div>
<div class="modal fade" id="formData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="npp" class="form-label">NPP</label>
                    <input type="number" class="form-control" id="npp" name="npp" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="password" class="col-form-label">Kata Sandi</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <label for="confirm-password" class="col-form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" class="form-control" id="confirm-password" name="confirm-password">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="select-role" aria-label="Default select example">
                        <option value="0">Admin</option>
                        <option value="1">Divisi</option>
                        <option value="2">Pembimbing</option>
                        <option value="3">Mahasiswa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="select-status" aria-label="Default select example">
                        <option value="active">Aktif</option>
                        <option value="inactive">Non Aktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer" id="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Pengguna</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="npp" class="form-label">NPP</label>
                    <input type="number" class="form-control" id="edit-npp" name="edit-npp" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="edit-nama" name="edit-nama" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="edit-email" name="edit-email" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" id="select-edit-role" aria-label="Default select example">
                        <option value="0">Admin</option>
                        <option value="1">Divisi</option>
                        <option value="2">Pembimbing</option>
                        <option value="3">Mahasiswa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="select-edit-status" aria-label="Default select example">
                        <option value="active">Aktif</option>
                        <option value="inactive">Non Aktif</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer" id="modal-edit-footer">
            </div>
        </div>
    </div>
</div>
<?= view('Layout/js'); ?>
<script src="<?= base_url('assets/js/alert.js') ?>"></script>
<script>
    async function hitAPI() {
        const api = await fetch('http://localhost/itdash/public/api/data-users', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const response = await api.json();
        console.log(response);
        const data = response.data;

        if (response.error == "Expired token") {
            window.location = "<?= base_url('/login') ?>"
        } else {
            for (var i = 0; i < data.length; i++) {
                const id = data[i].id;
                const edit = "EditData('" + id + "')";
                let namerole = '';
                let namenpp = '';
                if (data[i].role == "0") {
                    namerole = '<td><span class="badge text-bg-success">Administrator</span></td>';
                    namenpp = '<td>' + data[i].npp + '</td>';
                } else if (data[i].role == "1") {
                    namerole = '<td><span class="badge text-bg-secondary">Admin Divisi</span></td>';
                    namenpp = '<td>' + data[i].npp + '</td>';
                } else if (data[i].role == "2") {
                    namerole = '<td><span class="badge text-bg-warning">Pembimbing</span></td>';
                    namenpp = '<td>' + data[i].npp + '</td>';
                } else if (data[i].role == "3") {
                    namerole = '<td><span class="badge text-bg-primary">Mahasiswa</span></td>';
                    namenpp = '<td>-</td>';
                }
                rowContent = "<tr class='text-center'><td></td>" + namenpp + "<td>" + data[i].name + "</td><td>" + data[i].email + "</td>" + namerole + "<td>" + data[i].status + "</td><td><i class='material-icons me-2 action-warning' onclick=" + edit + ">edit</i></td></tr>";
                $("#list-data tbody").append(rowContent);
            }

            var dt = $('#list-data').DataTable({
                columnDefs: [{
                    targets: [0, 1, 2, 3, 4, 5],
                    className: 'dt-head-center'
                }, ],
                "ordering": false
            });
            dt.on('order.dt search.dt', function() {
                let i = 1;

                dt.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
        }
    }

    hitAPI();

    function showModal() {
        $("#formData").modal("show");
        $("#modal-footer").empty();
        $("#modal-footer").append("<button type='button' class='btn btn-primary' onclick='addData()'>Simpan</button>");
    }

    // Create Data
    function addData() {
        let npp = document.querySelector('#npp').value;
        let name = document.querySelector('#nama').value;
        let email = document.querySelector('#email').value;
        let password = document.querySelector('#password').value;
        let confirmpassword = document.querySelector('#confirm-password').value;
        let role = document.getElementById('select-role').value;
        let stat = document.getElementById('select-status').value;

        if (password != confirmpassword) {
            Toast.fire({
                icon: 'error',
                title: 'Kata sandi tidak sama',
            })
        } else {
            async function addAPI() {
                const api = await fetch('http://localhost/itdash/public/api/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        nama: name,
                        npp: npp,
                        email: email,
                        password: password,
                        role: role,
                        status: stat
                    })
                })

                const data = await api.json();

                if (data.status == "1") {
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    })
                    location.reload();
                } else {
                    if (data.status == "400") {
                        location.reload();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message,
                        })
                    }
                }
            }

            addAPI();
        }
    }

    // Edit Data
    function EditData(id) {
        $("#editData").modal("show");
        async function showData() {
            const api = await fetch('http://localhost/itdash/public/api/users/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                }
            })

            const {
                data
            } = await api.json()

            for (var i = 0; i < data.length; i++) {
                document.getElementById('edit-npp').value = data[i].npp;
                document.getElementById('edit-nama').value = data[i].name;
                document.getElementById('edit-email').value = data[i].email;
                document.querySelector('#select-edit-role').value = data[i].role;
                document.querySelector('#select-edit-status').value = data[i].status;;
                $("#modal-edit-footer").empty();
                $("#modal-edit-footer").append("<button type='button' class='btn btn-primary' onclick='editData(" + data[i].id + ")'>Simpan</button>");
            }
        }
        showData();
    }

    function editData(id) {
        let npp = document.querySelector('#edit-npp').value;
        let name = document.querySelector('#edit-nama').value;
        let email = document.querySelector('#edit-email').value;
        let role = document.getElementById('select-edit-role').value;
        let stat = document.getElementById('select-edit-status').value;

        async function editAPI() {
            const api = await fetch('http://localhost/itdash/public/api/users/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    // 'Authorization': `Bearer ${ token }`
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: JSON.stringify({
                    nama: name,
                    npp: npp,
                    email: email,
                    role: role,
                    status: stat
                })
            })

            const data = await api.json()

            if (data.status == '2') {
                $('#editData').modal('toggle');
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                })
                location.reload();
            } else {
                $('#formData').modal('toggle');
                Toast.fire({
                    icon: 'error',
                    title: data.message,
                })
            }
        }
        editAPI();
    }
</script>