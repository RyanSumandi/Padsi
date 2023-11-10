<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA KOMIK</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">
                PENGELOLAAN DATA KOMIK
            </li>
        </ol>
        <!-- Start Flash Data -->
        <?php if (session()->getFlashdata('msg')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif; ?>
        <!-- End Flash Data -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Isi Detail -->
                <!--            -->
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="text-center col-md-4">
                            <img src="<?= base_url('img/' . $result['cover']); ?>" alt="" width="85%">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?= $result['judul'] ?></h5>
                                <p class="card-text">Penulis: <?= $result['penulis'] ?></p>
                                <p class="card-text">Tahun Rilis: <?= $result['tahun_rilis'] ?></p>
                                <p class="card-text">Stok: <?= $result['stok'] ?></p>
                                <p class="card-text">Harga: <?= $result['harga'] ?></p>
                                <p class="card-text">Diskon: <?= $result['diskon'] ?></p>
                                <div class="d-grid gap-2 d-md-block">
                                    <a class="btn btn-dark" type="button" href="<?= base_url('komik') ?>">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>