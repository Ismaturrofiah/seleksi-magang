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
                                <th>Posisi</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
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
                        <label for="mentor" class="form-label">Mentor</label>
                        <select class="form-select" id="select-mentor" aria-label="Default select example">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mentor" class="form-label">Status</label>
                        <select class="form-select" id="select-status" aria-label="Default select example">
                            <option value='0'>Masih Berlangsung</option>
                            <option value='2'>Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" id="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <?= view('Layout/js'); ?>
    <script src="<?= base_url('assets/js/alert.js') ?>"></script>
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

            const {
                data
            } = await api.json()

            for (var i = 0; i < data.length; i++) {
                const id = data[i].id;
                const edit = "EditData('" + id + "')";
                if (data[i].status == 0) {
                    stat = '<span class="badge text-bg-warning ms-3">Masih Berlangsung</span>';
                } else if (data[i].status == 1) {
                    stat = '<span class="badge text-bg-primary ms-3">Dinyatakan Selesai oleh Divisi</span>';
                } else if (data[i].status == 2) {
                    stat = '<span class="badge text-bg-warning ms-3">Selesai Magang</span>';
                };
                rowContent = "<tr class='text-center'><td></td><td>" + data[i].name + "</td><td>" + data[i].university + "</td><td>" + data[i].faculty + "</td><td>" + data[i].major + "</td><td>" + data[i].divisi + "</td><td>" + data[i].position + "</td><td>" + data[i].start_intern + "</td><td>" + data[i].close_intern + "</td></tr>";
                $("#list-data tbody").append(rowContent);
            }

            var dt = $('#list-data').DataTable({
                columnDefs: [{
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8],
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
    </script>