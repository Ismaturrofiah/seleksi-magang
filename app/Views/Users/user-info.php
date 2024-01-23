<?= view('Layout/header.php') ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <div class="content pb-5" id="content">
        <div class="container-fluid">
            <div class="row pt-2 d-flex">
                <div class="col-2 mt-3">
                    <a class="dropdown-item" href="<?= base_url('/') ?>"><i class="material-icons me-2">keyboard_backspace</i></a>
                </div>
                <div class="col-10">
                    <span class="title">Info Seputar Seleksi Magang</span>
                </div>
            </div>
            <div class="row pt-5 me-5 pb-5" id="data-info">
                <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jadwal Seleksi Magang</h5>
                        </div>
                    </div>
                </a>
                <div class="collapse" id="collapseExample">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
                            <table class="table table-bordered" id="data-schedule">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Jadwal</th>
                                        <th scope="col" class="text-center">Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= view('Layout/footer.php') ?>
<?= view('Layout/js.php') ?>
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
            for (var i = 0; i < data.display.length; i++) {
                let date = '';

                const nameMonth = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

                const startdate = new Date(data.display[i].startdate);
                const mmstartdate = nameMonth[startdate.getMonth()];
                const startdatedate = startdate.getDate() + " " + mmstartdate + " " + startdate.getFullYear();
                if (data.display[i].closedate == null) {
                    date = startdatedate;
                } else {
                    const closedate = new Date(data.display[i].closedate);
                    const mmclosedate = nameMonth[closedate.getMonth()];
                    const closedatedate = closedate.getDate() + " " + mmclosedate + " " + closedate.getFullYear();
                    date = startdatedate + ' - ' + closedatedate;
                }

                rowContent = '<tr><td>' + data.display[i].name + '</td><td>' + date + '</td></tr>';
                $("#data-schedule tbody").append(rowContent);
            }
        });
</script>