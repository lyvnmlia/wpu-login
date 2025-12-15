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
   
            <!-- Tombol Add New Kelas -->
            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newKelasModal">  
                Add New Kelas
            </a>

           <!-- Tombol Filter Kelas -->
            <button type="button" class="btn btn-success mb-3 ms-2" data-bs-toggle="modal" data-bs-target="#filterKelasModal">
                Filter Kelas
            </button>

            <ul class="dropdown-menu">
                <?php foreach ($jurusan as $j): ?>
                <li><a class="dropdown-item" href="#" data-id="<?= $j['id']; ?>"><?= htmlspecialchars($j['nama']); ?></a></li>
                <?php endforeach; ?>
            </ul>
            </div>

            <script>
            document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function(e){
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const name = this.textContent;
                alert(`Jurusan dipilih: ${name} (ID: ${id})`);
                // Tambahkan logika lain di sini, misal update hidden input, kirim ajax, dll
            });
            });
            </script>

            <!-- Tabel Kelas -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Code kelas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($kelas as $k): ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= isset($k['nama']) ? $k['nama'] : (isset($k['kelas']) ? $k['kelas'] : ''); ?></td>
                            <td><?= isset($k['nama_jurusan']) ? $k['nama_jurusan'] : (isset($k['jurusan']) ? $k['jurusan'] : ''); ?></td>
                            <td><?= isset($k['code_kelas']) ? $k['code_kelas'] : ''; ?></td>

                            <td> 
                                <!-- Tombol Edit -->
                                <a href="#" class="badge bg-info text-white" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#editKelasModal<?= $k['id']; ?>">Edit</a>

                                <!-- Tombol Delete -->
                                <a href="<?= base_url('kelas/delete/' . $k['id']); ?>" 
                                   class="badge bg-danger text-white"
                                   onclick="return confirm('Apakah anda yakin ingin menghapus kelas ini?');">
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
                    </div>
<!-- End of Container -->

<!-- =============================== -->
<!-- Modal Tambah Jurusan -->
<div class="modal fade" id="newKelasModal" tabindex="-1" aria-labelledby="newKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="newKelasModalLabel">Add New Kelas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?= base_url('kelas'); ?>" method="post">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group mb-2">
                    <label for="deskripsi">Jurusan</label>
                    <select class="form-control" id="id_jurusan" name="id_jurusan" required>
                    <option value="">Jurusan</option>
                    <?php foreach($jurusan as $j): ?>
                    <option value="<?= $j['id']; ?>" >
                    <?= $j['nama']; ?>
                    </option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="code_jurusan">Code Kelas</label>
                    <input type="text" class="form-control" id="code_kelas" name="code_kelas" required>
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
<?php foreach ($kelas as $k): ?>
<div class="modal fade" id="editKelasModal<?= $k['id']; ?>" tabindex="-1" aria-labelledby="editKelasModalLabel<?= $k['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editKelasModalLabel<?= $k['id']; ?>">Edit Kelas</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?= base_url('kelas/edit/' . $k['id']); ?>" method="post">
            <input type="hidden" name="id" value="<?= $k['id']; ?>">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="nama<?= $k['id']; ?>">Nama</label>
                    <input type="text" class="form-control" id="nama<?= $k['id']; ?>" name="nama" 
                        value="<?= set_value('nama', $k['nama'] ?? ''); ?>" required>
                </div>
                <div class="form-group mb-2">
                    <label for="deskripsi<?= $k['id']; ?>">Jurusan</label>
                    <select class="form-control" id="id_jurusan<?= $k['id']; ?>" name="id_jurusan" required>
                        <?php foreach($jurusan as $j): ?>
                            <option value="<?= $j['id']; ?>" 
                                <?= (($k['id_jurusan'] ?? '') == $j['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($j['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="code_kelas<?= $k['id']; ?>">Code kelas</label>
                    <input type="text" class="form-control" id="code_kelas<?= $k['id']; ?>" name="code_kelas" 
                        value="<?= set_value('code_kelas', $k['code_kelas'] ?? ''); ?>" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>

        </div>
    </div>
</div>
<?php endforeach; ?>


<!-- Modal Filter Kelas -->
<div class="modal fade" id="filterKelasModal" tabindex="-1" aria-labelledby="filterKelasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="filterKelasForm" action="<?= base_url('kelas'); ?>" method="GET">
            <div class="modal-header">
            <h5 class="modal-title" id="filterKelasModalLabel">Filter Kelas Berdasarkan Jurusan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-4">
            </div>

            <form action="<?= base_url('masterdata/kelas'); ?>" method="post" class="mb-3">
                <div class="input-group">
                    <select name="m_jurusan" class="form-select" required>
                        <option value="all" selected>-- Semua Jurusan --</option>
                    <?php foreach ($jurusan as $j): ?>
                        <option value="<?= $j['id']; ?>"><?= htmlspecialchars($j['nama']); ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
</div>

<div class="container mt-4">
    <h2>
        <?= isset($m_jurusan) && $m_jurusan
            ? 'Kelas untuk Jurusan: ' . htmlspecialchars($m_jurusan['nama_jurusan'])
            :''; ?>
    </h2>
</div>

<!-- <div id="selectJurusanContainer"></div> -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data jurusan dari PHP
    const jurusanList = <?= json_encode($m_jurusan); ?> || [];

    const container = document.getElementById('selectJurusanContainer');
    if (!container) {
        console.error('Container selectJurusanContainer tidak ditemukan di DOM.');
        return;
    }

    const select = document.createElement('select');
    select.className = 'form-select';
    select.style.width = '250px';
    select.id = 'selectJurusan';

    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = '-- Pilih Jurusan --';
    select.appendChild(defaultOption);

    jurusanList.forEach(j => {
        const option = document.createElement('option');
        option.value = j.id;
        option.textContent = j.nama;
        select.appendChild(option);
    });

    container.appendChild(select);

    select.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            alert('Jurusan dipilih: ' + selected.text + ' (ID: ' + selected.value + ')');
            // Contoh redirect:
            // window.location.href = "<?= base_url('kelas?m_jurusan='); ?>" + selected.value;
        }
    });
});
</script>

