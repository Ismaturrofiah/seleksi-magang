<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row pt-2">
                <span class="title">Kategori Work Order</span>
            </div>
            <div class="row d-flex pt-3 ms-3 me-2 justify-content-between">
                <div class="col">
                    <button class="btn btn-primary" type="submit">Tambah Data</button>
                </div>
            </div>
            <div class="row pt-3 ms-2 me-2 mb-5">
                <table class="display cell-border" id="data-wocategory" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 5rem;">No</th>
                            <th>Nama Kategori</th>
                            <th>Kode Kategori</th>
                            <th>Tahun</th>
                            <th style="width: 7.5rem;">Aksi</th>
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
<?= view('Layout/js'); ?>
<script>
    // let token = JSON.parse(sessionStorage.getItem('token'));

    // console.log(token);

    async function hitAPI() {
        const api = await fetch('http://localhost/itdash/public/api/data-wocategory', {
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
            rowContent = "<tr class='text-center'><td></td><td>" + data[i].name + "</td><td>" + data[i].code + "</td><td>" + data[i].year + "</td><td><i class='material-icons me-2 action-warning'>edit</i><i class = 'material-icons ms-2 action-danger'>delete </i></td></tr>";
            $("#data-wocategory tbody").append(rowContent);
        }

        var category = $('#data-wocategory').DataTable({
            columnDefs: [{
                targets: [0, 1, 2, 3, ],
                className: 'dt-head-center'
            }, ],
        });
        category.on('order.dt search.dt', function() {
            let i = 1;

            category.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();
    }

    hitAPI();
</script>