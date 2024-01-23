<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row pt-2">
                <span class="title">Data Tampilan Landing Page</span>
            </div>
            <div class="row pt-3 ms-2 me-2 mb-5">
                <table class="display cell-border" id="list-data" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 5rem;">No</th>
                            <th>Nama Gambar</th>
                            <th>Caption</th>
                            <th>Aksi</th>
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Tampilan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="npp" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="image" name="image" placeholder="">
                    <p class="text-secondary" id="check_image"></p>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Keterangan Gambar</label>
                    <input type="text" class="form-control" id="caption" name="caption" placeholder="">
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
    async function hitAPI() {
        const api = await fetch('http://localhost/itdash/public/api/settingdisplay', {
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

                let image = '<img class="img-profile me-3" src="<?= base_url() ?>assets/img/' + data[i].name_image + '" height="100px" width="200px"><p class="text-secondary"><a href="<?= base_url() ?>assets/img/' + data[i].name_image + '" target="_blank" style="text-decoration:none">Lihat Gambar</a></p>';

                rowContent = "<tr class='text-center'><td></td><td>" + image + "</td><td>" + data[i].caption + "</td><td><button class='btn btn-primary btn-sm' onclick=" + edit + ">Detail</button></td></tr>";
                $("#list-data tbody").append(rowContent);
            }

            var dt = $('#list-data').DataTable({
                columnDefs: [{
                    targets: [0, 1, 2, 3],
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
        $("#formData").modal("show");
        fetch('http://localhost/itdash/public/api/settingdisplay/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById("check_image").innerHTML = '<a href="<?= base_url() ?>assets/img/' + data.data[0].name_image + '" target="_blank" style="text-decoration:none">Gambar Landing Page</a>';
                document.getElementById("caption").value = data.data[0].caption;
                $("#modal-footer").empty();
                $("#modal-footer").append("<button type='submit' class='btn btn-primary' onclick='ubahData(" + id + ")'>Simpan</button>");
            });
    }

    function ubahData(id) {
        let fileimage = document.getElementById('image').files[0];
        let caption = document.getElementById('caption').value;

        const formData = new FormData();

        formData.append('id', id);
        formData.append('image', fileimage);
        formData.append('caption', caption);

        fetch('http://localhost/itdash/public/api/settingdisplay/' + id + '?_method=PUT', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            });
    }
</script>