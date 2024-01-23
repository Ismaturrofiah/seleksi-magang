<?= view('Layout/header'); ?>
<?= view('Layout/topbar'); ?>
<div id='wrapper'>
    <?= view('Layout/sidebar'); ?>
    <div class="content" id="content">
        <div class="container-fluid">
            <div class="row">
                <?= view('Dashboard/tabs-dashboard'); ?>
                <!-- Tab content -->
                <div class="col-12">
                    <!-- Filter -->
                    <div class="row align-items-center mt-2 me-3">
                        <div class="col-lg-8 col-md-6">
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-2">
                            <div class="year-filter">
                                <select class="form-select bg-light border-0" name="year" id="year" onchange="getDataWOChange()" aria-label="Default select example">
                                    <option value=<?php echo date("Y") ?>>
                                        <?php echo date("Y") ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content Row -->
                <div class="row ms-2 mt-2 me-2">
                    <div class="col-md-7 col-12">
                        <div class="row">
                            <div class="d-flex">
                                <span class="m-0 title-summary mb-1">DATA KERJASAMA INSTANSI</span>
                            </div>
                            <div id="map" style="width: 55vw; height: 37vh;"></div>
                        </div>
                    </div>
                    <div class="col-md-4 col-12 ms-5">
                        <div class="d-flex">
                            <span class="m-0 ms-2 title-summary mb-1">QUOTA MAGANG</span>
                        </div>
                        <div id="chart-quota" style="height: 40vh;"></div>
                    </div>
                </div>
                <div class="row ms-2 mt-2">
                    <div class="col-12">
                        <div class="row">
                            <div class="d-flex">
                                <span class="m-0 title-summary mb-1">DATA PERSEBARAN MAGANG</span>
                            </div>
                            <div class="chart-container" style="position: relative; height:30vh; width:100vw">
                                <canvas id="myBarLearningChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= view('Layout/footer'); ?>
    </div>
</div>
<?= view('Layout/js'); ?>
<script src="<?= base_url('assets/vendor/leaflet/GeoJsonData.js') ?>"></script>
<style>
    .leaflet-tooltip.my-labels {
        background-color: transparent;
        border: transparent;
        box-shadow: none;
        color: #ffff;
    }
</style>
<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    (Chart.defaults.global.defaultFontFamily = "Nunito"),
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = "#858796";

    function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
    let year = document.getElementById('year').value;
    async function quotaAPI() {
        const api = await fetch('http://localhost/itdash/public/api/quota-learning?year=' + year, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const data = await api.json();

        const quota = parseInt(data.quota[0].quota);
        const realisasi = parseInt(data.quota[0].realization);

        const dataSource = {
            chart: {
                lowerlimit: "0",
                upperlimit: quota,
                lowerlimitdisplay: "Empty",
                upperlimitdisplay: quota + "person",
                numbersuffix: " person",
                cylfillcolor: "#5D62B5",
                plottooltext: "Terisi: <b>" + realisasi + " person</b>",
                cylfillhoveralpha: "85",
                theme: "fusion",
                showValue: "1"
            },
            value: realisasi
        };

        FusionCharts.ready(function() {
            var myChart = new FusionCharts({
                type: "cylinder",
                renderAt: "chart-quota",
                width: "100%",
                height: "90%",
                dataFormat: "json",
                dataSource
            }).render();
        });
    }
    quotaAPI();

    async function instansiAPI() {
        const api = await fetch('http://localhost/itdash/public/api/instansi-learning?year=' + year, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                // 'Authorization': `Bearer ${ token }`
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })

        const {
            instansi
        } = await api.json()

        var map = L.map('map').setView([-0.0786956, 119.282488], 4.4);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        map.createPane('labels');
        map.getPane('labels').style.zIndex = 1;
        map.getPane('labels').style.pointerEvents = 'none';
        var positron = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
            attribution: '©CartoDB'
        }).addTo(map);

        var positronLabels = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
            attribution: '©CartoDB',
            pane: 'labels'
        }).addTo(map);
        var geojson = L.geoJson(GeoJsonData).addTo(map);
        geojson.eachLayer(function(layer) {
            layer.bindPopup(layer.feature.properties.name);
        });

        map.fitBounds(geojson.getBounds());

        var stepIcon = L.icon({
            iconUrl: '<?= base_url('assets/vendor/leaflet/images/circle-48.png') ?>', // the background image you want
            iconSize: [25, 25], // size of the icon
        });

        for (var i = 0; i < instansi.length; i++) {
            let latitude = instansi[i].latitude;
            let longitude = instansi[i].longitude

            var marker = L.marker([latitude, longitude], {
                icon: stepIcon
            });
            marker.bindTooltip(instansi[i].total, {
                permanent: true,
                direction: 'center',
                className: "my-labels"
            });
            marker.addTo(map);
            marker.bindPopup(instansi[i].region + " : " + instansi[i].total + " INSTANSI", {
                className: "my-popup",
                closeButton: false
            });
            marker.on('mouseover', function(e) {
                this.openPopup();
            });
            marker.on('mouseout', function(e) {
                this.closePopup();
            });
            marker.on('click', function(e) {
                this.openPopup();
                //disable mouseout behavior here?
            });
        }
    }
    instansiAPI();

    async function divisiAPI() {
        const api = await fetch('http://localhost/itdash/public/api/divisi-learning?year=' + year, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer <?= session()->get('token'); ?>`
            }
        })
        const {
            divisi
        } = await api.json()

        let label_div = [];
        let label_totals = [];

        for (var i = 0; i < divisi.length; i++) {
            label_div.push(divisi[i].division);
            label_totals.push(divisi[i].total);
        }


        var ctx = document.getElementById("myBarLearningChart");
        var myBarLearningChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: label_div,
                datasets: [{
                    label: "Total",
                    backgroundColor: [
                        "#7cb5ec",
                        "#7cb5ec",
                        "#7cb5ec",
                    ],
                    borderColor: "#4e73df",
                    data: label_totals,
                }, ],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0,
                    },
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: "month",
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false,
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 0,
                            minRotation: 0,
                            fontSize: 10
                        },
                        maxBarThickness: 35,
                    }, ],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function(value, index, values) {
                                return number_format(value);
                            },
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2],
                        },
                    }, ],
                },
                legend: {
                    display: false,
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: "#6e707e",
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: "#dddfeb",
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    callbacks: {
                        label: function(tooltipItem, chart) {
                            var datasetLabel =
                                chart.datasets[tooltipItem.datasetIndex].label || "";
                            return datasetLabel + " : " + number_format(tooltipItem.yLabel);
                        },
                    },
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Open Work Order',
                    },
                    datalabels: {
                        display: false,
                    },
                }
            },
        });
    }
    divisiAPI();
</script>