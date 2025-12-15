<div class="container-fluid">

    <h2>
        Jadwal Kelas <?= $info->nama_kelas ?> - <?= $info->nama_jurusan ?>
    </h2>
    <p>
        Semester: <?= $semester ?> | Tahun Ajaran: <?= $tahun ?>
    </p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Jadwal Pelajaran
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:60px">Jam Ke</th>
                            <th style="width:140px">Waktu</th>
                            <th>Senin</th>
                            <th>Selasa</th>
                            <th>Rabu</th>
                            <th>Kamis</th>
                            <th>Jumat</th>
                            <th style="width:120px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat'];
                        ?>

                        <?php if (!empty($jadwal)) : ?>

                            <?php foreach ($jadwal as $jam_ke => $dataJam) : ?>

                                <?php
                                // ambil waktu dari salah satu hari yang punya jadwal
                                $waktu_mulai = '-';
                                $waktu_selesai = '-';

                                foreach ($dataJam as $item) {
                                    if (!empty($item['jadwal'])) {
                                        $waktu_mulai  = $item['jadwal']['waktu_mulai'];
                                        $waktu_selesai = $item['jadwal']['waktu_selesai'];
                                        break;
                                    }
                                }
                                ?>

                                <tr>
                                    <td class="text-center"><?= $jam_ke ?></td>
                                    <td><?= $waktu_mulai ?> - <?= $waktu_selesai ?></td>

                                    <!-- Kolom hari -->
                                    <?php foreach ($hariList as $h) : ?>
                                        <td>
                                            <?php
                                            $mapel = '-';
                                            foreach ($dataJam as $item) {
                                                if ($item['hari'] === $h && !empty($item['jadwal'])) {
                                                    $mapel = $item['jadwal']['name_mapel'];
                                                    break;
                                                }
                                            }
                                            echo $mapel;
                                            ?>
                                        </td>
                                    <?php endforeach; ?>

                                    <!-- Kolom aksi -->
                                    <td>
                                        <?php foreach ($hariList as $h) : ?>
                                            <?php
                                            foreach ($dataJam as $item) :
                                                if ($item['hari'] === $h && !empty($item['jadwal'])) :
                                                    $id = $item['jadwal']['id'];
                                            ?>
                                                <a href="<?= base_url('jadwal/edit/' . $id) ?>"
                                                   class="btn btn-warning btn-sm mb-1">
                                                    Edit
                                                </a>
                                                <a href="<?= base_url('jadwal/hapus/' . $id) ?>"
                                                   class="btn btn-danger btn-sm mb-1"
                                                   onclick="return confirm('Yakin ingin menghapus?')">
                                                    Hapus
                                                </a>
                                                <br>
                                            <?php
                                                endif;
                                            endforeach;
                                            ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php else : ?>

                            <tr>
                                <td colspan="8" class="text-center">
                                    Tidak ada data jadwal
                                </td>
                            </tr>

                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
