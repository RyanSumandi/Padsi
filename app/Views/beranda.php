<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">ROBO PETSHOP</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Daftar Produk</li>
            <img src="<?= base_url("https://www.google.com/imgres?imgurl=https%3A%2F%2Fcdn.onemars.net%2Fsites%2Fwhiskas_id_xGoUJ_mwh5%2Fimage%2Flarge_wks__tuna-flavour_1-2kg_1652270468516.png&tbnid=TeCe5x_ah61KcM&vet=12ahUKEwjFtvu377aCAxUuX2wGHUKqBooQMygDegQIARBy..i&imgrefurl=https%3A%2F%2Fwww.whiskasindonesia.com%2Fproduk-kami%2Fmakanan-kering%2Fwhiskas-dry-adult-1-tuna-flavour&docid=_YlbvZo6yYz0gM&w=450&h=450&q=whiskas&ved=2ahUKEwjFtvu377aCAxUuX2wGHUKqBooQMygDegQIARBy") ?>" alt="" width="70%">
        </ol>
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">WHISKAS</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">SEBAZOLE</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">CLOWN FISH</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">DWARVES HAMSTER</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Grafik Transaksi Penjualan
                        <div class="col-sm-2 mt-3">
                            <input type="number" id="tahun-trans" class="form-control" value="<?= date('Y') ?>" onchange="chartTransaksi()">
                        </div>
                    </div>
                    <div class="card-body"><canvas id="chartTransaksi" width="100%" height="40"></canvas></div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartTransaksi('PDF')">Unduh PDF</button>
                        <a id="download-trans" download="chart-transaksi.png">
                            <button class="btn btn-outline-secondary btn-sm" onclick="downloadChartTransaksi('PNG')">Unduh PNG</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area me-1"></i>
                        Grafik Transaksi Pembelian
                        <div class="col-sm-2 mt-3">
                            <input type="number" id="tahun-pem" class="form-control" value="<?= date('Y') ?>" onchange="chartPembelian()">
                        </div>
                    </div>
                    <div class="card-body"><canvas id="chartPembelian" width="100%" height="40"></canvas></div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartPembelian('PDF')">Unduh PDF</button>
                        <a id="download-pem" download="chart-pembelian.png">
                            <button class="btn btn-outline-secondary btn-sm" onclick="downloadChartPembelian('PNG')">Unduh PNG</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Grafik Customer
                        <div class="col-sm-2 mt-3">
                            <input type="number" id="tahun-cust" class="form-control" value="<?= date('Y') ?>" onchange="chartCustomer()">
                        </div>
                    </div>
                    <div class="card-body"><canvas id="chartCust" width="100%" height="40"></canvas></div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartCustomer('PDF')">Unduh PDF</button>
                        <a id="download-cust" download="chart-customer.png">
                            <button class="btn btn-outline-secondary btn-sm" onclick="downloadChartCustomer('PNG')">Unduh PNG</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Grafik Supplier
                        <div class="col-sm-2 mt-3">
                            <input type="number" id="tahun-sup" class="form-control" value="<?= date('Y') ?>" onchange="chartSupplier()">
                        </div>
                    </div>
                    <div class="card-body"><canvas id="chartSup" width="100%" height="40"></canvas></div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-outline-primary btn-sm" onclick="downloadChartSupplier('PDF')">Unduh PDF</button>
                        <a id="download-sup" download="chart-supplier.png">
                            <button class="btn btn-outline-secondary btn-sm" onclick="downloadChartSupplier('PNG')">Unduh PNG</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        chartTransaksi()
        chartPembelian()
        chartCustomer()
        chartSupplier()
    });

    // ==================== TRANSAKSI ================================= //
    function setLineChart1(dataset) {
        // Area Chart Example
        var ctx = document.getElementById("chartTransaksi");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Total",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartTransaksi() {
        var tahun = $('#tahun-trans').val();
        $.ajax({
            url: "/chart-transaksi",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setLineChart1(dataset)
            }
        });
    }

    // ==================== PEMBELIAN ================================= //
    function setLineChart(dataset) {
        // Area Chart Example
        var ctx = document.getElementById("chartPembelian");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "Total",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartPembelian() {
        var tahun = $('#tahun-pem').val();
        $.ajax({
            url: "/chart-pembelian",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setLineChart(dataset)
            }
        });
    }

    // ==================== CUSTOMER ================================= //
    function setBarChart1(dataset) {
        // Bar Chart Example
        var ctx = document.getElementById("chartCust");
        var myLineChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Oct", "Nov", "Des"],
                datasets: [{
                    label: "Jumlah",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: dataset,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'month'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    function chartCustomer() {
        var tahun = $('#tahun-cust').val();
        $.ajax({
            url: "/chart-customer",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)

                dataset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setBarChart1(dataset)
            }
        });
    }

    // ==================== SUPPLIER ================================= //
    function setPieChart(dataset) {
        // Pie Chart Example
        var ctx = document.getElementById("chartSup");
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"],
                datasets: [{
                    label: "jumlah",
                    data: dataset,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(245, 66, 66)',
                        'rgb(245, 150, 66)',
                        'rgb(245,239,66)',
                        'rgb(153,245,66)',
                        'rgb(66, 245, 185)',
                        'rgb(66, 105, 245)',
                        'rgb(173, 66, 245)',
                        'rgb(245, 66, 215)',
                        'rgb(245, 66, 87)',
                    ],
                    hoverOffset: 4
                }],
            },
        });
    }

    function chartSupplier() {
        var tahun = $('#tahun-sup').val();
        $.ajax({
            url: "/chart-supplier",
            method: "POST",
            data: {
                'tahun': tahun,
            },
            success: function(response) {
                var result = JSON.parse(response)


                dataset = [0, 0, 0, 0, 0, 0, 0]
                $.each(result.data, function(i, val) {
                    dataset[val.month - 1] = val.total
                });
                setPieChart(dataset)
            }
        });
    }

    function downloadChartImg(download, chart) {
        var img = chart.toDataURL("image/jpg", 1.0).replace("image/jpg", "image/octet-stream")
        download.setAttribute("href", img)
    }

    function downloadChartPDF(chart, name) {
        html2canvas(chart, {
            onrendered: function(canvas) {
                var img = canvas.toDataURL("image/jpg", 1.0)
                var doc = new jsPDF('p', 'pt', 'A4')
                var lebarKonten = canvas.width
                var tinggiKonten = canvas.height
                var tinggiPage = lebarKonten / 592.28 * 841.89
                var leftHeight = tinggiKonten
                var position = 0
                var imgWidth = 595.28
                var imgHeight = 592.28 / lebarKonten * tinggiKonten
                if (leftHeight < tinggiPage) {
                    doc.addImage(img, 'PNG', 0, 0, imgWidth, imgHeight)
                } else {
                    while (leftHeight > 0) {
                        doc.addImage(img, 'PNG', 0, position, imgWidth, imgHeight)
                        leftHeight -= tinggiPageposition -= 841.89
                        if (leftHeight > 0) {
                            pdf.addPage()
                        }
                    }
                }
                doc.save(name)
            }
        });
    }

    function downloadChartTransaksi(type) {
        var download = document.getElementById('download-trans')
        var chart = document.getElementById('chartTransaksi')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Transaksi.pdf")
        }
    }

    function downloadChartPembelian(type) {
        var download = document.getElementById('download-pem')
        var chart = document.getElementById('chartPembelian')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Pembelian.pdf")
        }
    }

    function downloadChartCustomer(type) {
        var download = document.getElementById('download-cust')
        var chart = document.getElementById('chartCust')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Customer.pdf")
        }
    }

    function downloadChartSupplier(type) {
        var download = document.getElementById('download-sup')
        var chart = document.getElementById('chartSup')

        if (type == "PNG") {
            downloadChartImg(download, chart)
        } else {
            downloadChartPDF(chart, "Chart-Supplier.pdf")
        }
    }
</script>
<?= $this->endSection() ?>