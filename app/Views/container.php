<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<body>
    <h1>Container</h1>
    <div class="container">
        <div class="row bg-warning" style="height: 70vh;">
            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                <img src="/assets/img/s1.jpeg" alt="" width="150" height="200" class="rounded-circle">
                <p><strong>Biodata</strong></p>
                <p>Nama : Marcel Suryajaya</p>
                <p>TTL : Cirebon, 29-11-2003</p>
                <p>NPM : 211711322</p>
            </div>
            <div class="col-8 p-2">
                <div class="bg-primary h-100 d-flex flex-column align-items-center justify-content-center">
                    <img src="/assets/img/s2.png" alt="" width="300" height="200">
                    <p style="margin-top: 60px;">UAJY</p>
                    <p style="margin-top: 0,1px;">Pesan Kesan : Atma selalu dihati, karena yang dihati ada di Atmajaya</p>
                </div>
            </div>
        </div>
</body>
</div>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2022</div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
</body>

<?= $this->endSection() ?>