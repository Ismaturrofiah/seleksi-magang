<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row pt-2">
                <span class="title">Daftar Pembimbing</span>
            </div>
            <div class="row d-flex pt-3 ms-3 me-2 justify-content-between">
            </div>
            <div class="row mt-3">
                <div class="row d-flex pt-3 ms-2 me-2 mb-5">
                    <table class="display cell-border" id="data-mentor" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>NPP</th>
                                <th>Nama</th>
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
        let npp = "<?= session()->get('npp'); ?>"
        async function hitAPI() {
            const api = await fetch('http://localhost/itdash/public/api/internmentor?npp=' + npp, {
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
                const edit = "EditMentor('" + id + "')";
                const del = "DeleteMentor('" + id + "')";
                rowContent = "<tr class='text-center'><td></td><td>" + data[i].npp + "</td><td>" + data[i].name + "</td></tr>";
                $("#data-mentor tbody").append(rowContent);
            }

            var dtmentor = $('#data-mentor').DataTable({
                columnDefs: [{
                    targets: [0, 1, 2],
                    className: 'dt-head-center'
                }, ],
                "ordering": false
            });
            dtmentor.on('order.dt search.dt', function() {
                let i = 1;

                dtmentor.cells(null, 0, {
                    search: 'applied',
                    order: 'applied'
                }).every(function(cell) {
                    this.data(i++);
                });
            }).draw();
        }
        hitAPI();
    </script>