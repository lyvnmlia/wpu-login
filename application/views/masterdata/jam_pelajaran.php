<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Jam Pelajaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="container-fluid py-4">
    <h3 class="mb-4">📚 Data Jam Pelajaran</h3>

    <!-- Tombol Tambah -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus"></i> Tambah Jam Pelajaran
    </button>

    <!-- Tabel Data -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>No</th>
                        <th>Jam Ke</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($jam)): ?>
                        <?php $no = 1; foreach ($jam as $row): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $row['jam_ke'] ?></td>
                                <td class="text-center"><?= $row['waktu_mulai'] ?></td>
                                <td class="text-center"><?= $row['waktu_selesai'] ?></td>
                                <td class="text-center">
                                    <a href="" class="badge bg-info text-white" 
                                       data-bs-toggle="modal" 
                                       data-bs-target="#modalEdit<?= $row['id_jam'] ?>">
                                        Edit
                                    </a>
                                    <a href="<?= site_url('jam_pelajaran/hapus/'.$row['id_jam']) ?>" 
                                       onclick="return confirm('Yakin ingin menghapus jam ini?')"
                                       class="badge bg-danger text-white">
                                       Hapus
                                    </a>
                                </td>
                            </tr>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="modalEdit<?= $row['id_jam'] ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $row['id_jam'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= site_url('jam_pelajaran/edit/'.$row['id_jam']) ?>" method="post">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title text-dark" id="modalEditLabel<?= $row['id_jam'] ?>">Edit Jam Pelajaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Jam Ke</label>
                                                    <input type="text" class="form-control" name="jam_ke" value="<?= $row['jam_ke'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Waktu Mulai</label>
                                                    <input type="time" class="form-control" name="waktu_mulai" value="<?= $row['waktu_mulai'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Waktu Selesai</label>
                                                    <input type="time" class="form-control" name="waktu_selesai" value="<?= $row['waktu_selesai'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal Edit -->

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data jam pelajaran.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= site_url('jam_pelajaran/tambah') ?>" method="post">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalTambahLabel">Tambah Jam Pelajaran</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jam Ke</label>
                        <input type="text" class="form-control" name="jam_ke" placeholder="Contoh: 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" name="waktu_mulai" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control" name="waktu_selesai" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- End Modal Tambah -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
