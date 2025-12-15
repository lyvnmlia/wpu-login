<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row"> 
        <div class="col-lg-12">

            <!-- Tampilkan Error Form -->
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <!-- Tampilkan Flash Message -->
            <?= $this->session->flashdata('message'); ?>

            <!-- Tombol Tambah Menu -->
            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newMenuModal">Add New Menu</a>

            <!-- Tabel Menu -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($menu as $m): ?>
                    <tr>
                        <th scope="row"><?= $i; ?></th>
                        <td><?= $m['menu']; ?></td>
                        <td>
                            <!-- Tombol Edit -->
                            <a href="#" class="badge text-bg-info" 
                               data-bs-toggle="modal" 
                               data-bs-target="#editMenuModal<?= $m['id']; ?>">Edit</a>

                            <!-- Tombol Delete -->
                            <a href="<?= base_url('menu/delete/' . $m['id']); ?>" 
                               class="badge text-bg-danger"
                               onclick="return confirm('Are you sure you want to delete this menu?');">Delete</a>
                        </td>
                    </tr>

                    <!-- Modal Edit Per Item -->
                    <div class="modal fade" id="editMenuModal<?= $m['id']; ?>" tabindex="-1" aria-labelledby="editMenuModalLabel<?= $m['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editMenuModalLabel<?= $m['id']; ?>">Edit Menu</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= base_url('menu/edit/' . $m['id']); ?>" method="post">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="menu" value="<?= $m['menu']; ?>" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>

                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>      

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->   


<!-- Modal Tambah Menu -->
<div class="modal fade" id="newMenuModal" tabindex="-1" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="newMenuModalLabel">Add New Menu</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?= base_url('menu'); ?>" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu name" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
        </div>
    </div>
</div>
