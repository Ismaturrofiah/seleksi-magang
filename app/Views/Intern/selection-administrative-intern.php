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
</div>
<div class="modal fade" id="detailData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header" id="headermodal">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col" id="ket">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3 row" id="gender">
                        </div>
                        <div class="mb-3 row" id="birth">
                        </div>
                        <div class="mb-3 row" id="phone">
                        </div>
                        <div class="mb-3 row" id="address">
                        </div>
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
                <div class="mb-3 row" id="cv">
                </div>
                <div class="mb-3 row" id="proposal">
                </div>
            </div>
            <div class="modal-footer" id="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="accData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jadwal Wawancara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="posisi" class="form-label">Wawancara akan dilakukan secara</label>
                    <select class="form-select" id="select-type" name="type" aria-label="Default select example">
                        <option value='Offline'>Secara langsung</option>
                        <option value='Online'>Online</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="posisi" class="form-label">Tanggal wawancara</label>
                    <input type="date" class="form-control" id="date_int" name="date_int">
                </div>
                <div class="mb-3">
                    <label for="posisi" class="form-label">Waktu wawancara</label>
                    <input type="time" class="form-control" id="time_int" name="time_int">
                </div>
                <div class="mb-3">
                    <label for="posisi" class="form-label">Lokasi</label>
                    <textarea class="form-control" placeholder="Lokasi wawancara (Nama tempat jika offline dan link jika online)" id="location"></textarea>
                </div>
            </div>
            <div class="modal-footer" id="modal-footer-acc">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="declineData" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alasan Tidak Lolos Administrasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" placeholder="Alasan tidak lolos administrasi" id="reason"></textarea>
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
        const api = await fetch('http://localhost/itdash/public/api/internselection?npp=' + npp, {
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
                const edit = "EditData('" + id + "')";

                if (data[i].status == '1') {
                    badge = '<span class="badge text-bg-warning">Diajukan</span>'
                } else if (data[i].status == '2') {
                    badge = '<span class="badge text-bg-success">Diterima</span>'
                } else if (data[i].status == '0') {
                    badge = '<span class="badge text-bg-danger">Ditolak</span>'
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

                rowContent = "<tr class='text-center'><td></td><td>" + data[i].name + "</td><td>" + data[i].position + "</td><td>" + startreqdate + " s/d " + closereqdate + "</td><td>" + startinterndate + " s/d " + closeinterndate + "</td><td>" + badge + "</td><td><button class='btn btn-primary btn-sm' onclick=" + edit + ">Detail</button></td></tr>";
                $("#list-data tbody").append(rowContent);
            }

            var dt = $('#list-data').DataTable({
                columnDefs: [{
                    targets: [0, 1, 2, 3, 4, 5, 6],
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

    // Edit Data
    function EditData(id) {
        $("#detailData").modal("show");
        fetch('http://localhost/itdash/public/api/internselection/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                }
            })
            .then(response => response.json())
            .then(data => {
                let button = '';
                let gender = '';
                let ket = '';
                let card = '';

                let id = data.data[0].id;
                if (data.data[0].status == '1') {
                    badge = '<span class="badge text-bg-warning ms-3">Diajukan</span>';
                } else if (data.data[0].status == '2') {
                    badge = '<span class="badge text-bg-success ms-3">Diterima</span>';
                } else if (data.data[0].status == '0') {
                    badge = '<span class="badge text-bg-danger ms-3">Ditolak</span>';
                    card = '<div class="alert alert-danger alert-dismissible fade show" role="alert"><div class="d-grid gap-2 d-md-flex justify-content-md-between"><div><strong>Alasan tidak diterima : </strong>' + data.data[0].reason + '</div><div></div><button class="btn btn-primary me-md-2" type="button" onclick="editdec(' + data.data[0].adm_id + ')">Ubah</button></div></div>';
                    document.getElementById("ket").innerHTML = card;
                }
                let headermodal = '<h1 class="modal-title fs-5" id="staticBackdropLabel">' + data.data[0].name + '</h1>' + badge + '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                if (data.data[0].gender == "P") {
                    gender = '<div class="col">Jenis Kelamin: Perempuan </div>';
                } else if (data.data[0].gender == "L") {
                    gender = '<div class="col">Jenis Kelamin: Laki - Laki</div>';
                }
                const date = new Date(data.data[0].birthdate);
                const mmdate = ("0" + (date.getMonth() + 1)).slice(-2);
                const birthdate = ("0" + date.getDate()) + "-" + mmdate + "-" + date.getFullYear();

                let birth = '<div class="col">Tempat, Tanggal Lahir: ' + data.data[0].birthplace + ', ' + birthdate + '</div>';
                let phone = '<div class="col">Nomor Telepon: ' + data.data[0].number_phone + ' </div>';
                let alamat = '<div class="col">Program Studi: ' + data.data[0].address + ' </div>';
                let jurusan = '<div class="col">Program Studi: ' + data.data[0].major + ' </div>';
                let fakultas = '<div class="col">Fakultas: ' + data.data[0].faculty + ' </div>';
                let univ = '<div class="col">Universitas: ' + data.data[0].universitas + '</div>';
                let posisi = '<div class="col">Posisi yang dituju: ' + data.data[0].position + '</div>';
                let photo = '<img class="img-profile me-3" style="border: 2px solid #555" src="<?= base_url() ?>photo/' + data.data[0].photo + '" height="250px">'
                let cv = '<label for="cv" class="form-label">Curiculum Vitae <a href="<?= base_url() ?>cv/' + data.data[0].curiculum_vitae + '" target="_blank" style="text-decoration:none">' + data.data[0].curiculum_vitae + '</a></label><embed src="<?= base_url() ?>cv/' + data.data[0].curiculum_vitae + '" height="300px" />'
                let proposal = '<label for="proposal" class="form-label">Proposal <a href="<?= base_url() ?>proposal/' + data.data[0].proposal + '" target="_blank" style="text-decoration:none">' + data.data[0].proposal + '</a></label><embed src="<?= base_url() ?>proposal/' + data.data[0].proposal + '" height="300px" />'
                if (data.data[0].status === '0') {
                    button = '<div class="d-grid gap-2 d-md-flex justify-content-md-end"><button class="btn btn-success me-md-2" onclick="ACC(' + id + ')">Lolos Administrasi</button><button class="btn btn-danger" disabled>Belum Memenuhi Syarat</button></div>'
                } else {
                    button = '<div class="d-grid gap-2 d-md-flex justify-content-md-end"><button class="btn btn-success me-md-2" onclick="ACC(' + id + ')">Lolos Administrasi</button><button class="btn btn-danger" onclick="Reject(' + id + ')">Belum Memenuhi Syarat</button></div>'
                }

                document.getElementById("headermodal").innerHTML = headermodal;
                document.getElementById("gender").innerHTML = gender;
                document.getElementById("birth").innerHTML = birth;
                document.getElementById("phone").innerHTML = phone;
                document.getElementById("address").innerHTML = alamat;
                document.getElementById("jurusan").innerHTML = jurusan;
                document.getElementById("fakultas").innerHTML = fakultas;
                document.getElementById("univ").innerHTML = univ;
                document.getElementById("posisi").innerHTML = posisi;
                document.getElementById("photo").innerHTML = photo;
                document.getElementById("cv").innerHTML = cv;
                document.getElementById("proposal").innerHTML = proposal;
                document.getElementById("modal-footer").innerHTML = button;
            });
    }

    function ACC(id) {
        $('#detailData').modal('toggle');
        $("#accData").modal("show");
        const DateInt = document.getElementById('date_int');
        const dateint = new Date();
        dateint.setDate(dateint.getDate() + 2);
        const ddIntern = ("0" + dateint.getDate()).slice(-2);
        const mmIntern = ("0" + (dateint.getMonth() + 1)).slice(-2);
        const endIntern = dateint.getFullYear() + "-" + mmIntern + "-" + ddIntern;

        DateInt.setAttribute("min", endIntern);
        $("#modal-footer-acc").empty();
        $("#modal-footer-acc").append("<button type='submit' class='btn btn-primary' onclick='addInt(" + id + ")'>Simpan</button>");
    }

    function addInt(id) {
        let type = document.getElementById('select-type').value;
        let date_int = document.getElementById('date_int').value;
        let time_int = document.getElementById('time_int').value;
        let location_int = document.getElementById('location').value;

        fetch('http://localhost/itdash/public/api/internselectionint', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: JSON.stringify({
                    selection_id: id,
                    type_int: type,
                    date_int: date_int,
                    time_int: time_int,
                    location_int: location_int,
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status == '1') {
                    $('#accData').modal('toggle');
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    });
                    // location.reload();
                    fetch('http://localhost/itdash/public/api/internselection/' + id, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer <?= session()->get('token'); ?>`
                            },
                            body: JSON.stringify({
                                status: "3",
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status == '2') {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Pengajuan magang lolos seleksi administrasi',
                                });
                            }
                        });
                    fetch('http://localhost/itdash/public/api/accept-email-adm', {
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
                            console.log(data);
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

    function Reject(id) {
        $("#declineData").modal("show");
        $("#modal-footer-decline").empty();
        $("#modal-footer-decline").append("<button type='submit' class='btn btn-primary' onclick='addAdm(" + id + ")'>Simpan</button>");
    }

    function addAdm(id) {
        let reason = document.getElementById('reason').value;

        fetch('http://localhost/itdash/public/api/internselectionadm', {
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
                                status: "0",
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
                    fetch('http://localhost/itdash/public/api/reject-email-adm', {
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

    function editdec(id) {
        $("#declineData").modal("show");
        fetch('http://localhost/itdash/public/api/internselectionadm/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('reason').value = data.data[0].reason;
            });
        $("#modal-footer-decline").empty();
        $("#modal-footer-decline").append("<button type='submit' class='btn btn-primary' onclick='editAdm(" + id + ")'>Simpan</button>");
    }

    function editAdm(id) {
        let reason = document.getElementById('reason').value;
        fetch('http://localhost/itdash/public/api/internselectionadm/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: JSON.stringify({
                    reason: reason,
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status == '2') {
                    $('#declineData').modal('toggle');
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    });
                    location.reload();
                }
            });
    }
</script>