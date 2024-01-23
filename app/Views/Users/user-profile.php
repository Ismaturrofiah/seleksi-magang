<?= view('Layout/header.php') ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <div class="content pb-5" id="content">
        <div class="container-fluid">
            <div class="row pt-2 d-flex">
                <?php if (session()->get('role') == 3) { ?>
                    <div class="col-2 mt-3">
                        <a class="dropdown-item" href="<?= base_url('/') ?>"><i class="material-icons me-2">keyboard_backspace</i></a>
                    </div>
                <?php } else { ?>
                    <div class="col-2 mt-3">
                        <a class="dropdown-item" href="<?= base_url('/dashboard/e-learning') ?>"><i class="material-icons me-2">keyboard_backspace</i></a>
                    </div>
                <?php } ?>
                <div class="col-10">
                    <span class="title">Pengaturan Akun</span>
                </div>
            </div>
            <div class="row pt-3 me-5">
                <div class="card mb-3" id="user">
                </div>
            </div>
            <div class="row pt-3 me-5">
                <div class="card mb-3" id="identity">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formIdentity" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Identitas Mahasiswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="form-identity">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="posisi" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="select-gender" name="gender" aria-label="Default select example">
                            <option value='L'>Laki - Laki</option>
                            <option value='P'>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="month" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" id="birthplace" name="birthplace">
                            </div>
                            <div class="col-md-6">
                                <label for="month" class="form-label">Tanggal Lahir Lahir</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="month" class="form-label">Nomor Telepon</label>
                        <input type="number" class="form-control" id="number_phone" name="number_phone" maxlength="13" minlength="10">
                    </div>
                    <div class="mb-3">
                        <label for="month" class="form-label">Alamat</label>
                        <textarea class="form-control" id="address" name="address"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="posisi" class="form-label">Universitas</label>
                        <select class="form-select" id="select-univ" name="univ" aria-label="Default select example" onchange="Faculty()">
                        </select>
                        <p class="text-secondary">Belum ada universitasmu? <a href="#" class="card-link" onclick="addUniv()">Tambah Universitas</a></p>
                    </div>
                    <div class="mb-3">
                        <label for="posisi" class="form-label">Fakultas</label>
                        <select class="form-select" id="select-fac" name="fac" aria-label="Default select example" onchange="Major()">
                            <option>Pilih Fakultas</option>
                        </select>
                        <p class="text-secondary">Belum ada fakultasmu? <a href="#" class="card-link" onclick="addFac()">Tambah Fakultas</a></p>
                    </div>
                    <div class="mb-3">
                        <label for="posisi" class="form-label">Program Studi</label>
                        <select class="form-select" id="select-major" name="major" aria-label="Default select example">
                            <option>Pilih Program Studi</option>
                        </select>
                        <p class="text-secondary">Belum ada program studimu? <a href="#" class="card-link" onclick="addMajor()">Tambah Program Studi</a></p>
                    </div>
                    <div class="mb-3">
                        <label for="month" class="form-label">Foto Profil (.jpg atau .jpeg atau .png max 1 MB)</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        <p class="text-secondary" id="check_photo"></p>
                    </div>
                    <div class="mb-3">
                        <label for="month" class="form-label">Curiculum Vitae (.pdf max 2 MB)</label>
                        <input type="file" class="form-control" id="cv" name="cv">
                        <p class="text-secondary" id="check_cv"></p>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Proposal (.pdf max 2 MB)</label>
                        <input type="file" class="form-control" id="proposal" name="proposal">
                        <p class="text-secondary" id="check_proposal"></p>
                    </div>
                </div>
                <div class="modal-footer" id="modal-footer">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="formUniv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Universitas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Universitas</label>
                    <input type="text" class="form-control" id="univ" name="univ" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="region" class="form-label">Provinsi</label>
                    <select class="form-select" id="select-region" aria-label="Default select example">
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addUniversity()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formFac" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Fakultas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama fakultas</label>
                    <input type="text" class="form-control" id="fac" name="fac" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="region" class="form-label">Nama Universitas</label>
                    <select class="form-select" id="select-univ2" aria-label="Default select example">
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addFaculty()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="formMajor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Program Studi</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama program studi</label>
                    <input type="text" class="form-control" id="major" name="major" placeholder="">
                </div>
                <div class="mb-3">
                    <label for="region" class="form-label">Nama universitas</label>
                    <select class="form-select" id="select-univ3" aria-label="Default select example" onchange="Faculty2()">
                    </select>
                </div>
                <div class="mb-3">
                    <label for="region" class="form-label">Nama fakultas</label>
                    <select class="form-select" id="select-fac2" aria-label="Default select example">
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="addMajors()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<?= view('Layout/footer.php') ?>
<?= view('Layout/js.php') ?>
<script src="<?= base_url('assets/js/alert.js') ?>"></script>
<script>
    let user_id = "<?= session()->get('id'); ?>";
    async function getUser() {
        const api = await fetch('http://localhost/itdash/public/api/user?id=' + user_id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const response = await api.json();
        const data = response.data;

        if (response.error === "Expired token") {
            window.location = "<?= base_url('/login') ?>"
        } else {
            let carduser = '';
            let button = ''
            for (var i = 0; i < data.length; i++) {
                let id = data[i].id;
                // let button = '<a class="btn btn-primary" onclick="editUser(' + id + ')">Ubah</a>';
                let name = '<p class="card-text">' + data[i].name + '</p>';
                let email = '<p class="card-text">' + data[i].email + '</p>';
                let password = '<p class="card-text hidetext">' + data[i].password + '</p>';

                let cardbutton = '<div class="d-grid gap-2 d-md-flex justify-content-md-end">' + button + '</div>';
                let cardname = '<h5 class="card-title">Nama</h5>' + name;
                let cardemail = '<hr><h5 class="card-title">Email</h5>' + email;
                let cardpassword = '<hr><h5 class="card-title">Password</h5>' + password;
                carduser = '<div class="card-body">' + cardbutton + cardname + cardemail + cardpassword + '</div>';
            }
            document.getElementById('user').innerHTML = carduser;
        }
    }
    getUser();

    async function getIdentity() {
        const api = await fetch('http://localhost/itdash/public/api/identity?id=' + user_id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const response = await api.json();
        const data = response.data;

        if (response.error === "Expired token") {
            window.location = "<?= base_url('/login') ?>"
        } else {
            let cardidentity = '';
            let button = '';
            let gender = '';
            let birth = '';
            let phone = '';
            let address = '';
            let univ = '';
            let major = '';
            let fac = '';
            let photo = '';
            let cv = '';
            let proposal = '';
            if (data[0].id === null) {
                let userid = data[0].user_id;
                button = '<a class="btn btn-primary" onclick="tambahIdentity()">Lengkapi Data Diri</a>';
                gender = '<p class="card-text">-</p>';
                birth = '<p class="card-text">-</p>';
                phone = '<p class="card-text">-</p>';
                address = '<p class="card-text">-</p>';
                univ = '<p class="card-text">-</p>';
                major = '<p class="card-text">-</p>';
                fac = '<p class="card-text">-</p>';
                photo = '<p class="card-text">-</p>';
                cv = '<p class="card-text">-</p>';
                proposal = '<p class="card-text">-</p>';
            } else {
                let id = data[0].id;
                button = '<a class="btn btn-primary" onclick="editIdentity(' + id + ')">Ubah</a>';
                if (data[0].gender == "P") {
                    gender = '<p class="card-text">Perempuan</p>';
                } else if (data[0].gender == "L") {
                    gender = '<p class="card-text">Laki - Laki</p>';
                }

                birth = '<p class="card-text">' + data[0].birthplace + ', ' + data[0].birthdate + '</p>';
                phone = '<p class="card-text">' + data[0].number_phone + '</p>';
                address = '<p class="card-text">' + data[0].address + '</p>';
                univ = '<p class="card-text">' + data[0].universitas + '</p>';
                major = '<p class="card-text">' + data[0].major + '</p>';
                fac = '<p class="card-text">' + data[0].faculty + '</p>';
                photo = '<a href="<?= base_url() ?>photo/' + data[0].photo + '" target="_blank" style="text-decoration:none">File Photo</a>';
                cv = '<a href="<?= base_url() ?>cv/' + data[0].curiculum_vitae + '" target="_blank" style="text-decoration:none">File Curriculum Vitae</a>';
                proposal = '<a href="<?= base_url() ?>proposal/' + data[0].proposal + '" target="_blank" style="text-decoration:none">File Proposal</a>';
            }
            let cardbutton = '<div class="d-grid gap-2 d-md-flex justify-content-md-end">' + button + '</div>';
            let cardgender = '<h5 class="card-title">Jenis Kelamin</h5>' + gender;
            let cardbirth = '<hr><h5 class="card-title">Tempat, Tanggal Lahir</h5>' + birth;
            let cardphone = '<hr><h5 class="card-title">Nomor Telepon</h5>' + phone;
            let cardaddress = '<hr><h5 class="card-title">Alamat</h5>' + address;
            let carduniv = '<hr><h5 class="card-title">Universitas</h5>' + univ;
            let cardfac = '<hr><h5 class="card-title">Fakultas</h5>' + fac;
            let cardmajor = '<hr><h5 class="card-title">Program Studi</h5>' + major;
            let cardphoto = '<hr><h5 class="card-title">Foto Profil</h5>' + photo;
            let cardcv = '<hr><h5 class="card-title">Curiculum Vitae</h5>' + cv;
            let cardproposal = '<hr><h5 class="card-title">Proposal</h5>' + proposal;
            cardidentity = '<div class="card-body">' + cardbutton + cardgender + cardbirth + cardphone + cardaddress + carduniv + cardfac + cardmajor + cardphoto + cardcv + cardproposal + '</div>';
            document.getElementById('identity').innerHTML = cardidentity;
        }
    }
    getIdentity();

    // List Universitas
    async function getUniversity() {
        const api = await fetch('http://localhost/itdash/public/api/internuniversity', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const response = await api.json();
        const data = response.data;

        let select = '';
        let defaultselect = "<option>Pilih Universitas</option>";
        for (var i = 0; i < data.length; i++) {
            select += "<option value='" + data[i].id + "'>" + data[i].university + "</option>"
        }
        document.getElementById("select-univ").innerHTML = defaultselect + select;
        document.getElementById("select-univ2").innerHTML = defaultselect + select;
        document.getElementById("select-univ3").innerHTML = defaultselect + select;
    }
    getUniversity();

    function Faculty() {
        let univ = document.getElementById('select-univ').value;

        // List Fakultas
        async function getFaculty() {
            const api = await fetch('http://localhost/itdash/public/api/faculty?univ=' + univ, {
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

            let select = '';
            let defaultselect = "<option>Pilih Fakultas</option>";
            for (var i = 0; i < data.length; i++) {
                select += "<option value='" + data[i].id + "'>" + data[i].name + "</option>"
            }
            document.getElementById("select-fac").innerHTML = defaultselect + select;
        }
        getFaculty();
    }

    function Faculty2() {
        let univ = document.getElementById('select-univ3').value;

        console.log(univ);
        // List Fakultas
        async function getFaculty() {
            const api = await fetch('http://localhost/itdash/public/api/faculty?univ=' + univ, {
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

            let select = '';
            let defaultselect = "<option>Pilih Fakultas</option>";
            for (var i = 0; i < data.length; i++) {
                select += "<option value='" + data[i].id + "'>" + data[i].name + "</option>"
            }
            document.getElementById("select-fac2").innerHTML = defaultselect + select;
        }
        getFaculty();
    }

    function Major() {
        let fac = document.getElementById('select-fac').value;
        // List Program Studi
        async function getMajor() {
            const api = await fetch('http://localhost/itdash/public/api/major?fac=' + fac, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                }
            })

            const {
                data
            } = await api.json();

            let select = '';
            let defaultselect = "<option>Pilih Program Studi</option>";
            for (var i = 0; i < data.length; i++) {
                select += "<option value='" + data[i].id + "'>" + data[i].name + "</option>"
            }
            document.getElementById("select-major").innerHTML = defaultselect + select;
        }
        getMajor();
    }

    function tambahIdentity() {
        $("#formIdentity").modal("show");
        const OpenReq = document.getElementById('birthdate');
        const open = new Date();
        const ddReq = ("0" + open.getDate()).slice(-2);
        const mmReq = ("0" + (open.getMonth() + 1)).slice(-2);
        const yyReq = open.getFullYear() - 17;
        const endReq = yyReq + "-" + mmReq + "-" + ddReq;
        OpenReq.setAttribute("max", endReq);
        $("#modal-footer").empty();
        $("#modal-footer").append("<button type='submit' class='btn btn-primary' onclick='addData()'>Tambah Data</button>");
    }

    function addData() {
        $("#form-identity").validate({
            rules: {
                gender: {
                    required: true,
                },
                birthplace: {
                    required: true,
                },
                birthdate: {
                    required: true,
                },
                number_phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 13,
                },
                address: {
                    required: true,
                },
                univ: {
                    required: true,
                },
                fac: {
                    required: true,
                },
                major: {
                    required: true,
                },
                photo: {
                    required: true,
                    accept: "image/*",
                    extension: "jpg|jpeg|png",
                    filesize: 2048,
                },
                cv: {
                    required: true,
                    accept: "application/pdf",
                    extension: "pdf",
                    filesize: 2048,
                },
                proposal: {
                    required: true,
                    accept: "application/pdf",
                    extension: "pdf",
                    filesize: 2048,
                },
            },
            messages: {
                gender: {
                    required: "Pilih jenis kelamin",
                },
                birthplace: {
                    required: "Masukan tempat lahir",
                },
                birthdate: {
                    required: "Masukan tanggal lahir",
                },
                phone_number: {
                    required: "Masukan nomor telepon",
                    minlength: "Minimal 10 digit angka",
                    maxlength: "Maksimal 13 digit angka"
                },
                address: {
                    required: "Masukan alamat",
                },
                univ: {
                    required: "Pilih universitas",
                },
                fac: {
                    required: "Pilih fakultas",
                },
                major: {
                    required: "Pilih program studi",
                },
                photo: {
                    required: "Upload file foto",
                    accept: "Format file .jpg atau .jpeg atau .png",
                    extension: "Format file .jpg atau .jpeg atau .png",
                    filesize: "Ukuran file maksimal 2 MB",
                },
                cv: {
                    required: "Upload file curiculum vitae",
                    accept: "Format file .pdf",
                    extension: "Format file .pdf",
                    filesize: "Ukuran file maksimal 2 MB",
                },
                proposal: {
                    required: "Upload file proposal",
                    accept: "Format file .pdf",
                    extension: "Format file .pdf",
                    filesize: "Ukuran file maksimal 2 MB",
                },
            }
        });
        let usersid = <?= session()->get('id') ?>;
        let gender = document.getElementById('select-gender').value;
        let birthplace = document.getElementById('birthplace').value;
        let birthdate = document.getElementById('birthdate').value;
        let number_phone = document.getElementById('number_phone').value;
        let address = document.getElementById('address').value;
        let university_id = document.getElementById('select-univ').value;
        let faculty_id = document.getElementById('select-fac').value;
        let major_id = document.getElementById('select-major').value;
        let filephoto = document.getElementById('photo').files[0];
        let filecv = document.getElementById('cv').files[0];
        let fileproposal = document.getElementById('proposal').files[0];

        const formData = new FormData();

        formData.append('user_id', usersid);
        formData.append('gender', gender);
        formData.append('birthplace', birthplace);
        formData.append('birthdate', birthdate);
        formData.append('number_phone', number_phone);
        formData.append('address', address);
        formData.append('university_id', university_id);
        formData.append('faculty_id', faculty_id);
        formData.append('major_id', major_id);
        formData.append('photo', filephoto);
        formData.append('cv', filecv);
        formData.append('proposal', fileproposal);

        fetch('http://localhost/itdash/public/api/studentidentity', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status = "1") {
                    window.location = "<?= base_url('/user/profile') ?>"
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    });
                }
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: data.message,
                });
            });
    }

    function editIdentity(id) {
        $("#formIdentity").modal("show");
        const OpenReq = document.getElementById('birthdate');
        const open = new Date();
        const ddReq = ("0" + open.getDate()).slice(-2);
        const mmReq = ("0" + (open.getMonth() + 1)).slice(-2);
        const yyReq = open.getFullYear() - 17;
        const endReq = yyReq + "-" + mmReq + "-" + ddReq;
        OpenReq.setAttribute("max", endReq);
        fetch('http://localhost/itdash/public/api/studentidentity/' + id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('select-gender').value = data.data[0].gender;
                document.getElementById('birthplace').value = data.data[0].birthplace;
                document.getElementById('birthdate').value = data.data[0].birthdate;
                document.getElementById('number_phone').value = data.data[0].number_phone;
                document.getElementById('address').value = data.data[0].address;
                document.getElementById('select-univ').value = data.data[0].university_id;
                document.getElementById('select-fac').innerHTML = "<option value='" + data.data[0].faculty_id + "'>" + data.data[0].faculty + "</option>";
                document.getElementById('select-major').innerHTML = "<option value='" + data.data[0].major_id + "'>" + data.data[0].major + "</option>";
                document.getElementById('check_photo').innerHTML = '<a href="<?= base_url() ?>photo/' + data.data[0].photo + '" target="_blank" style="text-decoration:none">' + data.data[0].photo + '</a>';
                document.getElementById('check_cv').innerHTML = '<a href="<?= base_url() ?>cv/' + data.data[0].curiculum_vitae + '" target="_blank" style="text-decoration:none">' + data.data[0].curiculum_vitae + '</a>';
                document.getElementById('check_proposal').innerHTML = '<a href="<?= base_url() ?>proposal/' + data.data[0].proposal + '" target="_blank" style="text-decoration:none">' + data.data[0].proposal + '</a>';
                $("#modal-footer").empty();
                $("#modal-footer").append("<button type='submit' class='btn btn-primary' onclick='ubahData(" + id + ")'>Simpan</button>");
            });
    }

    function ubahData(id) {
        $("#form-identity").validate({
            rules: {
                gender: {
                    required: true,
                },
                birthplace: {
                    required: true,
                },
                birthdate: {
                    required: true,
                },
                number_phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 13,
                },
                address: {
                    required: true,
                },
                univ: {
                    required: true,
                },
                fac: {
                    required: true,
                },
                major: {
                    required: true,
                },
                photo: {
                    required: true,
                    accept: "image/*",
                    extension: "jpg|jpeg|png",
                    filesize: 2048,
                },
                cv: {
                    required: true,
                    accept: "application/pdf",
                    extension: "pdf",
                    filesize: 2048,
                },
                proposal: {
                    required: true,
                    accept: "application/pdf",
                    extension: "pdf",
                    filesize: 2048,
                },
            },
            messages: {
                gender: {
                    required: "Pilih jenis kelamin",
                },
                birthplace: {
                    required: "Masukan tempat lahir",
                },
                birthdate: {
                    required: "Masukan tanggal lahir",
                },
                phone_number: {
                    required: "Masukan nomor telepon",
                    minlength: "Minimal 10 digit angka",
                    maxlength: "Maksimal 13 digit angka"
                },
                address: {
                    required: "Masukan alamat",
                },
                univ: {
                    required: "Pilih universitas",
                },
                fac: {
                    required: "Pilih fakultas",
                },
                major: {
                    required: "Pilih program studi",
                },
                photo: {
                    required: "Upload file foto",
                    accept: "Format file .jpg atau .jpeg atau .png",
                    extension: "Format file .jpg atau .jpeg atau .png",
                    filesize: "Ukuran file maksimal 2 MB",
                },
                cv: {
                    required: "Upload file curiculum vitae",
                    accept: "Format file .pdf",
                    extension: "Format file .pdf",
                    filesize: "Ukuran file maksimal 2 MB",
                },
                proposal: {
                    required: "Upload file proposal",
                    accept: "Format file .pdf",
                    extension: "Format file .pdf",
                    filesize: "Ukuran file maksimal 2 MB",
                },
            }
        });
        let usersid = <?= session()->get('id') ?>;
        let gender = document.getElementById('select-gender').value;
        let birthplace = document.getElementById('birthplace').value;
        let birthdate = document.getElementById('birthdate').value;
        let number_phone = document.getElementById('number_phone').value;
        let address = document.getElementById('address').value;
        let university_id = document.getElementById('select-univ').value;
        let faculty_id = document.getElementById('select-fac').value;
        let major_id = document.getElementById('select-major').value;
        let filephoto = document.getElementById('photo').files[0];
        let filecv = document.getElementById('cv').files[0];
        let fileproposal = document.getElementById('proposal').files[0];

        const formData = new FormData();

        formData.append('id', id);
        formData.append('user_id', usersid);
        formData.append('gender', gender);
        formData.append('birthplace', birthplace);
        formData.append('birthdate', birthdate);
        formData.append('number_phone', number_phone);
        formData.append('address', address);
        formData.append('university_id', university_id);
        formData.append('faculty_id', faculty_id);
        formData.append('major_id', major_id);
        formData.append('photo', filephoto);
        formData.append('cv', filecv);
        formData.append('proposal', fileproposal);

        fetch('http://localhost/itdash/public/api/studentidentity/' + id + '?_method=PUT', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status = "2") {
                    window.location = "<?= base_url('/user/profile') ?>"
                    Toast.fire({
                        icon: 'success',
                        title: data.message,
                    });
                }
            })
            .catch(error => {
                Toast.fire({
                    icon: 'error',
                    title: data.message,
                });
            });
    }

    // List Provinsi
    async function getRegion() {
        const api = await fetch('http://localhost/itdash/public/api/region', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                // 'Authorization': `Bearer ${ token }`
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const {
            data
        } = await api.json();

        let select = '';
        for (var i = 0; i < data.length; i++) {
            select += "<option value='" + data[i].id + "'>" + data[i].name + "</option>"
        }
        document.getElementById("select-region").innerHTML = select;
    }
    getRegion();

    function addUniv() {
        $('#formIdentity').modal('toggle');
        $("#formUniv").modal("show");
    }

    // Create Data
    function addUniversity() {
        let univ = document.querySelector('#univ').value;
        let region = document.getElementById('select-region').value;

        async function addAPI() {
            const api = await fetch('http://localhost/itdash/public/api/internuniversity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // 'Authorization': `Bearer ${ token }`
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: JSON.stringify({
                    name: univ,
                    region_id: region,
                    year: new Date().getFullYear(),
                })
            })

            const data = await api.json();

            if (data.status == '1') {
                $("#formUniv").modal("toggle");
                location.reload();
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data.message
                });
            }
        }
        addAPI();
    }

    function addFac() {
        $('#formIdentity').modal('toggle');
        $("#formFac").modal("show");
    }

    // Create Data
    function addFaculty() {
        let fac = document.getElementById('fac').value;
        let univ = document.getElementById('select-univ2').value;

        async function addAPI() {
            const api = await fetch('http://localhost/itdash/public/api/internfaculty', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: JSON.stringify({
                    name: fac,
                    university_id: univ,
                })
            })

            const data = await api.json();

            if (data.status == '1') {
                $("#formFac").modal("toggle");
                location.reload();
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data.message
                });
            }
        }
        addAPI();
    }

    function addMajor() {
        $('#formIdentity').modal('toggle');
        $("#formMajor").modal("show");
    }

    // Create Data
    function addMajors() {
        let major = document.getElementById('major').value;
        let univ = document.getElementById('select-fac2').value;

        async function addAPI() {
            const api = await fetch('http://localhost/itdash/public/api/internmajor', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer <?= session()->get('token'); ?>`
                },
                body: JSON.stringify({
                    name: major,
                    faculty_id: univ,
                })
            })

            const data = await api.json();

            if (data.status == '1') {
                $("#formFac").modal("toggle");
                location.reload();
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data.message
                });
            }
        }
        addAPI();
    }
</script>