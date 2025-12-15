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

            <!-- Tombol Tambah Mapel -->
            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newMapelModal">
                Add New Mapel
            </a>

             <!-- Tombol Filter Mapel -->
            <button type="button" class="btn btn-success mb-3 ms-2" data-bs-toggle="modal" data-bs-target="#filterMapelModal">
                Filter Mapel
            </button>

            <ul class="dropdown-menu">
                <?php foreach ($kelas as $k): ?>
                <li><a class="dropdown-item" href="#" data-id="<?= $k['id']; ?>"><?= htmlspecialchars($k['nama']); ?></a></li>
                <?php endforeach; ?>
            </ul>
            </div>

            <script>
            document.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', function(e){
                e.preventDefault();
                const id = this.getAttribute('data-id');
                const name = this.textContent;
                alert(`Kelas dipilih: ${name} (ID: ${id})`);
                // Tambahkan logika lain di sini, misal update hidden input, kirim ajax, dll
            });
            });
            </script>

            <!-- Tabel Mapel -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kelas</th>
                        <th>Name Mapel</th>
                        <th>Code Mapel</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; foreach ($mapel as $m): ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= htmlspecialchars($m['nama']); ?></td>
                            <td><?= htmlspecialchars($m['name_mapel']); ?></td>
                            <td><?= htmlspecialchars($m['code_mapel']); ?></td>
                            <td>
                                <!-- Tombol Detail -->
                                <a href="<?= base_url('mapel/detail/' . (int)$m['id']); ?>" class="badge bg-secondary text-white">
                                    Detail
                                </a>
                                <!-- Tombol Edit -->
                                <a href="javascript:void(0);" class="badge bg-info text-white" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editMapelModal<?= htmlspecialchars($m['id']); ?>">
                                Edit
                                </a>

                                <!-- Tombol Delete -->
                                <a href="<?= base_url('mapel/delete/' . urlencode($m['id'])); ?>" 
                                class="badge bg-danger text-white"
                                onclick="return confirm('Apakah anda yakin ingin menghapus mapel ini?');">
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
<!-- Modal Tambah Mapel -->
<div class="modal fade" id="newMapelModal" tabindex="-1" aria-labelledby="newMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="newMapelModalLabel">Add New Mapel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?= base_url('mapel'); ?>" method="post">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="id_kelas">Kelas</label>
                    <select name="id_kelas" id="id_kelas" class="form-control" required>
                        <option value="">-- Select Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['id']; ?>" <?= set_select('id_kelas', $k['id']); ?>>
                                <?= htmlspecialchars($k['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="name_mapel">Name Mapel</label>
                    <textarea class="form-control" id="name_mapel" name="name_mapel" required></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="code_mapel">Code Mapel</label>
                    <input type="text" class="form-control" id="code_mapel" name="code_mapel" required>
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

<!-- Modal Edit -->
 <?php $i = 1; foreach ($mapel as $m): ?>
<div class="modal fade" id="editMapelModal<?= $m['id']; ?>" tabindex="-1" aria-labelledby="editMapelModalLabel<?= $m['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editMapelModalLabel<?= $m['id']; ?>">Edit Mapel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?= base_url('mapel/edit/' . $m['id']); ?>" method="post">
            <input type="hidden" name="id" value="<?= $m['id']; ?>">
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label for="nama">Kelas</label>
                    <select name="id_kelas" id="id_kelas" class="form-control" required>
                        <option value="">-- Select Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['id']; ?>" <?= ($k['id'] == $m['nama']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($k['nama']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <label for="name_mapel<?= $m['id']; ?>">Name Mapel</label>
                    <textarea class="form-control" id="name_mapel<?= $m['id']; ?>" name="name_mapel" required><?= set_value('name_mapel', $m['name_mapel']); ?></textarea>
                </div>
                <div class="form-group mb-2">
                    <label for="code_mapel<?= $m['id']; ?>">Code Mapel</label>
                    <input type="text" class="form-control" id="code_mapel<?= $m['id']; ?>" name="code_mapel" value="<?= set_value('code_mapel', $m['code_mapel']); ?>" required>
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

<!-- Modal Filter Mapel -->
<div class="modal fade" id="filterMapelModal" tabindex="-1" aria-labelledby="filterMapelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="filterMapelForm" action="<?= base_url('mapel'); ?>" method="GET">
            <div class="modal-header">
                <h5 class="modal-title" id="filterMapelModalLabel">Filter Mapel Berdasarkan Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container mt-4">
            </div>

            <form action="<?= base_url('masterdata/mapel'); ?>" method="post" class="mb-3">
                <div class="input-group">
                    <select name="m_kelas" id="m_kelas" class="form-select" required>
                        <option value="all" selected>-- Semua Kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k['id']; ?>"><?= htmlspecialchars($k['nama']); ?></option>
                        <?php endforeach; ?>
                    </select>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
            </form>
        </form>
    </div>
</div>
</div>


<!-- <div id="selectKelasContainer"></div> -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data kelas dari PHP
    const KelasList = <?= json_encode($m_kelas); ?> || [];

    const container = document.getElementById('selectKelasContainer');
    if (!container) {
        console.error('Container selectKelasContainer tidak ditemukan di DOM.');
        return;
    }

    const select = document.createElement('select');
    select.className = 'form-select';
    select.style.width = '250px';
    select.id = 'selectKelas';

    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = '-- Pilih Kelas --';
    select.appendChild(defaultOption);

    KelasList.forEach(k => {
        const option = document.createElement('option');
        option.value = k.id;
        option.textContent = j.nama;
        select.appendChild(option);
    });

    container.appendChild(select);

    select.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            alert('Kelas dipilih: ' + selected.text + ' (ID: ' + selected.value + ')');
            // Contoh redirect:
            // window.location.href = "<?= base_url('mapel?m_kelas='); ?>" + selected.value;
        }
    });
});
</script>