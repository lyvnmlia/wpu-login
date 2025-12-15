<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row"> 
        <div class="col-lg">

            <!-- Tampilkan Validasi Error -->
            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php endif; ?>

            <!-- Flash Message -->
            <?= $this->session->flashdata('message'); ?>

            <!-- Tombol Tambah Jurusan -->
            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newJurusanModal">
                Add New Jurusan
            </a>

            <!-- Tabel Jurusan -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Code Jurusan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($jurusan as $j): ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= htmlspecialchars($j['nama']); ?></td>
                            <td><?= set_value('deskripsi', $j['deskripsi']); ?>
                            <td><?= htmlspecialchars($j['code_jurusan']); ?></td>
                            <td> 
                                <!-- Tombol Edit -->
                                <a href="#" class="badge bg-info text-white" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#editJurusanModal<?= $j['id']; ?>">Edit</a>

                                <!-- Tombol Delete -->
                                <a href="<?= base_url('jurusan/delete/' . $j['id']); ?>" 
                                   class="badge bg-danger text-white"
                                   onclick="return confirm('Apakah anda yakin ingin menghapus jurusan ini?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                        
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>      

</div>
                    </div>
<!-- End of Container -->

<!-- =============================== -->
<!-- Modal Tambah Jurusan -->
<div class="modal fade" id="newJurusanModal" tabindex="-1" aria-labelledby="newJurusanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="newJurusanModalLabel">Add New Jurusan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?= base_url('jurusan'); ?>" method="post">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group mb-2">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="code_jurusan">Code Jurusan</label>
                    <input type="text" class="form-control" id="code_jurusan" name="code_jurusan" required>
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

<!-- =============================== -->
<!-- Modal Edit Jurusan (per data) -->
<?php foreach ($jurusan as $j): ?>
<div class="modal fade" id="editJurusanModal<?= $j['id']; ?>" tabindex="-1" aria-labelledby="editJurusanModalLabel<?= $j['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editJurusanModalLabel<?= $j['id']; ?>">Edit Jurusan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?= base_url('jurusan/edit/' . $j['id']); ?>" method="post">
            <input type="hidden" name="id" value="<?= $j['id']; ?>">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="nama<?= $j['id']; ?>">Nama</label>
                    <input type="text" class="form-control" id="nama<?= $j['id']; ?>" name="nama" value="<?= set_value('nama', $j['nama']); ?>" required>
                </div>
                <div class="form-group mb-2">
                    <label for="deskripsi<?= $j['id']; ?>">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi<?= $j['id']; ?>" name="deskripsi" required><?= set_value('deskripsi', $j['deskripsi']); ?></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="code_jurusan<?= $j['id']; ?>">Code Jurusan</label>
                    <input type="text" class="form-control" id="code_jurusan<?= $j['id']; ?>" name="code_jurusan" value="<?= set_value('code_jurusan', $j['code_jurusan']); ?>" required>
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
<?php endforeach; ?>