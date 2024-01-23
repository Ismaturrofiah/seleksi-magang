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
                <div class="row d-flex pt-3 ms-2 me-2 mb-5">
                    <table class="display cell-border" id="list-data" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th style="width: 7.5rem;">Posisi</th>
                                <th style="width: 15rem;">Detail</th>
                                <th>Buka <br /> Pendaftaran</th>
                                <th>Tutup <br /> Pendaftaran</th>
                                <th style="width: 5rem;">Kuota</th>
                                <th style="width: 5rem;">Realisasi</th>
                                <th style="width: 5rem;">Status</th>
                                <th>Mulai <br /> Magang</th>
                                <th>Selesai <br /> Magang</th>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Posisi Magang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="form-position">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="posisi" class="form-label">Posisi</label>
                            <input type="text" class="form-control" id="posisi" name="posisi" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Buka Pendaftaran</label>
                            <input type="date" class="form-control" id="open_reqruitment" name="open_reqruitment" placeholder="" onchange="CloseReq()" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Tutup Pendaftaran</label>
                            <input type="date" class="form-control" id="close_reqruitment" name="close_reqruitment" placeholder="" onchange="StartIntern()" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Mulai Magang</label>
                            <input type="date" class="form-control" id="start_intern" name="start_intern" placeholder="" onchange="CloseIntern()" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Selesai Magang</label>
                            <input type="date" class="form-control" id="close_intern" name="close_intern" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Kuota Magang</label>
                            <input type="number" class="form-control" id="quota" name="quota" placeholder="" required>
                        </div>
                        <div class="mb-3">
                            <label for="month" class="form-label">Status</label>
                            <select class="form-select" id="select-status" name="status" aria-label="Default select example">
                                <option value="open">Buka</option>
                                <option value="close">Tutup</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detail</label>
                            <textarea class="form-control" id="detail" name="detail" placeholder="" required></textarea>
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
        let npp = '<?= session()->get('npp'); ?>';

        async function hitAPI() {
            const api = await fetch('http://localhost/itdash/public/api/internposition?npp=' + npp, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                }
            })

            const response = await api.json();
            const data = response.data;

            if (response.error) {
                window.location = "<?= base_url('/login') ?>"
            } else {
                for (var i = 0; i < data.length; i++) {
                    let quota = '';
                    let realisasi = '';
                    const id = data[i].id;
                    const edit = "EditData('" + id + "')";
                    let stat = '';
                    if (data[i].status == 'open') {
                        stat = "<td>Buka</td>";
                    } else {
                        stat = "<td>Open</td>";
                    }
                    rowContent = "<tr class='text-center'><td></td><td>" + data[i].position + "</td><td>" + data[i].detail + "</td><td>" + data[i].start_reqruitment + "</td><td>" + data[i].close_reqruitment + "</td><td>" + data[i].quota + "</td><td>" + data[i].realization + "</td>" + stat + "<td>" + data[i].start_intern + "</td><td>" + data[i].close_intern + "</td><td><i class='material-icons me-2 action-warning' onclick=" + edit + ">edit</i></td></tr>";
                    $("#list-data tbody").append(rowContent);
                }

                var dt = $('#list-data').DataTable({
                    columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
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
            // Open Reqruitment
            const OpenReq = document.getElementById('open_reqruitment');
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }
            if (mm < 10) {
                mm = '0' + mm;
            }
            today = yyyy + '-' + mm + '-' + dd;
            OpenReq.setAttribute("min", today);

            $("#modal-footer").empty();
            $("#modal-footer").append("<button type='submit' class='btn btn-primary' onclick='addData()'>Simpan</button>");
        }

        function CloseReq() {
            // Close Reqruitmet
            const OpenReq = document.getElementById('open_reqruitment');
            const CloseReq = document.getElementById('close_reqruitment');
            const open = new Date(OpenReq.value);
            open.setDate(open.getDate() + 1);
            const ddReq = ("0" + open.getDate()).slice(-2);
            const mmReq = ("0" + (open.getMonth() + 1)).slice(-2);
            const endReq = open.getFullYear() + "-" + mmReq + "-" + ddReq;

            CloseReq.setAttribute("min", endReq);
        }

        function StartIntern() {
            // Close Reqruitmet
            const CloseReq = document.getElementById('close_reqruitment');
            const StartIntern = document.getElementById('start_intern');
            const close = new Date(CloseReq.value);
            close.setDate(close.getDate() + 7);
            const ddIntern = ("0" + close.getDate()).slice(-2);
            const mmIntern = ("0" + (close.getMonth() + 1)).slice(-2);
            const endIntern = close.getFullYear() + "-" + mmIntern + "-" + ddIntern;

            StartIntern.setAttribute("min", endIntern);
        }

        function CloseIntern() {
            // Close Reqruitmet
            const StartIntern = document.getElementById('start_intern');
            const CloseIntern = document.getElementById('close_intern');
            const openintern = new Date(StartIntern.value);
            openintern.setDate(openintern.getDate() + 30);
            const ddIntern = ("0" + openintern.getDate()).slice(-2);
            const mmIntern = ("0" + (openintern.getMonth() + 1)).slice(-2);
            const endIntern = openintern.getFullYear() + "-" + mmIntern + "-" + ddIntern;
            const maxendIntern = openintern.getFullYear() + "-" + 12 + "-" + 31;

            CloseIntern.setAttribute("min", endIntern);
            CloseIntern.setAttribute("max", maxendIntern);
        }

        // Create Data
        function addData() {
            $("#form-position").validate({
                rules: {
                    posisi: {
                        required: true,
                    },
                    detail: {
                        required: true,
                    },
                    open_reqruitment: {
                        required: true,
                    },
                    close_reqruitment: {
                        required: true,
                    },
                    start_intern: {
                        required: true,
                    },
                    close_intern: {
                        required: true,
                    },
                    quota: {
                        required: true,
                    },
                },
                messages: {
                    posisi: {
                        required: "Masukkan posisi magang",
                    },
                    detail: {
                        required: "Masukkan penjelasan posisi magang",
                    },
                    open_reqruitment: {
                        required: "Masukkan tanggal mulai pendaftaran",
                    },
                    close_reqruitment: {
                        required: "Masukkan tanggal tutup pendaftaran",
                    },
                    start_intern: {
                        required: "Masukkan tanggal mulai magang",
                    },
                    close_intern: {
                        required: "Masukkan tanggal selesai magang",
                    },
                    quota: {
                        required: "Masukkan kuota penerimaan",
                    },
                }
            });
            let position = document.getElementById('posisi').value;
            let detail = document.getElementById('detail').value;
            let open_reqruitment = document.getElementById('open_reqruitment').value;
            let close_reqruitment = document.getElementById('close_reqruitment').value;
            let start_intern = document.getElementById('start_intern').value;
            let close_intern = document.getElementById('close_intern').value;
            let quota = document.getElementById('quota').value;
            let status = document.getElementById('select-status').value;

            async function addAPI() {
                const api = await fetch('http://localhost/itdash/public/api/internposition', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        position: position,
                        npp: npp,
                        detail: detail,
                        start_reqruitment: open_reqruitment,
                        close_reqruitment: close_reqruitment,
                        start_intern: start_intern,
                        close_intern: close_intern,
                        quota: quota,
                        realization: "0",
                        status: status,
                    })
                })

                const data = await api.json();

                if (data.status == '1') {
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    })
                }
            }
            addAPI();
        }

        // Edit Data
        function EditData(id) {
            $("#formData").modal("show");

            async function showData() {
                const api = await fetch('http://localhost/itdash/public/api/internposition/' + id, {
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
                    document.getElementById('posisi').value = data[i].position;
                    document.getElementById('detail').value = data[i].detail;
                    document.getElementById('open_reqruitment').value = data[i].start_reqruitment;
                    document.getElementById('close_reqruitment').value = data[i].close_reqruitment;
                    document.getElementById('start_intern').value = data[i].start_intern;
                    document.getElementById('close_intern').value = data[i].close_intern;
                    document.getElementById('quota').value = data[i].quota;
                    document.getElementById('select-status').value = data[i].status;
                    $("#modal-footer").empty();
                    $("#modal-footer").append("<button type='submit' class='btn btn-primary' onclick='editData(" + data[i].id + ")'>Simpan</button>");
                }
            }
            showData();
        }

        function editData(id) {
            $("#form-position").validate({
                rules: {
                    posisi: {
                        required: true,
                    },
                    detail: {
                        required: true,
                    },
                    open_reqruitment: {
                        required: true,
                    },
                    close_reqruitment: {
                        required: true,
                    },
                    start_intern: {
                        required: true,
                    },
                    close_intern: {
                        required: true,
                    },
                    quota: {
                        required: true,
                    },
                },
                messages: {
                    posisi: {
                        required: "Masukkan posisi magang",
                    },
                    detail: {
                        required: "Masukkan penjelasan posisi magang",
                    },
                    open_reqruitment: {
                        required: "Masukkan tanggal mulai pendaftaran",
                    },
                    close_reqruitment: {
                        required: "Masukkan tanggal tutup pendaftaran",
                    },
                    start_intern: {
                        required: "Masukkan tanggal mulai magang",
                    },
                    close_intern: {
                        required: "Masukkan tanggal selesai magang",
                    },
                    quota: {
                        required: "Masukkan kuota penerimaan",
                    },
                }
            });
            let position = document.getElementById('posisi').value;
            let detail = document.getElementById('detail').value;
            let open_reqruitment = document.getElementById('open_reqruitment').value;
            let close_reqruitment = document.getElementById('close_reqruitment').value;
            let start_intern = document.getElementById('start_intern').value;
            let close_intern = document.getElementById('close_intern').value;
            let quota = document.getElementById('quota').value;
            let status = document.getElementById('select-status').value;

            async function editAPI() {
                const api = await fetch('http://localhost/itdash/public/api/internposition/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        position: position,
                        npp: npp,
                        detail: detail,
                        start_reqruitment: open_reqruitment,
                        close_reqruitment: close_reqruitment,
                        start_intern: start_intern,
                        close_intern: close_intern,
                        quota: quota,
                        realization: "0",
                        status: status,
                    })
                })

                const data = await api.json();

                if (data.status == '2') {
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    });
                    location.reload();
                }
            }
            editAPI();
        }
    </script>