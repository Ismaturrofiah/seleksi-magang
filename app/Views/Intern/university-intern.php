<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row pt-2">
                <span class="title">Daftar Universitas</span>
            </div>
            <div class="row d-flex pt-3 ms-3 me-2 justify-content-between">
            </div>
            <div class="row mt-3">
                <div class="row d-flex pt-3 ms-2 me-2 mb-5">
                    <table class="display cell-border" id="data-university" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Universitas</th>
                                <th>Provinsi</th>
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
    <div class="modal fade" id="createData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Magang</h1>
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
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="year" name="year" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="addUniversity()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Magang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="univ" class="form-label">Nama Universitas</label>
                        <input type="text" class="form-control" id="edit-univ" name="edit-univ" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="region" class="form-label">Provinsi</label>
                        <select class="form-select" id="edit-select-region" aria-label="Default select example">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="edit-year" name="edit-year" placeholder="">
                    </div>
                </div>
                <div class="modal-footer" id="edit-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Data Magang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah yakin ingin menghapus data magang?
                </div>
                <div class="modal-footer" id="delete-footer">
                </div>
            </div>
        </div>
    </div>
    <?= view('Layout/js'); ?>
    <script>
        // let token = JSON.parse(sessionStorage.getItem('token'));

        // console.log(token);

        async function hitAPI() {
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

            for (var i = 0; i < data.length; i++) {
                const id = data[i].id;
                const edit = "EditUniversity('" + id + "')";
                const del = "DeleteUniversity('" + id + "')";
                rowContent = "<tr class='text-center'><td></td><td>" + data[i].university + "</td><td>" + data[i].region + "</td></tr>";
                $("#data-university tbody").append(rowContent);
            }

            var dtuniversity = $('#data-university').DataTable({
                columnDefs: [{
                    targets: [0, 1, 2],
                    className: 'dt-head-center'
                }, ],
                "ordering": false
            });
            dtuniversity.on('order.dt search.dt', function() {
                let i = 1;

                dtuniversity.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
        }
        hitAPI();

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
            } = await api.json()

            let select = '';
            for (var i = 0; i < data.length; i++) {
                select += "<option value='" + data[i].id + "'>" + data[i].name + "</option>"
            }
            document.getElementById("select-region").innerHTML = select;
            document.getElementById("edit-select-region").innerHTML = select;
        }
        getRegion();

        // Create Data
        function addUniversity() {
            let univ = document.querySelector('#univ').value;
            let region = document.getElementById('select-region').value;
            let year = document.querySelector('#year').value;

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
                        year: year,
                    })
                })

                const data = await api.json()

                if (data.status == '1') {
                    location.reload();
                    alert(data.message);
                } else {
                    location.reload();
                    alert(data.message);
                }
            }
            addAPI();
        }

        // Edit Data
        function EditUniversity(id) {
            $("#editData").modal("show");
            async function showData() {
                const api = await fetch('http://localhost/itdash/public/api/internuniversity/' + id, {
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

                for (var i = 0; i < data.length; i++) {
                    document.getElementById('edit-univ').value = data[i].university;
                    document.querySelector('#edit-select-region').value = data[i].region_id;
                    document.getElementById('edit-year').value = data[i].year;
                    $("#edit-footer").empty();
                    $("#edit-footer").append("<button type='button' class='btn btn-primary' onclick='editUniversity(" + data[i].id + ")'>Simpan</button>");
                }
            }
            showData();
        }

        function editUniversity(id) {
            let univ = document.querySelector('#edit-univ').value;
            let region = document.getElementById('edit-select-region').value;
            let year = document.querySelector('#edit-year').value;

            async function editAPI() {
                const api = await fetch('http://localhost/itdash/public/api/internuniversity/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        // 'Authorization': `Bearer ${ token }`
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        name: univ,
                        region_id: region,
                        year: year,
                    })
                })

                const data = await api.json()

                if (data.status == '1') {
                    $('#modal').modal('toggle');
                    location.reload();
                    alert(data.message);
                } else {
                    $('#modal').modal('toggle');
                    location.reload();
                    alert(data.message);
                }
            }
            editAPI();
        }

        function DeleteUniversity(id) {
            $("#deleteData").modal("show");
            $("#delete-footer").empty();
            $("#delete-footer").append("<button type='button' class='btn btn-primary' onclick='deleteUniversity(" + id + ")'>Hapus</button>");
        }

        function deleteUniversity(id) {
            async function deleteAPI() {
                const api = await fetch('http://localhost/itdash/public/api/internuniversity/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        // 'Authorization': `Bearer ${ token }`
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                })

                const data = await api.json()

                if (data.status == '1') {
                    location.reload();
                    alert(data.message);
                } else {
                    location.reload();
                    alert(data.message);
                }
            }
            deleteAPI();
        }
    </script>