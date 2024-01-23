<?= view('Layout/header.php') ?>
<?= view('Layout/topbar'); ?>

<div class="container landing-page">
    <h1 class="title-landing-page">Program Magang</h1>
    <div class="row pt-3" id="top">
        <img src="<?= base_url('assets/img/dashboard.png') ?>" alt="" height="430px">
        <div class="d-flex justify-content-center mt-1 fst-italic text-secondary">
            <span>Alur Seleksi Magang</span>
        </div>
    </div>
    <div class="row pt-5" id="show">
    </div>
</div>

<div class="modal fade" id="detail-position" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" id="modalshow">
        <div class="modal-content">
        </div>
    </div>
</div>

<div class="modal fade" id="confirm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah yakin mendaftar di posisi ini?
            </div>
            <div class="modal-footer" id="confirm-footer">
            </div>
        </div>
    </div>
</div>

<?= view('Layout/footer.php') ?>
<?= view('Layout/js.php') ?>
<script src="<?= base_url('assets/js/alert.js') ?>"></script>
<script>
    async function getData() {
        const api = await fetch('http://localhost/itdash/public/api/position', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        })

        const {
            data
        } = await api.json()

        let card = '';

        if (data != null) {
            for (var i = 0; i < data.length; i++) {
                let id = data[i].id;
                let quota = parseInt(data[i].quota) - parseInt(data[i].realization);
                let title = '<h5 class="card-title card-title-dashboard">' + data[i].position + '</h5>';
                let division = '<p class="card-text card-text-dashboard">DIVISI ' + data[i].divisi + '</p>';
                let kuota = '<p class="card-kuota">Kuota: ' + quota + ' </p>';
                const startintern = new Date(data[i].start_intern);
                const ddstartintern = ("0" + (startintern.getDate() + 1)).slice(-2);
                const mmstartintern = ("0" + (startintern.getMonth() + 1)).slice(-2);
                const startinterndate = ddstartintern + "-" + mmstartintern + "-" + startintern.getFullYear();
                const closeintern = new Date(data[i].close_intern);
                const ddcloseintern = ("0" + (closeintern.getDate() + 1)).slice(-2);
                const mmcloseintern = ("0" + (closeintern.getMonth() + 1)).slice(-2);
                const closeinterndate = ddcloseintern + "-" + mmcloseintern + "-" + closeintern.getFullYear();

                let periode = '<p class="card-periode">Periode Magang: <br/>' + startinterndate + ' s/d ' + closeinterndate + ' </p>';
                let detail = '<a href="#" class="btn btn-primary" onclick="Detail(' + id + ')">Selengkapnya</a>';
                card = '<div class="card mb-3 card-page" style="width: 18rem;"><div class="card-body">' + title + division + kuota + periode + '</div><div class="card-footer"><div class="d-grid gap-2">' + detail + '</div></div></div>';
                document.getElementById('show').innerHTML += card;
            }
        } else {

        }
    }
    getData();

    function Detail(id) {
        $("#detail-position").modal("show");
        async function getData() {
            const api = await fetch('http://localhost/itdash/public/api/detail-position/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                }
            })

            const {
                data
            } = await api.json()

            let modal = '';
            let modalheader = '';
            let modalbody = '';
            let modalfooter = '';
            let apply = '';
            let button = '';
            let user_id = "<?= session()->get('id'); ?>";
            for (var i = 0; i < data.length; i++) {
                let id = data[i].id;
                let quota = parseInt(data[i].quota) - parseInt(data[i].realization);
                let title = '<h1 class="modal-title fs-5" id="staticBackdropLabel">' + data[i].position + '</h1>';
                let division = '<p class="text-divisi-position">DIVISI ' + data[i].divisi + '</p>';
                let titledetail = '<p class="text-detail-position">Detail</p>';
                let detail = '<p>' + data[i].detail + '</p>';
                let kuota = '<p class="text-kuota-position">Kuota: ' + quota + '</p>';
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

                let apply = '<p>Pendaftaran dapat dilakukan mulai ' + startreqdate + ' sampai ' + closereqdate + '</p>';
                let periode = '<p class="text-periode-position">Periode Magang: ' + startinterndate + ' s/d ' + closeinterndate + '</p>';
                <?php if (!session()->has('isLoggedIn')) { ?>
                    button = "<button type='button' class='btn btn-primary' disabled>Daftar</button>";
                    modalheader = '<div class="modal-header">' + title + '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>';
                    modalbody = '<div class="modal-body">' + division + titledetail + detail + apply + periode + kuota + '</div>';
                    modalfooter = '<div class="modal-footer">' + button + '</div>';
                    modal = '<div class="modal-content">' + modalheader + modalbody + modalfooter + '</div>';
                    document.getElementById('modalshow').innerHTML = modal;
                <?php } else { ?>
                    async function getDataApply() {
                        const api = await fetch('http://localhost/itdash/public/api/cek-apply?id=' + user_id, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer <?= session()->get('token'); ?>`
                            }
                        })

                        const response = await api.json();

                        if (response.error == "Expired token") {
                            window.location = "<?= base_url('/') ?>"
                        } else if (response.error == 404) {
                            button = "<button type='button' class='btn btn-primary' onclick='Daftar(" + id + ")'>Daftar</button>";
                            modalheader = '<div class="modal-header">' + title + '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>';
                            modalbody = '<div class="modal-body">' + division + titledetail + detail + apply + periode + kuota + '</div>';
                            modalfooter = '<div class="modal-footer">' + button + '</div>';
                            modal = '<div class="modal-content">' + modalheader + modalbody + modalfooter + '</div>';
                            document.getElementById('modalshow').innerHTML = modal;
                        } else {
                            button = "<button type='button' class='btn btn-primary' disabled>Daftar</button>";
                            modalheader = '<div class="modal-header">' + title + '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>';
                            modalbody = '<div class="modal-body">' + division + titledetail + detail + apply + periode + kuota + '</div>';
                            modalfooter = '<div class="modal-footer">' + button + '</div>';
                            modal = '<div class="modal-content">' + modalheader + modalbody + modalfooter + '</div>';
                            document.getElementById('modalshow').innerHTML = modal;
                        }
                    }
                    getDataApply();
                <?php } ?>
            }
        }
        getData();
    }

    <?php if (session()->has('isLoggedIn')) { ?>

        function Daftar(id) {
            let user_id = "<?= session()->get('id'); ?>";
            async function getData() {
                const api = await fetch('http://localhost/itdash/public/api/cek-user?id=' + user_id, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        // 'Authorization': `Bearer ${ token }`
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    }
                })

                const response = await api.json();

                if (response.error == "Expired token") {
                    window.location = "<?= base_url('/login') ?>"
                } else if (response.data[0].user_id === null) {
                    alert('Lengkapi data diri pada menu profil');
                } else {
                    let iduser = response.data[0].id;
                    let idposition = id;
                    $("#confirm").modal("show");
                    $('#detail-position').modal('toggle');
                    $("#confirm-footer").empty();
                    $("#confirm-footer").append("<button type='submit' class='btn btn-primary' onclick='Apply(" + iduser + "," + idposition + ")'>Simpan</button>");
                }
            }
            getData();
        }

        function Apply(iduser, idposition) {
            async function applyData() {
                const api = await fetch('http://localhost/itdash/public/api/apply', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        // 'Authorization': `Bearer ${ token }`
                        'Authorization': `Bearer <?= session()->get('token'); ?>`
                    },
                    body: JSON.stringify({
                        position_id: idposition,
                        user_id: iduser,
                        status: "1",
                    })
                })

                const response = await api.json();
                const data = response.data;

                if (response.status == '1') {
                    $('#confirm').modal('toggle');
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                    })
                    location.reload();
                } else {
                    $('#confirm').modal('toggle');
                    Toast.fire({
                        icon: 'error',
                        title: response.message,
                    })
                    location.reload();
                }
            }
            applyData();
        }
    <?php } ?>
</script>