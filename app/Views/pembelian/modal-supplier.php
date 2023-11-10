<div class="modal fade" id="modalSupp" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalToggleLabel">Data Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="datatableSimple2">
                    <thead>
                        <tr>
                            <th width="%5">No</th>
                            <th width="20%">Nama</th>
                            <th width="30%">No Supplier</th>
                            <th width="15%">Email</th>
                            <th width="15%">Telp</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($dataSupp as $value) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $value['name'] ?></td>
                                <td><?= $value['no_supplier'] ?></td>
                                <td><?= $value['email'] ?></td>
                                <td><?= $value['phone'] ?></td>
                                <td>
                                    <button onclick="selectSupplier('<?= $value['supplier_id'] ?>','<?= $value['name'] ?>')" class="btn btn-success"><i class="fa fa-plus"></i>Pilih
                                    </button>
                                </td>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <script>
                    function selectSupplier(id, name) {
                        $('#id-supp').val(id);
                        $('#nama-supp').val(name);
                        $('#modalSupp').modal('hide');
                    }
                </script>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-body">

    <!-- -->
</div>