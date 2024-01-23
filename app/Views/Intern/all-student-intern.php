<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row pt-2">
                <span class="title">Daftar Mahasiswa</span>
            </div>
            <div class="row d-flex pt-3 ms-3 me-2 justify-content-between">
            </div>
            <div class="row mt-3">
                <div class="row d-flex pt-3 ms-2 me-2 mb-5">
                    <table class="display cell-border" id="list-data" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama</th>
                                <th>Universitas</th>
                                <th>Fakultas</th>
                                <th>Jurusan</th>
                                <th>Divisi</th>
                                <th>Pembimbing</th>
                                <th>Posisi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th style="width: 2.5rem;">Aksi</th>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Data Magang</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="major" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="major" name="major" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="faculty" class="form-label">Fakultas</label>
                        <input type="text" class="form-control" id="faculty" name="faculty" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="division" class="form-label">Universitas</label>
                        <input type="text" class="form-control" id="univ" name="univ" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="mentor" class="form-label">Mentor</label>
                        <select class="form-select" id="select-mentor" aria-label="Default select example">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="text" class="form-control" id="year" name="year" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="finish_date" class="form-label">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="finish_date" name="finish_date" placeholder="">
                    </div>
                </div>
                <div class="modal-footer" id="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <?= view('Layout/js'); ?>
    <script>
        let npp = "<?= session()->get('npp') ?>"
        async function hitAPI() {
            const api = await fetch('http://localhost/itdash/public/api/internstudent?npp=' + npp, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                }
            })

            const response = await api.json();
            const data = response.alldata;

            for (var i = 0; i < data.length; i++) {
                const id = data[i].id;
                const edit = "EditData('" + id + "')";
                let stat = ''
                if (data[i].status == 0) {
                    stat = '<span class="badge text-bg-warning ms-3">Masih Berlangsung</span>'
                    rowContent = "<tr class='text-center'><td></td><td>" + data[i].name + "</td><td>" + data[i].university + "</td><td>" + data[i].faculty + "</td><td>" + data[i].major + "</td><td>" + data[i].divisi + "</td><td>" + data[i].mentor + "</td><td>" + data[i].position + "</td><td>" + data[i].start_intern + "</td><td>" + data[i].close_intern + "</td><td>" + stat + "</td><td><i class='material-icons me-2 action-warning'>edit</i></td></tr>";
                } else if (data[i].status == 1) {
                    stat = '<span class="badge text-bg-primary ms-3">Dinyatakan Selesai oleh Divisi</span>'
                    rowContent = "<tr class='text-center'><td></td><td>" + data[i].name + "</td><td>" + data[i].university + "</td><td>" + data[i].faculty + "</td><td>" + data[i].major + "</td><td>" + data[i].divisi + "</td><td>" + data[i].mentor + "</td><td>" + data[i].position + "</td><td>" + data[i].start_intern + "</td><td>" + data[i].close_intern + "</td><td>" + stat + "</td><td><i class='material-icons me-2 action-warning' onclick=" + edit + ">edit</i></td></tr>";
                } else if (data[i].status == 2) {
                    stat = '<span class="badge text-bg-warning ms-3">Selesai Magang</span>'
                    rowContent = "<tr class='text-center'><td></td><td>" + data[i].name + "</td><td>" + data[i].university + "</td><td>" + data[i].faculty + "</td><td>" + data[i].major + "</td><td>" + data[i].divisi + "</td><td>" + data[i].mentor + "</td><td>" + data[i].position + "</td><td>" + data[i].start_intern + "</td><td>" + data[i].close_intern + "</td><td>" + stat + "</td><td><i class='material-icons me-2 action-warning'>edit</i></td></tr>";
                }
                $("#list-data tbody").append(rowContent);
            }

            var dt = $('#list-data').DataTable({
                columnDefs: [{
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
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
        hitAPI();

        // List Mentor
        // async function getMentor() {
        //     const api = await fetch('http://localhost/itdash/public/api/internmentor', {
        //         method: 'GET',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'Authorization': `Bearer <?= session()->get('token'); ?>`
        //         }
        //     })

        //     const {
        //         data
        //     } = await api.json()

        //     let select = '';
        //     for (var i = 0; i < data.length; i++) {
        //         select += "<option value='" + data[i].id + "'>" + data[i].name + "</option>"
        //     }
        //     document.getElementById("select-mentor").innerHTML = select;
        // }
        // getMentor();



        // Edit Data
        function EditData(id) {
            $("#formData").modal("show");
            async function showData() {
                const api = await fetch('http://localhost/itdash/public/api/internstudent/' + id, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    }
                })

                const {
                    data
                } = await api.json()

                console.log(data);

                for (var i = 0; i < data.length; i++) {
                    document.getElementById('name').value = data[i].name;
                    document.getElementById('major').value = data[i].major;
                    document.querySelector('#select-univ').value = data[i].university_id;
                    document.querySelector('#select-division').value = data[i].division_id;
                    document.querySelector('#select-mentor').value = data[i].mentor_id;
                    document.getElementById('year').value = data[i].year;
                    document.getElementById('start_date').value = data[i].start_date;
                    document.getElementById('finish_date').value = data[i].finish_date;
                    $("#modal-footer").empty();
                    $("#modal-footer").append("<button type='button' class='btn btn-primary' onclick='editData(" + data[i].id + ")'>Simpan</button>");
                }
            }
            showData();
        }

        function editData(id) {
            let name = document.querySelector('#name').value;
            let major = document.querySelector('#major').value;
            let univ = document.getElementById('select-univ').value;
            let division = document.getElementById('select-division').value;
            let mentor = document.getElementById('select-mentor').value;
            let year = document.querySelector('#year').value;
            let start_date = document.querySelector('#start_date').value;
            let finish_date = document.querySelector('#finish_date').value;

            async function editAPI() {
                const api = await fetch('http://localhost/itdash/public/api/internstudent/' + id, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        // 'Authorization': `Bearer ${ token }`
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        name: name,
                        major: major,
                        university_id: univ,
                        division_id: division,
                        mentor_id: mentor,
                        year: year,
                        start_date: start_date,
                        finish_date: finish_date,
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
    </script>