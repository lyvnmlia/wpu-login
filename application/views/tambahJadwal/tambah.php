<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jadwal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container-fluid mt-4">

    <h2 class="mb-4">Tambah Jadwal</h2>

    <!-- Alert Sukses / Error -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Jadwal</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('jadwal/simpan') ?>" method="POST">

                <div class="form-group">
                    <label for="id_kelas">Kelas :</label>
                    <select name="id_kelas" id="id_kelas" class="form-control" required>
                        <option value="">-- pilih kelas --</option>
                        <?php foreach($kelas as $k): ?>
                            <option value="<?= $k['id'] ?>"><?= $k['kelas'] ?> - <?= $k['nama_jurusan'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="semester">Semester :</label>
                    <select name="semester" id="semester" class="form-control" required>
                        <option value="">-- pilih semester --</option>
                        <option value="Ganjil">Ganjil</option>
                        <option value="Genap">Genap</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="tahun_ajaran">Tahun Ajaran :</label>
                    <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" placeholder="contoh: 2025/2026" required>
                </div>

                <div class="form-group">
                    <label for="hari">Hari :</label>
                    <select name="hari" id="hari" class="form-control" required>
                        <option value="">-- pilih hari --</option>
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                    </select>
                </div>
                
                <!-- JAM KE -->
                <div class="form-group">
                    <label for="jam_ke">Jam Ke :</label>
                    <select name="jam_ke" id="jam_ke" class="form-control" required>
                        <option value="">-- pilih jam ke --</option>
                        <?php if(!empty($jam_pelajaran)): ?>
                            <?php foreach($jam_pelajaran as $jp): ?>
                                <option value="<?= $jp->id_jam ?>">Jam ke <?= $jp->jam_ke ?></option>

                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- WAKTU MULAI -->
                <div class="form-group">
                    <label for="waktu_mulai">Waktu Mulai :</label>
                    <select name="waktu_mulai" id="waktu_mulai" class="form-control" required>
                        <option value="">-- pilih waktu mulai --</option>
                        <?php if(!empty($jam_pelajaran)): ?>
                            <?php foreach($jam_pelajaran as $jp): ?>
                                <option value="<?= $jp->waktu_mulai ?>"><?= $jp->waktu_mulai ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- WAKTU SELESAI -->
                <div class="form-group">
                    <label for="waktu_selesai">Waktu Selesai :</label>
                    <select name="waktu_selesai" id="waktu_selesai" class="form-control" required>
                        <option value="">-- pilih waktu selesai --</option>
                        <?php if(!empty($jam_pelajaran)): ?>
                            <?php foreach($jam_pelajaran as $jp): ?>
                                <option value="<?= $jp->waktu_selesai ?>"><?= $jp->waktu_selesai ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- MATA PELAJARAN -->
                <div class="form-group">
                    <label for="id_mapel">Mata Pelajaran :</label>
                    <select name="id_mapel" id="id_mapel" class="form-control" required>
                        <option value="">-- pilih mapel --</option>
                        <?php if(!empty($mapel)): ?>
                            <?php foreach($mapel as $m): ?>
                                <option value="<?= $m->id ?>"><?= $m->name_mapel ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>


                <!-- Tombol Simpan -->
                <button type="submit" class="btn btn-primary">Simpan</button>

            </form>
        </div>
    </div>
    </div>
</div>

</div>
</body>
</html>
