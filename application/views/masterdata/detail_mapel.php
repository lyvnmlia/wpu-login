<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= htmlspecialchars($title); ?></h1>

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
            <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newDetailModal">
                Add New Detail
            </a>

            <!-- Tabel Mapel -->
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Materi</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // var_dump($detail);
                     $i = 1; foreach ($detail as $m): 
                        // var_dump($m['h']);
                        
                        ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>

                            <td><?= htmlspecialchars(mb_strimwidth($m['materi'], 0, 50, '...')); ?></td>
                             <td> <!-- Tombol Edit -->
                                <a href="javascript:void(0);" class="badge bg-info text-white" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editMapelModal<?= htmlspecialchars($m['id']); ?>">
                                Edit
                                </a>

                                <!-- Tombol Delete -->
                                <a href="<?= base_url('mapel/hapusdetail/' . urlencode($m['id'])); ?>" 
                                class="badge bg-danger text-white"
                                onclick="return confirm('Apakah anda yakin ingin menghapus detail ini?');">
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
<!-- End of Container -->

<!-- Modal Detail Mapel -->
<div class="modal fade" id="newDetailModal" tabindex="-1" aria-labelledby="newDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDetailModalLabel">Detail Mapel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="detailMapelForm" action="<?= base_url('mapel/savedetail'); ?>" method="post">
                <input type="hidden" id="id_mapel" name="id_mapel" value='<?= $mapel['id']?>'/>
                <div class="mb-3">
                    <label for="materi" class="form-label">Materi</label>
                    <textarea class="form-control" id="materi" name="materi" rows="3" ></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

          </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
 <?php $i = 1; foreach ($detail as $m): ?>
<div class="modal fade" id="editMapelModal<?= $m['id']; ?>" tabindex="-1" aria-labelledby="editMapelModalLabel<?= $m['id']; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editMapelModalLabel<?= $m['id']; ?>">Edit Mapel</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?= base_url('mapel/editdetail/' . $m['id']); ?>" method="post">
            <input type="hidden" name="id" value="<?= $m['id']; ?>">
            <div class="modal-body">
                 <input type="hidden" id="id_mapel" name="id_mapel" value='<?= $m['id_mapel']?>'/>
                  <div class="mb-3">
                      <label for="materi" class="form-label">Materi</label>
                      <textarea class="form-control" id="materi" name="materi" rows="3" ><?= $m['materi']?></textarea>
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

<!-- Script untuk mengisi modal Detail Mapel saat dibuka -->
<script>
    // Tunggu sampai DOM (elemen HTML) selesai dimuat
    // document.addEventListener('DOMContentLoaded', function() {
    //     var detailModal = document.getElementById('detailMapelModal');
        
    //     // Cek apakah elemen modal ditemukan
    //     if (detailModal) {
    //         // Event listener untuk saat modal akan ditampilkan (show.bs.modal)
    //         detailModal.addEventListener('show.bs.modal', function (event) {
    //             // Tombol/link yang memicu modal
    //             var button = event.relatedTarget; 

    //             // Ambil data dari atribut data-*
    //             var id = button.getAttribute('data-id');
    //             var name = button.getAttribute('data-name');
    //             var materi = button.getAttribute('data-materi');

    //             // Cari elemen-elemen di dalam modal
    //             var mapelIdInput = detailModal.querySelector('#mapel_id');
    //             var namaMapelInput = detailModal.querySelector('#nama_mapel');
    //             var materiTextarea = detailModal.querySelector('#materi');

    //             // Isi konten modal jika elemen ditemukan
    //             if (mapelIdInput) {
    //                 mapelIdInput.value = id;
    //             }
    //             if (namaMapelInput) {
    //                 namaMapelInput.value = name;
    //             }
    //             if (materiTextarea) {
    //                 // Gunakan textContent atau innerHTML jika ingin menampilkan HTML, tapi value sudah benar untuk textarea
    //                 materiTextarea.value = materi; 
    //             }
    //         });
    //     }
    // });
</script>
