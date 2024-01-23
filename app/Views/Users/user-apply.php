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
                    <span class="title">Daftar Magang Saya</span>
                </div>
            </div>
            <div class="row pt-5 me-5" id="data-apply">
            </div>
        </div>
    </div>
</div>
<?= view('Layout/footer.php') ?>
<?= view('Layout/js.php') ?>

<script>
    let id = '<?= session()->get('id'); ?>';
    async function getUser() {
        const api = await fetch('http://localhost/itdash/public/api/user-apply/' + id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                // 'Authorization': `Bearer ${ token }`
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const response = await api.json();
        const data = response.data;

        console.log(response);

        let card = '';

        if (response.error === "Expired token") {
            window.location = "<?= base_url('/login') ?>"
        } else if (response.error === 404) {
            card = '<div class="card mb-5" id="user" style="height: 10rem;"><h3 class = "card-title" style = "margin: auto;"> Belum ada posisi yang didaftarkan </h3></div>'
            document.getElementById('data-apply').innerHTML = card;
        } else {
            for (var i = 0; i < data.length; i++) {
                if (data[i].status == '1') {
                    badge = '<span class="badge text-bg-warning ms-3 mt-2">Diajukan</span>';
                } else if (data[i].status == '4') {
                    badge = '<span class="badge text-bg-success ms-3 mt-2">Diterima</span>';
                } else if (data[i].status == '3') {
                    badge = '<span class="badge text-bg-primary ms-3 mt-2">Lolos Administrasi</span>';
                } else {
                    badge = '<span class="badge text-bg-danger ms-3 mt-2">Ditolak</span>';
                }
                let title = '<div class="d-flex align-items-center"><h5 class="card-title mt-3">' + data[i].position + ' </h5>' + badge + '</div>';
                let divisi = '<p class="card-text">DIVISI ' + data[i].divisi + '</p>';
                let periode = '<p class="card-text">Periode Magang ' + data[i].start_intern + ' sampai dengan ' + data[i].close_intern + '</p>'
                card = '<div class="card mb-5" style="height: 10rem;">' + title + '<hr>' + divisi + periode + '</div>';
                document.getElementById('data-apply').innerHTML += card;
            }
        }
    }
    getUser();
</script>