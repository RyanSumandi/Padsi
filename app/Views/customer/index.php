<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">DATA PRODUK</h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                <?= $title ?>
            </div>
            <div class="card-body">
                <!-- Grocery CRUD -->
                <div style="padding: 10px">
                    <?php echo $result->output; ?>
                </div>
                <!-- -->
            </div>
        </div>
    </div>
</main>
<?= $this->endSection() ?>