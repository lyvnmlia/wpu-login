<!-- Pastikan sudah include Bootstrap di <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container-fluid mt-4">
    <h2 class="mb-4">Pilih Jadwal Pelajaran</h2>

    <form id="formJadwal" class="row g-3">
        <div class="col-md-4">
            <label for="kelas" class="form-label">Kelas & Jurusan:</label>
            <select name="id_kelas" id="kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach($kelas as $k): ?>
                    <option value="<?= $k->id ?>">
                        <?= $k->nama ?> - <?= $k->nama_jurusan ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-4">
            <label for="semester" class="form-label">Semester:</label>
            <select name="semester" id="semester" class="form-select" required>
                <option value="">-- Pilih Semester --</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="tahun_ajaran" class="form-label">Tahun Ajaran:</label>
            <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" placeholder="contoh: 2025/2026" required>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary mt-3">Lihat Jadwal</button>
        </div>
    </form>
</div>
</div>

<script>
document.getElementById('formJadwal').addEventListener('submit', function(e){
    e.preventDefault();
    var id_kelas = document.getElementById('kelas').value;
    var semester = document.getElementById('semester').value;
    var tahun = document.getElementById('tahun_ajaran').value;
    if(id_kelas && semester && tahun){
        window.location.href = "<?= site_url('jadwal/lihat') ?>/" + id_kelas + "/" + semester + "/" + tahun;
    }
});
</script>
