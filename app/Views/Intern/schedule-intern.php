<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row pt-2">
                <span class="title"><?= $title ?></span>
            </div>
            <div class="row d-flex pt-3 ms-3 me-2 justify-content-between">
                <div class="col">
                    <div class="row d-flex">
                        <div class="col-5">
                            <button type="button" class="btn btn-primary" onclick="showModal()">
                                Tambah Data
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col"></div>
                <div class="col">
                </div>
            </div>
            <div class="row mt-3">
                <div class="row d-flex pt-3 ms-2 me-3 mb-5">
                    <table class="display cell-border" id="list-data" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Jadwal</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Status</th>
                                <th style="width: 5rem;">Aksi</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Jadwal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="form-position">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="posisi" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Mulai</label>
                            <input type="date" class="form-control" id="startdate" name="startdate" placeholder="" onchange="CloseReq()" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Selesai</label>
                            <input type="date" class="form-control" id="closedate" name="closedate" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Status</label>
                            <select class="form-select" id="select-status" name="status" aria-label="Default select example">
                                <option value="active">Aktif</option>
                                <option value="inactive">Non Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer" id="modal-footer">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?= view('Layout/js'); ?>
    <script src="<?= base_url('assets/js/alert.js') ?>"></script>
    <script>
        fetch('http://localhost/itdash/public/api/internschedule', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                }
            })
            .then(response => response.json())
            .then(data => {
                for (var i = 0; i < data.data.length; i++) {
                    let date = '';
                    const id = data.data[i].id;
                    const edit = "EditData('" + id + "')";

                    const nameMonth = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

                    const startdate = new Date(data.data[i].startdate);
                    const mmstartdate = nameMonth[startdate.getMonth()];
                    const startdatedate = startdate.getDate() + " " + mmstartdate + " " + startdate.getFullYear();
                    const closedate = new Date(data.data[i].closedate);
                    const mmclosedate = nameMonth[closedate.getMonth()];
                    const closedatedate = closedate.getDate() + " " + mmclosedate + " " + closedate.getFullYear();
                    if (data.data[i].closedate == null) {
                        date = '-';
                    } else {
                        date = closedatedate;
                    }

                    rowContent = '<tr class="text-center"><td></td><td>' + data.data[i].name + '</td><td>' + startdatedate + '</td><td>' + closedatedate + '</td><td>' + data.data[i].status + '</td><td><i class="material-icons me-2 action-warning" onclick=' + edit + '>edit</i></td></tr>';
                    $("#list-data tbody").append(rowContent);
                }

                var dt = $('#list-data').DataTable({
                    columnDefs: [{
                        targets: [0, 1, 2, 3, 4],
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
            });

        function showModal() {
            $("#formData").modal("show");
            $("#modal-footer").empty();
            $("#modal-footer").append("<button type='submit' class='btn btn-primary' onclick='addData()'>Simpan</button>");
        }

        function addData() {
            let name = document.getElementById('name').value;
            let startdate = document.getElementById('startdate').value;
            let closedate = document.getElementById('closedate').value;
            let statuss = document.getElementById('select-status').value;

            fetch('http://localhost/itdash/public/api/internschedule', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        name: name,
                        startdate: startdate,
                        closedate: closedate,
                        status: statuss,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        });
                        window.location = "<?= base_url('/intern/schedule') ?>"
                    }
                })
        }

        function EditData(id) {
            $("#formData").modal("show");
            fetch('http://localhost/itdash/public/api/internschedule/' + id, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.data[0].name;
                    document.getElementById('startdate').value = data.data[0].startdate;
                    document.getElementById('closedate').value = data.data[0].closedate;
                    document.getElementById('select-status').value = data.data[0].status;
                    $("#modal-footer").empty();
                    $("#modal-footer").append("<button type='submit' class='btn btn-primary' onclick='editData(" + data.data[0].id + ")'>Simpan</button>")
                })
        }

        function editData(id) {
            let name = document.getElementById('name').value;
            let startdate = document.getElementById('startdate').value;
            let closedate = document.getElementById('closedate').value;
            let statuss = document.getElementById('select-status').value;

            fetch('http://localhost/itdash/public/api/internschedule/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        name: name,
                        startdate: startdate,
                        closedate: closedate,
                        status: statuss,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == '2') {
                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        });
                        window.location = "<?= base_url('/intern/schedule') ?>"
                    }
                })
        }
    </script>