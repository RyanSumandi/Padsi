<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<body>
    <h1>Container</h1>
    <div class="container-fluid">
        <div class="row bg-warning text-center">
            <p>Container 1 - Gambar</p>
            <div class="col-6 p-0">
                <div class="bg-primary h-100 d-flex flex-column align-items-center justify-content-center">
                    <p style="margin-top: 30px;">
                        <img src="/assets/img/s3.jpg" alt="" width="300" height="200">
                    <p style="margin-top: 3px;">Kucing </p>
                </div>
            </div>
            <div class="col-6 p-0">
                <div class="bg-success d-flex flex-column align-items-center justify-content-center">
                    <p style="margin-top: 30px;">
                        <img src="/assets/img/s4.jpg" alt="" width="300" height="200">
                    <p style="margin-top: 3px;">Monyet</p>
                </div>
            </div>
        </div>

    </div>
    <div class="container-fluid px-0 mt-5">
        <div class="row bg-warning text-center">
            <p>Container 2 - Pesan dan Kesan</p>
            <div class="col-7 p-0">
                <div class="bg-info h-100 d-flex flex-column align-items-center justify-content-center">
                    <p style="margin-top: 30px;">
                    <p style="margin-top: 3px;">Kucing </p>
                    <p style="margin-top: 3px;">Kucing </p>
                </div>
            </div>
            <div class="col-5 p-0">
                <div class="bg-primary h-100 d-flex flex-column align-items-center justify-content-center">
                    <p style="margin-top: 30px;">
                    <p style="margin-top: 3px;">Monyet</p>
                    <p style="margin-top: 3px;">Monyet</p>
                    <p style="margin-top: 3px;">Monyet</p>
                    <p style="margin-top: 3px;">Monyet</p>
                    <p style="margin-top: 3px;">Monyet</p>
                    <p style="margin-top: 3px;">Monyet</p>
                </div>
            </div>
        </div>
    </div>
</body>
<?= $this->endSection() ?>