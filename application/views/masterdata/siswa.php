<!-- Begin Page Content -->
<div class="container-fluid">

  <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

  <div class="row">
    <div class="col-lg">

      <?php if (validation_errors()) : ?>
        <div class="alert alert-danger" role="alert">
          <?= validation_errors(); ?>
        </div>
      <?php endif; ?>

      <?= $this->session->flashdata('message'); ?>

      <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
        Add New Siswa
      </a>

      <a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#filterSiswaModal">
        Filter Siswa
      </a>

      <table class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama Siswa</th>
            <th>Tanggal Lahir</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>Email</th>
            <th>Nomor WhatsApp</th>
            <th>Password</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php $i = 1; foreach ($siswa as $s): ?>
            <tr>
              <th scope="row"><?= $i++; ?></th>
              <td><?= htmlspecialchars($s->nama_siswa); ?></td>
              <td><?= date('d M Y', strtotime($s->tanggal_lahir)); ?></td>
              <td><?= htmlspecialchars($s->nama_kelas); ?></td>
              <td><?= htmlspecialchars($s->nama_jurusan); ?></td>
              <td><?= htmlspecialchars($s->email); ?></td>

              <td><?= htmlspecialchars($s->nomor_whatsapp ?? '-'); ?></td>

              <td><?= isset($s->password) ? '******' : ''; ?></td>

              <td>
                <a href="#" class="badge bg-info text-white"
                   data-bs-toggle="modal"
                   data-bs-target="#editSiswaModal<?= $s->id; ?>">Edit</a>

                <a href="<?= base_url('siswa/delete/' . $s->id); ?>"
                   class="badge bg-danger text-white"
                   onclick="return confirm('Yakin ingin menghapus siswa ini?');">
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

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1">
  <div class="modal-dialog">
    <form action="<?= base_url('siswa/store') ?>" method="POST">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Tambah Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="form-group mb-2">
            <label>Nama Siswa</label>
            <input type="text" name="nama_siswa" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <label>Kelas</label>
            <select name="id_kelas" class="form-control" required>
              <option value="">-- Pilih Kelas --</option>
              <?php foreach($kelas as $k): ?>
                <option value="<?= $k['id'] ?>"><?= $k['kelas'] ?> (<?= $k['nama_jurusan'] ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="form-group mb-2">
            <label>Nomor WhatsApp</label>
            <input type="text" name="nomor_whatsapp" class="form-control" placeholder="08xxxxxxxxxx">
          </div>

          <div class="form-group mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>

      </div>
    </form>
  </div>
</div>


<!-- Modal Edit -->
<?php foreach($siswa as $s): ?>
<div class="modal fade" id="editSiswaModal<?= $s->id ?>" tabindex="-1">
  <div class="modal-dialog">
    <form action="<?= base_url('siswa/update/' . $s->id) ?>" method="POST">

      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Edit Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="form-group mb-2">
            <label>Nama Siswa</label>
            <input type="text" name="nama_siswa" class="form-control"
                   value="<?= htmlspecialchars($s->nama_siswa) ?>" required>
          </div>

          <div class="form-group mb-2">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir"
                   class="form-control" value="<?= $s->tanggal_lahir ?>" required>
          </div>

          <div class="form-group mb-2">
            <label>Kelas</label>
            <select name="id_kelas" class="form-control" required>
              <?php foreach($kelas as $k): ?>
                <option value="<?= $k['id'] ?>" 
                  <?= $k['id'] == $s->id ? 'selected' : '' ?>>
                  <?= $k['kelas'] ?> (<?= $k['nama_jurusan'] ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="<?= htmlspecialchars($s->email) ?>" required>
          </div>

          <div class="form-group mb-2">
            <label>Nomor WhatsApp</label>
            <input type="text" name="nomor_whatsapp" class="form-control"
                   value="<?= htmlspecialchars($s->nomor_whatsapp ?? '') ?>">
          </div>

          <div class="form-group mb-2">
            <label>Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="form-control">
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>

      </div>
    </form>
  </div>
</div>
<?php endforeach; ?>
