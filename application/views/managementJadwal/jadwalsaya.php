<div class="container-fluid">
    <h2 class="my-4">Jadwal Kelas <?= $info->nama_kelas ?> - <?= $info->nama_jurusan ?></h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-dark">
                <tr>
                    <th>Jam Ke</th>
                    <th>Waktu</th>
                    <th>Senin</th>
                    <th>Selasa</th>
                    <th>Rabu</th>
                    <th>Kamis</th>
                    <th>Jumat</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rows = [];
                foreach($jadwal as $j){
                    $rows[$j->jam_ke]['waktu'] = $j->waktu_mulai . " - " . $j->waktu_selesai;
                    $rows[$j->jam_ke][$j->hari] = $j->name_mapel;
                }
                ?>

                <?php foreach($rows as $jam_ke => $row): ?>
                    <tr>
                        <td>Jam <?= $jam_ke ?></td>
                        <td><?= $row['waktu'] ?></td>
                        <td><?= isset($row['Senin']) ? $row['Senin'] : '-' ?></td>
                        <td><?= isset($row['Selasa']) ? $row['Selasa'] : '-' ?></td>
                        <td><?= isset($row['Rabu']) ? $row['Rabu'] : '-' ?></td>
                        <td><?= isset($row['Kamis']) ? $row['Kamis'] : '-' ?></td>
                        <td><?= isset($row['Jumat']) ? $row['Jumat'] : '-' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
