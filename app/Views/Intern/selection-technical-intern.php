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
                                <th>Nama</th>
                                <th>Program Studi</th>
                                <th>Fakultas</th>
                                <th>Universitas</th>
                                <th>Posisi</th>
                                <th>Periode Pendaftaran</th>
                                <th>Periode Magang</th>
                                <th style="width: 5rem;">Keterangan</th>
                                <th style="width: 10rem;">Action</th>
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
    <div class="modal fade" id="detailData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header" id="headermodal">
                    <h5 class="modal-title">Konfirmasi Penerimaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="mb-3 row" id="jurusan">
                            </div>
                            <div class="mb-3 row" id="fakultas">
                            </div>
                            <div class="mb-3 row" id="univ">
                            </div>
                            <div class="mb-3 row" id="posisi">
                            </div>
                        </div>
                        <div class="col-2 ">
                            <div class="mb-3 row" id="photo">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 row" id="tanggal_int">
                        </div>
                        <div class="mb-3 row" id="waktu_int">
                        </div>
                        <div class="mb-3 row" id="tipe_int">
                        </div>
                        <div class="mb-3 row" id="loc_int">
                        </div>
                    </div>
                    <div class="row" id="ket"></div>
                </div>
                <div class="modal-footer" id="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="declineData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alasan Tidak Lolos Magang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea class="form-control" placeholder="Alasan tidak lolos magang" id="reason"></textarea>
                </div>
                <div class="modal-footer" id="modal-footer-decline">
                </div>
            </div>
        </div>
    </div>
    <?= view('Layout/js'); ?>
    <script src="<?= base_url('assets/js/alert.js') ?>"></script>
    <script>
        let npp = "<?= session()->get('npp') ?>"
        async function hitAPI() {
            const api = await fetch('http://localhost/itdash/public/api/internselectiontechnical?npp=' + npp, {
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
                let badge = '';
                let button = '';
                for (var i = 0; i < data.length; i++) {
                    const id = data[i].id;
                    const edit = "ConfirmData('" + id + "')";

                    if (data[i].status == '3') {
                        badge = '<span class="badge text-bg-warning">Lolos administrasi</span>'
                        button = "<button class='btn btn-primary btn-sm' onclick=" + edit + ">Detail</button>";
                    } else if (data[i].status == '2') {
                        badge = '<span class="badge text-bg-danger">Ditolak</span>'
                        button = "<button class='btn btn-primary btn-sm' onclick=" + edit + ">Detail</button>";
                    } else {
                        badge = '<span class="badge text-bg-success">Diterima</span>'
                        button = "<button class='btn btn-primary btn-sm' onclick=" + edit + ">Detail</button>";
                    }

                    const startintern = new Date(data[i].start_intern);
                    const mmstartintern = ("0" + (startintern.getMonth() + 1)).slice(-2);
                    const startinterndate = startintern.getDate() + "-" + mmstartintern + "-" + startintern.getFullYear();
                    const closeintern = new Date(data[i].close_intern);
                    const mmcloseintern = ("0" + (closeintern.getMonth() + 1)).slice(-2);
                    const closeinterndate = closeintern.getDate() + "-" + mmcloseintern + "-" + closeintern.getFullYear();
                    const startreq = new Date(data[i].start_reqruitment);
                    const mmstartreq = ("0" + (startreq.getMonth() + 1)).slice(-2);
                    const startreqdate = startreq.getDate() + "-" + mmstartreq + "-" + startreq.getFullYear();
                    const closereq = new Date(data[i].close_reqruitment);
                    const mmclosereq = ("0" + (closereq.getMonth() + 1)).slice(-2);
                    const closereqdate = closereq.getDate() + "-" + mmclosereq + "-" + closereq.getFullYear();

                    rowContent = "<tr class='text-center'><td></td><td>" + data[i].name + "</td><td>" + data[i].position + "</td><td>" + data[i].major + "</td><td>" + data[i].faculty + "</td><td>" + data[i].university + "</td><td>" + startreqdate + "<br />s/d <br />" + closereqdate + "</td><td>" + startinterndate + "<br />s/d <br />" + closeinterndate + "</td><td>" + badge + "</td><td>" + button + "</td></tr>";
                    $("#list-data tbody").append(rowContent);
                }

                var dt = $('#list-data').DataTable({
                    columnDefs: [{
                        targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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

        function ConfirmData(id) {
            $("#detailData").modal("show");
            let button = '';
            fetch('http://localhost/itdash/public/api/internselection/' + id, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    let realization = data.data[0].realization;
                    let quota = data.data[0].quota;
                    let total = parseInt(quota) - parseInt(realization);

                    let button = '';
                    let lokasi = '';

                    let jurusan = '<div class="col">Program Studi: ' + data.data[0].major + ' </div>';
                    let fakultas = '<div class="col">Fakultas: ' + data.data[0].faculty + ' </div>';
                    let univ = '<div class="col">Universitas: ' + data.data[0].universitas + '</div>';
                    let posisi = '<div class="col">Posisi yang dituju: ' + data.data[0].position + '</div>';
                    let photo = '<img class="img-profile me-3" style="border: 2px solid #555" src="<?= base_url() ?>photo/' + data.data[0].photo + '" height="250px"">'
                    let tanggal = '<div class="col">Tanggal wawancara: ' + data.data[0].date_int + '</div>';
                    let waktu = '<div class="col">Waktu wawancara: ' + data.data[0].time_int + '</div>';
                    let tipe = '<div class="col">Wawancara akan dilakukan secara ' + data.data[0].type_int + '</div>';
                    if (data.data[0].type_int == "Offline") {
                        lokasi = '<div class="col">Tempat wawancara: ' + data.data[0].location_int + '</div>';
                    } else {
                        lokasi = '<div class="col">Link : <a href="' + data.data[0].location_int + '" target="_blank" style="text-decoration:none">' + data.data[0].location_int + '</a></div>';
                    }

                    let card = '';

                    if (data.data[0].status == "2") {
                        card = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><div class="d-grid gap-2 d-md-flex justify-content-md-between"><div><strong>Alasan tidak diterima : </strong>' + data.data[0].reason_int + '</div><div></div></div>';
                        document.getElementById("ket").innerHTML = card;
                    }

                    if (data.data[0].status == "3") {
                        if (total > 0) {
                            button = '<div class="d-grid gap-2 d-md-flex justify-content-md-end"><button class="btn btn-success me-md-2" onclick="ACC(' + id + ')">Diterima</button><button class="btn btn-danger" onclick="Reject(' + id + ')">Ditolak</button></div>'
                        } else {
                            button = '<div class="d-grid gap-2 d-md-flex justify-content-md-end"><button class="btn btn-success me-md-2" disabled>diterima</button><button class="btn btn-danger" onclick="Reject(' + id + ')">Ditolak</button></div>'
                        }
                    } else {
                        button = '<div class="d-grid gap-2 d-md-flex justify-content-md-end"><button class="btn btn-success me-md-2" disabled>diterima</button><button class="btn btn-danger" disabled>Ditolak</button></div>'
                    }
                    document.getElementById("jurusan").innerHTML = jurusan;
                    document.getElementById("fakultas").innerHTML = fakultas;
                    document.getElementById("univ").innerHTML = univ;
                    document.getElementById("posisi").innerHTML = posisi;
                    document.getElementById("tanggal_int").innerHTML = tanggal;
                    document.getElementById("waktu_int").innerHTML = waktu;
                    document.getElementById("tipe_int").innerHTML = tipe;
                    document.getElementById("loc_int").innerHTML = lokasi;
                    document.getElementById("modal-footer").innerHTML = button;
                });
        }

        function ACC(id) {
            async function editStatus() {
                const api = await fetch('http://localhost/itdash/public/api/internselection/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        status: "4",
                    })
                })

                const data = await api.json();

                if (data.status == '2') {
                    $('#formData').modal('toggle');
                    Toast.fire({
                        icon: 'success',
                        title: 'Pengajuan magang diterima',
                    });
                    fetch('http://localhost/itdash/public/api/internselection/' + id, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer <?= session()->get('token'); ?>`
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            let userid = data.data[0].user_id;
                            let positionid = data.data[0].position_id;
                            let realization = data.data[0].realization;
                            let addreal = parseInt(realization) + 1;
                            fetch('http://localhost/itdash/public/api/internstudent', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                                    },
                                    body: JSON.stringify({
                                        user_id: userid,
                                        position_id: positionid,
                                        mentor_id: "0",
                                        status: "0",
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status = "1") {
                                        Toast.fire({
                                            icon: 'success',
                                            title: data.message,
                                        });
                                    }
                                });
                            fetch('http://localhost/itdash/public/api/addrealization/' + positionid, {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                                    },
                                    body: JSON.stringify({
                                        realization: addreal,
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status = "1") {
                                        Toast.fire({
                                            icon: 'success',
                                            title: data.message,
                                        });
                                    }
                                });
                            fetch('http://localhost/itdash/public/api/accept-email-int', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                                    },
                                    body: JSON.stringify({
                                        id: id,
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    location.reload();
                                    if (data.status == '1') {
                                        Toast.fire({
                                            icon: 'success',
                                            title: data.message,
                                        });
                                    }
                                });
                        });

                }
            }
            editStatus();
        }

        function Reject(id) {
            console.log(id);
            $('#detailData').modal('toggle');
            $("#declineData").modal("show");
            $("#modal-footer-decline").empty();
            $("#modal-footer-decline").append("<button type='submit' class='btn btn-primary' onclick='rejectInt(" + id + ")'>Simpan</button>");
        }

        function rejectInt(id) {
            let reason = document.getElementById('reason').value;

            fetch('http://localhost/itdash/public/api/internselectionintreject', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        selection_id: id,
                        reason: reason,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == '1') {
                        $('#declineData').modal('toggle');
                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        });
                        fetch('http://localhost/itdash/public/api/internselection/' + id, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                                },
                                body: JSON.stringify({
                                    status: "2",
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status == '2') {
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'Pengajuan magang ditolak',
                                    });
                                }
                            });
                        fetch('http://localhost/itdash/public/api/reject-email-int', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                                },
                                body: JSON.stringify({
                                    id: id,
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                location.reload();
                                if (data.status == '1') {
                                    Toast.fire({
                                        icon: 'success',
                                        title: data.message,
                                    });
                                }
                            });
                    }
                });

        }
    </script>